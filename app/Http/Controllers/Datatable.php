<?php

namespace App\Http\Controllers;
use App\Models\Newscat;
use App\Models\Pages;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Blog;
use App\Models\Blogcat;
use App\Models\News;
use Illuminate\Http\Request;
use App\Models\Register_model;

class Datatable extends Controller
{
    public function getUsersAjax(Request $request)
    {
        try {
            
            $query = Register_model::select('id', 'name', 'gender', 'email', 'city', 'country', 'created_at');
    
            
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->input('startDate');
                $endDate = $request->input('endDate');
    
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
    
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
            $query = Blog::select('id','slug','userid', 'title', 'authorname', 'category','created_at');
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->input('startDate');
                $endDate = $request->input('endDate');
    
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
            return DataTables::of($query)
                ->addColumn('edit', function ($row) {
                    return '<a href="/Editblog/' . $row->id . '" class="btn btn-sm delete-btn">Edit</a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/Deleteblog/' . $row->id . '" class="btn btn-sm edit-btn">Delete</a>';
                })
                ->rawColumns(['edit', 'delete'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    
    public function getnewsAjax(Request $request)
    {
        try {
            $query = News::select('id','slug','userid', 'title', 'authorname', 'category','created_at');
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->input('startDate');
                $endDate = $request->input('endDate');
    
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
            return DataTables::of($query)
                ->addColumn('edit', function ($row) {
                    return '<a href="/EditNews/' . $row->id . '" class="btn btn-sm delete-btn">Edit</a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/DeleteNews/' . $row->id . '" class="btn btn-sm edit-btn">Delete</a>';
                })
                ->rawColumns(['edit', 'delete'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    
    public function getblogcatAjax(Request $request)
    {
        try {
            
            $query = Blogcat::select('id','categorytitle','seotitle', 'metakeywords', 'metadescription','created_at');
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->input('startDate');
                $endDate = $request->input('endDate');
    
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
            return DataTables::of($query)
                ->addColumn('edit', function ($row) {
                    return '<a href="/Editblogcat/' . $row->id . '" class="btn btn-sm delete-btn">Edit</a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/Deleteblogcat/' . $row->id . '" class="btn btn-sm edit-btn">Delete</a>';
                })
                ->rawColumns(['edit', 'delete'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    
    public function getnewscatAjax(Request $request)
    {
        try {
            
            $query = Newscat::select('id','categorytitle','seotitle', 'metakeywords', 'metadescription','created_at');
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->input('startDate');
                $endDate = $request->input('endDate');
    
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
            return DataTables::of($query)
                ->addColumn('edit', function ($row) {
                    return '<a href="/Editnewscat/' . $row->id . '" class="btn btn-sm delete-btn">Edit</a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/Deletenewscat/' . $row->id . '" class="btn btn-sm edit-btn">Delete</a>';
                })
                ->rawColumns(['edit', 'delete'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function getpagesAjax(Request $request)
    {
        try {
            
            $query = Pages::select('id','title', 'userid', 'slug','description','author','created_at');
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->input('startDate');
                $endDate = $request->input('endDate');
    
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
            return DataTables::of($query)
                ->addColumn('edit', function ($row) {
                    return '<a href="/Editpages/' . $row->id . '" class="btn btn-sm delete-btn">Edit</a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/Deletepages/' . $row->id . '" class="btn btn-sm edit-btn">Delete</a>';
                })
                ->rawColumns(['edit', 'delete'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    
}
