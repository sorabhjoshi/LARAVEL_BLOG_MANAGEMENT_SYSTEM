<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Companydata;
class companydatas extends Controller
{
    public function addcompanydata(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'email' => 'required|email'
        ]);
        if (Companydata::create([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'email' => $request->input('email'),
        ])) {
            return redirect()->route('Company')->with('success', 'Blog updated successfully!');
        }else{
            return redirect()->back()->withErrors('error', 'Blog updated unsuccessful');
        }
        
       

    }
    
    public function editcompany(Request $request,$id){
        $userdata= Companydata::find($id);
        return view('Blogbackend.Utils.EditCompany', ['userdata' => $userdata]);
    }

    public function updatecompanydata(Request $request){
        $request->validate([
            'id' => 'required',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'email' => 'required|email'
        ]);
        if ($userdata =Companydata::find($request->input('id'))) {
            $userdata->name = $request->input('name');
            $userdata->type = $request->input('type');
            $userdata->email = $request->input('email');
            $userdata->save();
            return redirect()->route('Company')->with('success', 'Blog updated successfully!');
        }else{
            return redirect()->back()->withErrors('error', 'Blog updated unsuccessful');
        }

    }

    public function deletecompany(Request $request,$id){
        $userdata= Companydata::find($id);
        if ($userdata->delete()) {
            return redirect()->back()->with( key: 'Blog delete successful');
        } else {
            return redirect()->back()->withErrors('error', key: 'Blog delete unsuccessful');
        }
        
    }

    

    
}
