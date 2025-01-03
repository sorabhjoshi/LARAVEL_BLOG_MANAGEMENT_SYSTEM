<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class department extends Controller
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

    public function getDepartmentById($id)
{
    try {
        $department = Department::find($id);
        
        if ($department) {
            return response()->json(['success' => true, 'data' => $department]);
        } else {
            return response()->json(['success' => false, 'message' => 'Department not found']);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}

public function updateDepartment(Request $request)
{
    try {
        $department = Department::find($request->id);
        
        if ($department) {
            $department->department_name = $request->departmentName;
            $department->save();

            return response()->json(['success' => true, 'message' => 'Department updated successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Department not found']);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}

}
