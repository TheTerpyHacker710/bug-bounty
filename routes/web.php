<?php

use App\Http\Controllers\ActiveReportsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ProgramsController;
use App\Http\Controllers\VerificationsController;
use App\Http\Controllers\VendorController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\activeReports;
use App\Models\User;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;

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

Route::get('/', [ProgramsController::class, 'index'])->name('home');
Route::get('/program/{id}', [ProgramsController::class, 'show'])->name('ViewProgram');
Route::post('/', [ActiveReportsController::class, 'store'])->name('JoinProgram')->middleware('auth');
Route::post('/contact/sendmail', [ContactController::class, 'send'])->name('SendMail');
Route::post('/contact/sendmailvendor', [ContactController::class, 'sendVendor'])->name('SendMail');

Route::get('/about', function () {
    return Inertia::render('About', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('About');

Route::get('/contact', function () {
    return Inertia::render('Contact', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('Contact');

Route::get('/contact-vendor', [ContactController::class, 'indexVendor'])->name('ContactVendor');

Route::get('/help', function () {
    return Inertia::render('Help', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('Help');

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

Route::middleware(['auth:sanctum', 'verified'])->post(
    '/cancelVerification', [VerificationsController::class, 'cancel']
);

Route::put('/update-skill', ['App\Http\Controllers\SkillController', 'update']);

//Vendor Routes
Route::middleware('can:accessVendor')->group(function(){

    Route::middleware(['auth:sanctum', 'verified'])->get(
        '/vendor', [VendorController::class, 'vendorDashboard']
    )->name('Vendor');

    Route::middleware(['auth:sanctum', 'verified'])->post(
    '/program-delete', [VendorController::class, 'programDelete']);

    Route::post('/vendor-program', ['App\Http\Controllers\ProgramsController', 'vendorProgramStore']);

});

Route::get('/vendor-apply', [VendorController::class, 'vendorApply'])->name('vendorApply');


//Admin Links

Route::middleware('can:accessAdmin')->group(function(){
    
    Route::get('/admin/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('adminDashboard');

    Route::get('/admin/reports', [ActiveReportsController::class, 'index'])
        ->name('Reports')
        ->middleware('auth');
    
    Route::post('/approve', [VendorController::class, 'vendorApprove'])->name('approve');

    Route::get('/admin/users', 'App\Http\Controllers\UsersController@index')->name('users.index');
    Route::get('/admin/users/create', 'App\Http\Controllers\UsersController@create')->name('users.create');
    Route::post('/admin/users', 'App\Http\Controllers\UsersController@store')->name('users.store');

    Route::get('/admin/users/{user}/edit', 'App\Http\Controllers\UsersController@edit')->name('users.edit');
    Route::patch('/admin/users/{user}', 'App\Http\Controllers\UsersController@update')->name('users.update');
    Route::delete('/admin/users/{user}', 'App\Http\Controllers\UsersController@destroy')->name('users.destroy');

});
