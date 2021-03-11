<?php

namespace App\Http\Controllers;

use App\Events\ReportSubmitted;
use App\Jobs\AssignVerifiers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\Report;

class ReportsController extends Controller
{
    public function create()
    {
        return Inertia::render('CreateReport');
    }

    public function store()
    {

        // validate form data
        $validatedData = request()->validate([
            'program_id' => 'required|integer',
            'procedure' => 'required|array|min:1|max:25',
            'procedure.*' => 'required|string|max:1000',
            'severity' => 'required|integer|min:1|max:5',
            'complexity' => 'required|integer|min:1|max:5',
            'reliability' => 'required|integer|min:1|max:5',
        ]);

        // re-encode the procedure details and add ID of current user
        $validatedData['procedure'] = json_encode($validatedData['procedure']);
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
