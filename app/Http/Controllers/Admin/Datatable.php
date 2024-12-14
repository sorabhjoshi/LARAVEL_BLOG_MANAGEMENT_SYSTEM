<?php

namespace App\Http\Controllers\Admin;
use App\Models\Admin\Companyaddress;
use App\Models\Admin\Newscat;
use App\Models\Admin\Pages;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin\Blog;
use App\Models\Admin\Blogcat;
use App\Models\Admin\News;
use App\Models\Admin\Companydata;
use Illuminate\Http\Request;
use App\Models\Admin\Register_model;

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
                    return '<a href="/Edituser/' . $row->id . '" class="btn btn-sm btn-warning">Edit</a>';
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
                    return '<a href="/Editblog/' . $row->id . '" class="btn btn-sm btn-warning">Edit</a>';
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
                    return '<a href="/EditNews/' . $row->id . '" class="btn btn-sm btn-warning">Edit</a>';
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
                    return '<a href="/Editblogcat/' . $row->id . '" class="btn btn-sm btn-warning">Edit</a>';
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
                    return '<a href="/Editnewscat/' . $row->id . '" class="btn btn-sm btn-warning">Edit</a>';
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
            
            $query = Pages::select('id','title', 'userid', 'slug','author','created_at');
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->input('startDate');
                $endDate = $request->input('endDate');
    
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
            return DataTables::of($query)
                ->addColumn('edit', function ($row) {
                    return '<a href="/Editpages/' . $row->id . '" class="btn btn-sm btn-warning">Edit</a>';
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
      
        $query = Companydata::select('id', 'name', 'type', 'email', 'created_at');

        if ($request->filled('startDate') && $request->filled('endDate')) {
            $query->whereBetween('created_at', [$request->startDate, $request->endDate]);
        }

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
public function saveCompanyAddress(Request $request)
{

    \Log::error('POST Data: ', $request->all());

    $companyId = $request->input('company_id');
    $ids = $request->input('id');
    $addresses = $request->input('Address');
    $latitudes = $request->input('Latitude');
    $longitudes = $request->input('Longitude');
    $mobiles = $request->input('Mobile');

    $data = [];
    for ($i = 0; $i < count($addresses); $i++) {
        $data[] = [
            'companyid' => $companyId,
            'id' => $ids[$i] ?? null, 
            'address' => $addresses[$i],
            'latitude' => $latitudes[$i],
            'longitude' => $longitudes[$i],
            'mobile' => $mobiles[$i]
        ];
    }

    try {
        foreach ($data as $row) {
            $id = $row['id'];
            unset($row['id']); 

            if ($id) {
                
                $existingRow = \DB::table('companyaddress')->find($id);

                if ($existingRow) {
                    
                    \DB::table('companyaddress')->where('id', $id)->update($row);
                } else {
                    
                    \DB::table('companyaddress')->insert($row);
                }
            } else {
                
                \DB::table('companyaddress')->insert($row);
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Data saved successfully']);
    } catch (\Exception $e) {
        \Log::error('Error saving company address: ' . $e->getMessage());
        return response()->json(['status' => 'error', 'message' => 'Failed to save data.']);
    }
}





}
