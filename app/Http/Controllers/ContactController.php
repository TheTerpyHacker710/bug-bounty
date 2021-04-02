<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs;
use App\Mail\ContactVendor;

class ContactController extends Controller
{
    public function send(Request $request) {
        $validatedData = request()->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|min:10|max:125',
            'message' => 'required|string|max:1000',
        ]);

        Mail::to('gdeacon99@localhost')->send(new ContactVendor($validatedData['name'], $validatedData['email'], $validatedData['message']));
    }
}
