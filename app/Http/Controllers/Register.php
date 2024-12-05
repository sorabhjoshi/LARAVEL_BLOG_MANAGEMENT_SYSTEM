<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Register_model;
use function Laravel\Prompts\alert;
use Illuminate\Support\Facades\Hash;
class Register extends Controller
{
    public function registers(Request $request)
{
   
        $request->validate([
            'username' => 'required',
            'gender' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $userDetails = new Register_model();
        $userDetails->name = $request->input('username');
        $userDetails->gender = $request->input('gender');
        $userDetails->email = $request->input('email');
        $userDetails->password = bcrypt($request->input('password'));

        if ($userDetails->save()) {
            return redirect('/login')->with('success', 'Registration successful! Please log in.');
        } else {
            return redirect()->back()->with('error', 'Failed to save data.');
        }
    
}
public function updateprofile(Request $request)
    {
         

        $user = session('user');
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'email' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'password' => 'nullable|min:6', 
        ]);
        
        $userDetails = new Register_model();
        $userDetails->name = $request->input('name');
        $userDetails->gender = $request->input('gender');
        $userDetails->email = $request->input('email');
        $userDetails->city = $request->input('city');
        $userDetails->state = $request->input('state');
        $userDetails->country = $request->input('country');
        $userDetails->phoneno = $request->input('phone');
        
        
        if ($request->filled('password')) {
            $userDetails->password = bcrypt($request->input('password'));
        }else{
            $userDetails->password= $user->password;
        }

       
        if ($userDetails->update()) {
            session(['user' => $userDetails]);
            return redirect()->route('updateprofile')->with('success', 'Profile updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update profile.');
        }
    }


public function login(Request $request)
{
   
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = Register_model::where('email', $request->input('email'))->first();
        if (!$user) {
            return redirect()->back()->with('error', 'No user found with this email.');
        }

     if (!\Hash::check($request->input('password'), $user->password)) {
        
        
        return redirect()->back()->with('error', 'Invalid password.');
    }
    session(['user' => $user]);
    
    return redirect('/')->with('success', 'Login successful!');
}

}