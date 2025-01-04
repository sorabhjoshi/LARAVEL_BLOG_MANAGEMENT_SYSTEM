<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\admin\department;
use Illuminate\Http\Request;

class Departments extends Controller
{
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_name' => 'required|string|max:255',
        ]);

        $department = new \App\Models\admin\department();
        $department->department_name = $validated['department_name'];
        $department->save();

        return response()->json(['success' => true]);
    }

    // Method to fetch department by ID
    public function getDepartmentById($id)
    {
        $department = department::find($id);

        if ($department) {
            return response()->json([
                'success' => true,
                'department_name' => $department->department_name,
                'id' => $department->id,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Department not found',
            ], 404);
        }
    }

    // Method to update department
    public function updateDepartment(Request $request)
    {   
        $department = department::find($request->input('departmentId'));

        if ($department) {
            $department->department_name = $request->input('departmentName');
            $department->save();

            return redirect()->route('Department');
        } else {
            return redirect()->back();
        }
    }

    public function deleteDepartmentById($id){
        $department = department::find($id);

        if ($department) {
            $department->delete();
            
            session()->flash('success', 'Department deleted successfully!');
            return response()->json(['success' => true]);
        } else {
            session()->flash('error', 'Department not found!');
            return response()->json([
                'success' => false,
                'message' => 'Department not found',
            ], 404);
        }
    }
}

   