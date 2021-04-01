<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\activeReports;
use App\Models\VerificationAssignment;
use Inertia\Inertia;
use Carbon\Carbon;

class ActiveReportsController extends Controller
{
   public function index() {
        $activeReports = activeReports::with(['program:id,Title,Excerpt'])
            ->orderBy('created_at')
            ->get();

        $activeVerifications = VerificationAssignment::with(['verificationBatch:id,report_id', 'verificationBatch.report:id,procedure,program_id', 'verificationBatch.report.program:id,Title,Excerpt'])
           ->orderBy('created_at')
           ->get();

        return Inertia::render('Admin/Reports', [
            'activeReports' => $activeReports,
            'activeVerifications' => $activeVerifications
        ]);
   }

   public function show() {
        //show a single active report
   }

   public function create() {
        //show form to create new active report
   }

   public function store(Request $request) {
        //store a new active report
        $activeReport = new activeReports;
        $activeReport->user_id = (int)(request()->validate([
                                        'user_id' => 'integer'
                                   ])['user_id']);
        $activeReport->program_id = (int)(request()->validate([
                                        'program_id' => 'integer'
                                   ])['program_id']);
        $activeReport->save();

        if($request->origin) {
             return redirect('/program/'.$activeReport->program_id);
        }

        return redirect('/');
   }

   public function edit() {
        //edit an already existing active report
   }

   public function update() {
        //update the edited report
   }

   public function destroy() {
        //destroy an element of the active reports
   }
}
