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
        // Add Pagination !!!!!
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
    
    public function vendorProgramStore(request $request){
        //Create a new program based on received data and store in database
        $request->validate([
           'Title' => 'required',
           'Description' => 'required',
        ]);

        
        Program::create([
           'Title' => $request->Title,
           'Description' => $request->Description,
           'Excerpt' => 'test',
           'vendorID' => Auth::user()->id,
           'Exclusive' => 0,
           'Vendor Approval' => 0,
        ]);

        return redirect()->route('Vendor');
    }
}
