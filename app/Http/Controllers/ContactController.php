<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $data = $request->only('name', 'email', 'subject', 'message');

        Mail::to('sorabhj2312@gmail.com')->send(new ContactFormMail($data));

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
