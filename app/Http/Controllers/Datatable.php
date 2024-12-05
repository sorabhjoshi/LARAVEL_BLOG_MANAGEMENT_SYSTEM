<?php

namespace App\Http\Controllers;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\Register_model;

class Datatable extends Controller
{
    public function getUsersAjax(Request $request)
    {
        try {
            $query = Register_model::select('id', 'name', 'gender', 'email', 'city', 'country', 'created_at');
            return DataTables::of($query)
                ->addColumn('edit', function ($row) {
                    return '<a href="/Edituser/' . $row->id . '" class="btn btn-sm delete-btn">Edit</a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/Deleteuser/' . $row->id . '" class="btn btn-sm edit-btn">Delete</a>';
                })
                ->rawColumns(['edit', 'delete'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    
    public function getblogAjax(Request $request)
    {
        try {
            $query = Blog::select('id','slug','userid', 'title', 'authorname', 'description','created_at');
            return DataTables::of($query)
                ->addColumn('edit', function ($row) {
                    return '<a href="/Edituser/' . $row->id . '" class="btn btn-sm delete-btn">Edit</a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/Deleteuser/' . $row->id . '" class="btn btn-sm edit-btn">Delete</a>';
                })
                ->rawColumns(['edit', 'delete'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
