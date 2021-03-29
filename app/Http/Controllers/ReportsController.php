<?php

namespace App\Http\Controllers;

use App\Events\ReportSubmitted;
use App\Jobs\AssignVerifiers;
use App\Models\Program;
use App\Models\Tip;
use App\Services\ReportMetrics\ReportMetric;
use App\Services\ReportMetrics\VulnerabilityMetric;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\Report;

class ReportsController extends Controller
{
    protected $reportMetrics;

    public function __construct(VulnerabilityMetric ... $reportMetrics) {
        $this->reportMetrics = $reportMetrics;
    }

    public function create()
    {
        // get a relevant tip if one exists
        $tip = Tip::getNext(Auth::id(), 'report');

        $programs = Program::select('id', 'Title')->get();
        return Inertia::render('Reporting/CreateReport', [
            'reportMetrics' => $this->reportMetrics,
            'programs' => $programs,
            'tip' => $tip,
        ]);
    }

    public function store()
    {
        // validate form data
        $validatedData = request()->validate([
            'program_id' => 'required|integer',
            'procedure' => 'required|array|min:1|max:25',
            'procedure.*' => 'required|string|max:1000',
            'metrics' => 'required|array|min:1|max:25',
            'metrics.*' => 'required|integer',
            'title' => 'required|string|max:100',
        ]);

        // re-encode the procedure details and metrics and add ID of current user
        $validatedData['procedure'] = json_encode($validatedData['procedure']);
        $validatedData['metrics'] = json_encode($validatedData['metrics']);
        $validatedData['creator_id'] = Auth::id();

        // create report
        $report = Report::create($validatedData);

        // dispatch report creation event
        ReportSubmitted::dispatch($report);

        // dispatch verification assignment job
        AssignVerifiers::dispatch($report);

        return Redirect::route('dashboard');
    }
}
