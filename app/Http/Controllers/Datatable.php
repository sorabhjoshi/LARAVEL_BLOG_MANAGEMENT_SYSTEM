<?php

namespace App\Http\Controllers;
use App\Models\Companyaddress;
use App\Models\Newscat;
use App\Models\Pages;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Blog;
use App\Models\Blogcat;
use App\Models\News;
use App\Models\Companydata;
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
                    return '<a href="/Edituser/' . $row->id . '" class="btn btn-sm edit-btn">Edit</a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/Deleteuser/' . $row->id . '" class="btn btn-sm delete-btn">Delete</a>';
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
                    return '<a href="/Editblog/' . $row->id . '" class="btn btn-sm edit-btn">Edit</a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/Deleteblog/' . $row->id . '" class="btn btn-sm delete-btn">Delete</a>';
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
            $query = News::select('id','slug','userid', 'title', 'authorname', 'description','created_at','category');
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->input('startDate');
                $endDate = $request->input('endDate');
    
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
            return DataTables::of($query)
                ->addColumn('edit', function ($row) {
                    return '<a href="/EditNews/' . $row->id . '" class="btn btn-sm edit-btn">Edit</a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/DeleteNews/' . $row->id . '" class="btn btn-sm delete-btn">Delete</a>';
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
                    return '<a href="/Editblogcat/' . $row->id . '" class="btn btn-sm edit-btn">Edit</a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/Deleteblogcat/' . $row->id . '" class="btn btn-sm delete-btn">Delete</a>';
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
                    return '<a href="/Editnewscat/' . $row->id . '" class="btn btn-sm edit-btn">Edit</a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/Deletenewscat/' . $row->id . '" class="btn btn-sm delete-btn">Delete</a>';
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
                    return '<a href="/Editpages/' . $row->id . '" class="btn btn-sm edit-btn">Edit</a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/Deletepages/' . $row->id . '" class="btn btn-sm delete-btn">Delete</a>';
                })
                ->rawColumns(['edit', 'delete'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function getcomAjax(Request $request)
{
    try {
        // Initialize the query
        $query = Companydata::select('id', 'name', 'type', 'email', 'created_at');

        // Apply date filtering if provided
        if ($request->filled('startDate') && $request->filled('endDate')) {
            $query->whereBetween('created_at', [$request->startDate, $request->endDate]);
        }

        // Process the query for DataTables
        return DataTables::of($query)
            ->addColumn('edit', function ($row) {
                return '<a href="/Editcompany/' . $row->id . '" class="btn btn-sm btn-warning">Edit</a>';
            })
            ->addColumn('address', function ($row) {
                return '<button data-company-id="' . $row->id . '" 
                                class="btn btn-sm btn-primary view-address-btn">
                            View/Edit Address
                        </button>';
            })
            ->addColumn('delete', function ($row) {
                return '<a href="/Deletecompany/' . $row->id . '" class="btn btn-sm btn-danger">Delete</a>';
            })
            ->rawColumns(['edit', 'address', 'delete'])
            ->make(true);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
public function getaddressdata(Request $request)
{
    try {
        $addresses = Companyaddress::where('companyid', $request->company_id)->get();
        return response()->json(['status' => 'success', 'data' => $addresses]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

    

public function deleteAddress(Request $request)
{
    $addressId = $request->input('id');
    $address = Companyaddress::find($addressId);
    if ($address) {
        $address->delete();
        return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'error']);
}

public function savecompanyaddress(Request $request)
{
    if (    $userdata = News::find($request->input('id'))) {
    $userdata->latitude = $request->input('latitude');
    $userdata->longitude = $request->input('longitude');
    $userdata->mobile = $request->input('mobile');
    $userdata->address = $request->input('address');
    $userdata->companyid = $request->input('companyid');
    $userdata->save();
    return redirect()->route('Company')->with('success', 'Blog updated successfully!');
    }else {
        return redirect()->back()->withErrors('error', 'Blog updated unsuccessful');
    }

   
}



}
