<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    // Index method
    public function index()
    {
        $columns = ['id'];
        $data = DB::table("testing")->select($columns)->get();
        return view('Blogbackend.Testing.index', compact('columns', 'data'));
    }
    
    // Create method
    public function create()
    {
        return view('Blogbackend.Testing.create');
    }
    
    // Edit method
    public function edit($id)
    {
        $columns = ['id'];
        $text = DB::table('testing')->where('id', $id)->first();
        return view('Blogbackend.Testing.edit', compact('text', 'columns'));
    }
    
    // Store method
    public function store(Request $request)
    {
        // Define dynamic validation rules
        $rules = [];
        
        // Generate validation rules based on column types
        foreach (['id'] as $col) {
         if ($col == 'id') {
                continue;
            }
            $type = $inputTypes[$col] ?? 'string';  // Default to 'string' if no type is specified
            
            if ($type == 'text' || $type == 'string') {
                $rules[$col] = 'required|string|max:255';
            } elseif ($type == 'number' || $type == 'integer') {
                $rules[$col] = 'required|integer';
            } elseif ($type == 'email') {
                $rules[$col] = 'required|email';
            } elseif ($type == 'date') {
                $rules[$col] = 'required|date';
            } else {
                $rules[$col] = 'required';
            }
        }

        // Validate the incoming request data
        $validatedData = $request->validate($rules);
         $validatedData['image'] =$request->image;
        // Insert validated data into the database
        DB::table('testing')->insert($validatedData);

        return redirect('/Testing')->with('success', 'Testing created successfully.');
    }
    
    // Update method
    public function update(Request $request)
    {
        // Define dynamic validation rules
        $rules = [];
        
        // Generate validation rules based on column types
        foreach (['id'] as $col) {
            $type = $inputTypes[$col] ?? 'string';  // Default to 'string' if no type is specified
            
            // Skip the 'id' column for validation
            if ($col == 'id') {
                continue;
            }
            
            if ($type == 'text' || $type == 'string') {
                $rules[$col] = 'required|string|max:255';
            } elseif ($type == 'number' || $type == 'integer') {
                $rules[$col] = 'required|integer';
            } elseif ($type == 'email') {
                $rules[$col] = 'required|email';
            } elseif ($type == 'date') {
                $rules[$col] = 'required|date';
            } else {
                $rules[$col] = 'required';
            }
        }

        // Validate the incoming request data
        $validatedData = $request->validate($rules);
        $validatedData['image'] =$request->image;
        // Update validated data in the database
        DB::table('testing')->where('id', $request->id)->update($validatedData);

        return redirect('/Testing')->with('success', 'Testing updated successfully.');
    }
    
    // Delete method
    public function delete($id)
    {
        DB::table('testing')->where('id', $id)->delete();
        return redirect('/Testing')->with('success', 'Testing deleted successfully.');
    }
    //
}
