<?php

use App\Http\Controllers\ActiveReportsController;
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

Route::middleware(['auth:sanctum', 'verified'])->post(
    '/cancelVerification', [VerificationsController::class, 'cancel']
);

Route::middleware(['auth:sanctum', 'verified'])->get('/vendor', function () {
    if(Auth::user()->isVendor == 1){
        return Inertia::render('Vendor');
    }else{
        return abort(403);
    }
})->name('vendor');

Route::put('/update-skill', ['App\Http\Controllers\SkillController', 'update']);

//Admin Links

Route::middleware(['auth:sanctum', 'verified'])->get('/admin/dashboard', function () {
    return Inertia::render('Admin/Dashboard');
})->name('adminDashboard');

//Route::middleware(['auth:sanctum', 'verified'])->get('/admin/reports', function () {
//    return Inertia::render('Admin/Reports');
//})->name('Reports');

Route::get('/admin/reports', [ActiveReportsController::class, 'index'])
    ->name('Reports')
    ->middleware('auth');

Route::get('/admin/users', 'App\Http\Controllers\UsersController@index')->name('users.index');
Route::get('/admin/users/create', 'App\Http\Controllers\UsersController@create')->name('users.create');
Route::post('/admin/users', 'App\Http\Controllers\UsersController@store')->name('users.store');

Route::get('/admin/users/{user}/edit', 'App\Http\Controllers\UsersController@edit')->name('users.edit');
Route::patch('/admin/users/{user}', 'App\Http\Controllers\UsersController@update')->name('users.update');
Route::delete('/admin/users/{user}', 'App\Http\Controllers\UsersController@destroy')->name('users.destroy');
