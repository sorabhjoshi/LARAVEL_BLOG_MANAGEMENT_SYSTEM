<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\admin\department;
use Illuminate\Http\Request;

class Designation extends Controller
{
    public function AddDesignation(){
        $depname = department::all();
        return view('Blogbackend.Utils.AddDesignation',compact('depname'));
    }public function store() {
        $data = request()->validate([
            'Department' => 'required',
            'Designation' => 'required',
        ]);
    
        $depname = new \App\Models\Admin\Designation();
    
        $depname->department_id = $data['Department'];  
        $depname->designation_name = $data['Designation'];  
    
        $depname->save();
    
        return redirect()->route('Designation');
    }
    public function edit($id){   
        $designation = \App\Models\Admin\Designation::with('departments')->findOrFail($id);
        $departments = department::all(); // If you want to list all departments in the edit form
        return view('Blogbackend.Utils.EditDesignation', compact('designation', 'departments'));
    }

    // Update designation method
    public function update(Request $request, $id)
    {$data = request()->validate([
        'Department' => 'required',
        'Designation' => 'required',
    ]);

    $depname = \App\Models\Admin\Designation::findOrFail($id);

    $depname->department_id = $data['Department'];  
    $depname->designation_name = $data['Designation'];  

    $depname->save();

    return redirect()->route('Designation');
    }

    // Delete designation method
    public function destroy($id)
    {
        $designation = \App\Models\Admin\Designation::findOrFail($id);
        $designation->delete();
        
        return response()->json(['success' => 'Designation deleted successfully!']);
    }
}
