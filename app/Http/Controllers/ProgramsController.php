<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Program;
use Auth;
class ProgramsController extends Controller
{
    public function index() {
        $programs = Program::select('id', 'Title', 'Excerpt')->get();

        if(Auth::user()){
            $activeReports = Auth::user()->activeReports->load('program');

            return Inertia::render('Welcome', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'programs' => $programs,
                'activeReports' => $activeReports,
            ]);
        }

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'programs' => $programs,
        ]);
    }

    public function show() {

    }

    public function create() {

    }

    public function store() {

    }

    public function edit() {
    
    }
    
    public function update() {

    }

    public function destroy() {
        
    }
}
