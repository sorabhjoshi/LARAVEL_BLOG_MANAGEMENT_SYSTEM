<?php

namespace App\Http\Controllers\Admin;
use App\Models\Admin\Companyaddress;
use App\Models\admin\department;
use App\Models\Admin\Module;
use App\Models\Admin\Modules;
use App\Models\Admin\Newscat;
use App\Models\Admin\Pages;
use App\Models\Admin\permissions;
use App\Models\Admin\Menu;
use App\Models\Domains;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin\Blog;
use App\Models\Admin\Blogcat;
use App\Models\Admin\News;
use App\Models\Admin\Companydata;
use Illuminate\Http\Request;
use App\Models\Admin\Register_model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\DB as DBFacade;

class Datatable extends Controller
{
    public function getlanguagesAjax(Request $request){
        try {
            $query = \App\Models\Admin\Language::all();
    
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->input('startDate');
                $endDate = $request->input('endDate');
    
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
    
            return DataTables::of($query)
            ->editColumn('created_at', function ($request) {
                return $request->created_at->diffForHumans();
            })
                ->addColumn('edit', function ($row) {
                    return '<a href="/Editlanguage/' . $row->id . '" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> </a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/Deletelanguage/' . $row->id . '" class="btn btn-sm delete-btn"><i class="fas fa-trash-alt"></i></a>';
                })
                ->rawColumns(['edit', 'delete'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function GetDomainAjax(Request $request)
{
    try {
        $query = \App\Models\Admin\Domains::all();

        if ($request->has('startDate') && $request->has('endDate')) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        return DataTables::of($query)
        ->editColumn('created_at', function ($request) {
            return $request->created_at->diffForHumans();
        })
            ->addColumn('edit', function ($row) {
                return '<a href="/Editdomain/' . $row->id . '" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> </a>';
            })
            ->addColumn('delete', function ($row) {
                return '<a href="/Deletedomain/' . $row->id . '" class="btn btn-sm delete-btn"><i class="fas fa-trash-alt"></i></a>';
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
}
    public function menudatatable(Request $request)
{
    try {
        $query = Menu::select('id', 'category', 'permission');

        if ($request->has('startDate') && $request->has('endDate')) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        return DataTables::of($query)
            ->addColumn('edit', function ($row) {
                return '<a href="/Editmenutable/' . $row->id . '" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> </a>';
            })
            ->addColumn('delete', function ($row) {
                return '<a href="/Deletemenutable/' . $row->id . '" class="btn btn-sm delete-btn"><i class="fas fa-trash-alt"></i></a>';
            })
            ->addColumn('addmenu', function ($row) {
                return '<a href="Menu/Addmenu/' . $row->id . '" id="permissionsbtn" class="btn btn-sm primary-btn"><i class="fas fa-key"></a>';
            })
            ->rawColumns(['edit', 'delete','addmenu'])
            ->make(true);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
}

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
                    return '<a href="/Edituser/' . $row->id . '" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> </a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/Deleteuser/' . $row->id . '" class="btn btn-sm delete-btn"><i class="fas fa-trash-alt"></i></a>';
                })
                ->rawColumns(['edit', 'delete'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    
    public function GetDepartmentAjax(Request $request)
    {
        try {
            $query = department::all();
            
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->input('startDate');
                $endDate = $request->input('endDate');
    
                if (!empty($startDate) && !empty($endDate)) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
            
            return DataTables::of($query)
            ->editColumn('created_at', function ($request) {
                return $request->created_at->diffForHumans();
            })
                
                ->addColumn('edit', function ($row) {
                    return '<a href="#" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> 
                            </a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="#" class="btn btn-sm btn-danger delete-btn">
                                <i class="fas fa-trash-alt"></i> 
                            </a>';
                })
                ->rawColumns(['addpermissions', 'edit', 'delete']) // Allow raw HTML
                ->make(true);
    
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getblogAjax(Request $request)
    {
        try {
            $query = Blog::with('domainrel', 'langrel') // Load relationships
                ->select('id', 'slug', 'user_id', 'title', 'authorname', 'category', 'domain', 'created_at');
            
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->input('startDate');
                $endDate = $request->input('endDate');
    
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
    
            return DataTables::of($query)
                ->editColumn('language', function ($blog) {
                    return $blog->langrel ? $blog->langrel->languages : 'N/A';
                })
                ->editColumn('domain', function ($blog) {
                    return $blog->domainrel ? $blog->domainrel->name : 'N/A';
                })
                ->addColumn('edit', function ($row) {
                    return '<a href="/Editblog/' . $row->id . '" class="btn btn-sm btn-warning"> <i class="fas fa-key"></i></a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/Deleteblog/' . $row->id . '" class="btn btn-sm delete-btn"><i class="fas fa-trash-alt"></i></a>';
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
        $query = News::with(['domainrel:id,domainname', 'langrel:id,languages']) // Eager load only the necessary fields
            ->select('id', 'slug', 'user_id', 'title', 'authorname', 'category', 'domain', 'language', 'created_at');
        
        if ($request->has('startDate') && $request->has('endDate')) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        return DataTables::of($query)
            ->editColumn('language', function ($news) {
                return $news->langrel ? " {$news->langrel->languages}" : 'N/A';
            })
            ->editColumn('domain', function ($news) {
                return $news->domainrel ? " {$news->domainrel->domainname}" : 'N/A';
            })
            ->editColumn('created_at', function ($news) {
                return $news->created_at->diffForHumans();
            })
            ->addColumn('edit', function ($row) {
                return '<a href="/EditNews/' . $row->id . '" class="btn btn-sm btn-warning"><i class="fas fa-key"></i></a>';
            })
            ->addColumn('delete', function ($row) {
                return '<a href="/DeleteNews/' . $row->id . '" class="btn btn-sm delete-btn"><i class="fas fa-trash-alt"></i></a>';
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
}



    

    
    public function getmoduleAjax(Request $request)
    {
        try {
            $query = Module::select('id', 'modulesname', 'parent_id',  'updated_at', 'created_at');
            
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->input('startDate');
                $endDate = $request->input('endDate');
    
                if (!empty($startDate) && !empty($endDate)) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
            
            return DataTables::of($query)
            ->editColumn('created_at', function ($request) {
                return $request->created_at->diffForHumans();
            })
                ->addColumn('addpermissions', function ($row) {
                    return '<button class="btn btn-sm btn-success" id="permissionsbtn" data-module-id="' . $row->id . '">
                                <i class="fas fa-key"></i> 
                            </button>';
                })
                ->addColumn('edit', function ($row) {
                    return '<a href="Modules/EditModule/' . $row->id . '" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> 
                            </a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="Modules/DeleteModule/' . $row->id . '" class="btn btn-sm btn-danger delete-btn">
                                <i class="fas fa-trash-alt"></i> 
                            </a>';
                })
                ->rawColumns(['addpermissions', 'edit', 'delete']) // Allow raw HTML
                ->make(true);
    
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
            ->editColumn('created_at', function ($request) {
                return $request->created_at->diffForHumans();
            })
                ->addColumn('edit', function ($row) {
                    return '<a href="/Editblogcat/' . $row->id . '" class="btn btn-sm btn-warning">  <i class="fas fa-edit"></i></a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/Deleteblogcat/' . $row->id . '" class="btn btn-sm delete-btn"><i class="fas fa-trash-alt"></i> </a>';
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
            ->editColumn('created_at', function ($request) {
                return $request->created_at->diffForHumans();
            })
                ->addColumn('edit', function ($row) {
                    return '<a href="/Editnewscat/' . $row->id . '" class="btn btn-sm btn-warning">  <i class="fas fa-edit"></i> </a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/Deletenewscat/' . $row->id . '" class="btn btn-sm delete-btn"><i class="fas fa-trash-alt"></i></a>';
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
            ->editColumn('created_at', function ($request) {
                return $request->created_at->diffForHumans();
            })
                ->addColumn('edit', function ($row) {
                    return '<a href="/Editpages/' . $row->id . '" class="btn btn-sm btn-warning">   <i class="fas fa-edit"></i> </a>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="/Deletepages/' . $row->id . '" class="btn btn-sm delete-btn">   <i class="fas fa-trash-alt"></i> </a>';
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
        ->editColumn('created_at', function ($request) {
            return $request->created_at->diffForHumans();
        })
            ->addColumn('edit', function ($row) {
                return '<a href="/Editcompany/' . $row->id . '" class="btn btn-sm btn-warning">   <i class="fas fa-edit"></i> </a>';
            })
            ->addColumn('address', function ($row) {
                return '<button data-company-id="' . $row->id . '" 
                                class="btn btn-sm btn-primary view-address-btn">
                            View/Edit Address
                        </button>';
            })
            ->addColumn('delete', function ($row) {
                return '<a href="/Deletecompany/' . $row->id . '" class="btn btn-sm btn-danger"> <i class="fas fa-trash-alt"></i> </a>';
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

public function savePermissions(Request $request)
{
    $moduleId = $request->module_id;
    $guardName = $request->guard_name;
    $permissions = $request->permissions;

    foreach ($permissions as $permission) {
        if (isset($permission['id'])) {
            // Update existing permission
            DBFacade::table('permissions')
                ->where('id', $permission['id'])
                ->update([
                    'name' => $permission['name'],
                    'module_id' => $moduleId,
                    'guard_name' => $guardName,
                    'updated_at' => now(),
                ]);
        } else {
            // Create new permission
            DBFacade::table('permissions')->insert([
                'name' => $permission['name'],
                'module_id' => $moduleId,
                'guard_name' => $guardName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } 
    }

    return response()->json(['success' => true]);
}


public function ShowPermissions(Request $request){
    $validated = $request->validate([
        'module_id' => 'required|integer', 
    ]);
    $moduledata = permissions::where('module_id', $request->input('module_id'))->get();
    return response()->json(['status' => 'success', 'data' => $moduledata]);
}

public function deletePermission(Request $request)
{
    $validated = $request->validate([
        'permission_id' => 'required|integer',
    ]);

    try {
        $permission = permissions::findOrFail($validated['permission_id']);
        $permission->delete();

        return response()->json([
            'success' => true,
            'message' => 'Permission deleted successfully.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error deleting permission.',
            'error' => $e->getMessage(),
        ]);
    }
}

}
