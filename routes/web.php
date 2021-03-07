<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Models\activeReports;
use Inertia\Inertia;

use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    
    $activeReports = activeReports::all();

    return Inertia::render('Dashboard', [
        'activeReports' => $activeReports,
   ]);
   
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/report', function () {
    return Inertia::render('Reporting/Report');
})->name('report');

Route::middleware(['auth:sanctum', 'verified'])->get('/verify', function () {
    return Inertia::render('Reporting/Verify');
})->name('verify');