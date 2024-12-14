<?php

namespace App\Http\Controllers;

use App\Models\Register_model;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function editUser($id)
    {
        $userdata = \App\Models\Admin\Register_model::find($id);
        
        if ($userdata) {
            return view('Blogbackend.Utils.Edituser', ['userdata' => $userdata]);
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }
    public function updateuser(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'email' => 'required|email',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'phoneno' => 'required|numeric',
        ]);
    
       
        $user = Register_model::find($id);
    

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
    

        $user->name = $request->input('name');
        $user->gender = $request->input('gender');
        $user->email = $request->input('email');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->country = $request->input('country');
        $user->phoneno = $request->input('phone');
  
        if ($user->save()) {
          
            return redirect()->route('Users')->with('success', 'User updated successfully!');
        } else {
            
            return redirect()->back()->with('error', 'Failed to update user.');
        }
        
    }
    public function deleteuser($id)
    {
        $user = Register_model::find($id);
        
        
        if ($user->delete()) {
            return redirect()->route('Users')->with('success', 'User updated successfully!');
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }
    }
    
}
