<?php

namespace App\Http\Controllers;

use App\Jobs\SendContactEmail;  // Import the job class
use Illuminate\Http\Request;

class mailcontroller extends Controller
{
    public function sendContactForm(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Get the validated data
        $data = $request->only(['name', 'email', 'message']);

        // Dispatch the job to send the email asynchronously
        SendContactEmail::dispatch($data);

        // Return back with a success message
        return back()->with('success', 'Your message has been sent successfully!');
    }
}
