<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Models\Program;
use App\Models\User;
use App\Mail\ContactUs;
use App\Mail\ContactVendor;
use Inertia\Inertia;
use Redirect;

class ContactController extends Controller
{
    public function send(Request $request) {
        $validatedData = request()->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|min:10|max:125',
            'message' => 'required|string|max:1000',
        ]);

        Mail::to('gdeacon99@localhost')->send(new ContactUs($validatedData));

        return Redirect::route('Contact');
    }

    public function sendVendor(Request $request) {
        $validatedData = request()->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|min:10|max:125',
            'message' => 'required|string|max:1000',
        ]);

        $vendor = request()->validate([
            'vendor' => 'required|string|max:125',
        ]);

        Mail::to($vendor)->send(new ContactVendor($validatedData));

        return Redirect::route('ContactVendor');
    }

    public function indexVendor() {
        $programs = Program::select('id', 'Title', 'VendorID')->with('user:id,email,username')->get();

        return Inertia::render('ContactVendor', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'programs' => $programs,
        ]);
    }
}
