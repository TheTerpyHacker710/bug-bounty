<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Models\activeReports;
use App\Models\Programs;
use App\Models\User;
use Inertia\Inertia;
Use Auth;

class DashboardController extends Controller
{
    public function index() {

        $activeReports = Auth::user()->activeReports->load('program');

        return Inertia::render('Dashboard', [
            'activeReports' => $activeReports,
        ]);
    }
}
