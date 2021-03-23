<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\activeReports;
use App\Models\VerificationAssignment;
use Inertia\Inertia;

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
        //create a new active report
   }

   public function store() {
        //store a new active report
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
