<?php

use App\Http\Controllers\ReportsController;
use App\Http\Controllers\VerificationsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\activeReports;
use App\Models\User;
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

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

Route::middleware(['auth:sanctum', 'verified'])->get(
    '/report', [ReportsController::class, 'create']
)->name('Report');

Route::middleware(['auth:sanctum', 'verified'])->post(
    '/report', [ReportsController::class, 'store']
)->name('storeReport');

Route::middleware(['auth:sanctum', 'verified'])->get(
    '/verify', [VerificationsController::class, 'create']
)->name('Verify');

Route::middleware(['auth:sanctum', 'verified'])->post(
    '/verify', [VerificationsController::class, 'store']
);

Route::middleware(['auth:sanctum', 'verified'])->get('/vendor', function () {
    if(Auth::user()->isVendor == 1){
        return Inertia::render('Vendor');
    }else{
        return abort(403);
    }
})->name('vendor');

Route::get('/registertags', ['App\Http\Controllers\SkillController', 'show']);
Route::post('/addtags', ['App\Http\Controllers\SkillController', 'store']);
