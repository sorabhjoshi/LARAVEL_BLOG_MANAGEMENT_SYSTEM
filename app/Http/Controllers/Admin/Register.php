<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Register_model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Register extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'gender' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Register_model::create([
            'name' => $request->input('username'),
            'gender' => $request->input('gender'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        if ($user) {
            return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
        }

        return redirect()->back()->with('error', 'Failed to save data.');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|string',
            'email' => "required|email|unique:users,email,{$user->id}",
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'phone' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->fill($request->only([
            'name', 'gender', 'email', 'city', 'state', 'country', 'phoneno',
        ]));

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        if ($user->save()) {
            return redirect()->route('profile')->with('success', 'Profile updated successfully!');
        }

        return redirect()->back()->with('error', 'Failed to update profile.');
    }

    public function login(Request $request)
    { 
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            session(['user' => Auth::user()]);
            return redirect()->route('home')->with('success', 'Registration successful! Please log in.');
        }

        return redirect()->back()->with('error', 'Invalid email or password.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
