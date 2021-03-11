<?php

namespace App\Http\Controllers;

use App\Events\VerificationBatchCompleted;
use App\Events\VerificationSubmitted;
use App\Jobs\EvaluateVerifications;
use App\Models\User;
use App\Models\VerificationAssignment;
use App\Models\VerificationSubmission;
use App\Services\VerificationEvaluators\VerificationEvaluator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class VerificationsController extends Controller
{
//    protected $verificationEvaluator;
//
//    public function __construct(VerificationEvaluator $verificationEvaluator)
//    {
//        $this->verificationEvaluator = $verificationEvaluator;
//    }

    public function create()
    {
        // get all user's verification assignments
        $assignments = VerificationAssignment::where('assignee_id', Auth::id())
            ->with(['verificationBatch:id,report_id', 'verificationBatch.report:id,procedure'])
            ->orderBy('created_at')
            ->get();

        return Inertia::render('Verify', [
            "assignments" => $assignments,
        ]);
    }

    public function store()
    {
        // validate form data
        $validatedData = request()->validate([
            'assignmentId' => 'required|integer|min:0',
            'verifiable' => 'required|boolean',
            'quality' => 'required|integer|min:1|max:5',
            'detail' => 'required|integer|min:1|max:5',
            'severity' => 'required|integer|min:1|max:5',
            'complexity' => 'required|integer|min:1|max:5',
            'reliability' => 'required|integer|min:1|max:5',
        ]);

        // change assignment ID key name
        $validatedData["verification_assignment_id"] = $validatedData["assignmentId"];
        unset($validatedData["assignmentId"]);

        // check the assignment is valid, pending and assigned to the current user
        $assignment = VerificationAssignment::whereId($validatedData["verification_assignment_id"])
            ->whereStatus("pending")
            ->whereAssigneeId(Auth::id())
            ->first();
        if (isset($assignment)) {
            // store submission in database
            $verificationSubmission = VerificationSubmission::create($validatedData);
            // mark assignment as completed
            $assignment->complete();
            // dispatch verification submission event
            VerificationSubmitted::dispatch($verificationSubmission);
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
}
