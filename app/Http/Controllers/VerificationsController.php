<?php

namespace App\Http\Controllers;

use App\Events\VerificationBatchCompleted;
use App\Events\VerificationSubmitted;
use App\Jobs\AddVerifer;
use App\Jobs\EvaluateVerifications;
use App\Models\User;
use App\Models\VerificationAssignment;
use App\Models\VerificationSubmission;
use App\Services\ReportMetrics\ProcedureMetric;
use App\Services\ReportMetrics\ReportMetric;
use App\Services\ReportMetrics\VulnerabilityMetric;
use App\Services\VerificationEvaluators\VerificationEvaluator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class VerificationsController extends Controller
{
    protected $vulnerabilityMetrics = array();

    protected $procedureMetrics = array();

    public function __construct(ReportMetric... $reportMetrics) {
        foreach ($reportMetrics as $metric) {
            if (is_subclass_of($metric, VulnerabilityMetric::class)) {
                array_push($this->vulnerabilityMetrics, $metric);
            } else if (is_subclass_of($metric, ProcedureMetric::class)) {
                array_push($this->procedureMetrics, $metric);
            }
        }
    }

    public function create()
    {
        // get all user's verification assignments
        $assignments = VerificationAssignment::where('assignee_id', Auth::id())
            ->where('status', '!=', 'cancelled')
            ->with(['verificationBatch:id,report_id', 'verificationBatch.report:id,title,procedure'])
            ->orderByDesc('created_at')
            ->get();

        if(request()->get('assignment')) {
            $selectedAssignment = (int)(request()->validate([
                'assignment' => 'integer'
            ])['assignment']);
            return Inertia::render('Reporting/Verify', [
                "assignments" => $assignments,
                "selectedAssignment" => $selectedAssignment,
                'vulnerabilityMetrics' => $this->vulnerabilityMetrics,
                'procedureMetrics' => $this->procedureMetrics,
            ]);

        }
        else if($assignments->first()) {
            $selectedAssignment = $assignments->first()->id;
            return Inertia::render('Reporting/Verify', [
                "assignments" => $assignments,
                "selectedAssignment" => $selectedAssignment,
                'vulnerabilityMetrics' => $this->vulnerabilityMetrics,
                'procedureMetrics' => $this->procedureMetrics,
            ]);
        }
        else {
            return Inertia::render('Reporting/Verify', [
                "assignments" => $assignments,
                'vulnerabilityMetrics' => $this->vulnerabilityMetrics,
                'procedureMetrics' => $this->procedureMetrics,
            ]);
        }
    }

    public function store()
    {
        // validate form data
        $validatedData = request()->validate([
            'assignmentId' => 'required|integer|min:0',
            'verifiable' => 'required|boolean',
            'vulnerabilityMetrics' => 'required|array|min:1|max:25',
            'vulnerabilityMetrics.*' => 'required|integer',
            'procedureMetrics' => 'required|array|min:1|max:25',
            'procedureMetrics.*' => 'required|integer',
        ]);

        // check the assignment is valid, pending and assigned to the current user
        $assignment = VerificationAssignment::whereId($validatedData["assignmentId"])
            ->whereStatus("pending")
            ->whereAssigneeId(Auth::id())
            ->first();
        if (isset($assignment)) {
            // store submission in database
            $s = new VerificationSubmission;
            $s->verification_assignment_id = $validatedData['assignmentId'];
            $s->verifiable = $validatedData['verifiable'];
            $s->vulnerability_metrics = $validatedData['vulnerabilityMetrics'];
            $s->procedure_metrics = $validatedData['procedureMetrics'];
            $s->save();
            // mark assignment as completed
            $assignment->complete();
            // dispatch verification submission event
            VerificationSubmitted::dispatch($s);
            // check whether any pending assignments remain in the same batch
            $verificationBatch = $assignment->verificationBatch;
            if ($verificationBatch->isReady()) {
                // dispatch job to calculate whether report is accepted,
                // rejected, or reassigned to new batch
                EvaluateVerifications::dispatch($verificationBatch);
            }
        }
        return Redirect::route('dashboard');
    }

    public function cancel() {

        $validatedData = request()->validate([
            'id' => 'required|integer',
        ]);

        $id = $validatedData["id"];

        // check the assignment is valid, pending and assigned to the current user
        $assignment = VerificationAssignment::whereId($id)
            ->whereStatus("pending")
            ->whereAssigneeId(Auth::id())
            ->first();
        if (isset($assignment)) {
            $assignment->status = 'cancelled';
            $assignment->save();
            AddVerifer::dispatch($assignment->verificationBatch);
        }

        // assign new verifier

        return Redirect::route('dashboard');
    }
}
