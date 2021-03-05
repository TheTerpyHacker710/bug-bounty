<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\activeReports;
use Inertia\Inertia;

class DashboardController extends Controller
{
   public function show() {
       $reports = activeReports::all();
       return Inertia::render('Dashboard', [
            'reports' => $reports,
       ]);
    }
}