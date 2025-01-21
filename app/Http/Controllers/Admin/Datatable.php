<?php

namespace App\Http\Controllers\Admin;
use App\Models\Admin\blogs_has_approval;
use App\Models\Admin\Companyaddress;
use App\Models\admin\department;
use App\Models\Admin\Designation;
use App\Models\Admin\Module;
use App\Models\Admin\Modules;
use App\Models\Admin\Newscat;
use App\Models\Admin\Pages;
use App\Models\Admin\permissions;
use App\Models\Admin\Menu;
use App\Models\Admin\Status;
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
    public function getnewsAjax(Request $request)
{
    try {
        // Fetching data with relationships and limiting fields for optimization
        $query = News::with([
            'domainrel:id,domainname',
            'langrel:id,languages',
            'statuss:id,status',
            'approval'
        ])->select(
            'id', 
            'slug', 
            'user_id', 
            'title', 
            'authorname', 
            'category', 
            'domain', 
            'language', 
            'created_at', 
            'status'
        );

        // Get the current user's designation ID
        $currentDesignationId = auth()->user()->designation ?? 0;
        
        // Apply date filters if provided
        if ($request->has(['startDate', 'endDate'])) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        return DataTables::of($query)
        
            ->editColumn('status', function ($news) use ($currentDesignationId) {
                $designations = Designation::all();
                $statusOptions = '';
                $approvalLevel = $news->approval->designation_id ?? 0;

                if (!empty($news->approval)) {
                    foreach ($designations->take($news->approval->designation_id) as $designation) {
                        $isSelected = $designation->id === $approvalLevel ? 'selected' : '';
                        $statusOptions .= "<option value='{$designation->id}' {$isSelected} disabled>
                            Approved by {$designation->designation_name}
                        </option>";
                    }
                }else{
                    $statusOptions .= "<option selected disabled> None </option>";
                }

                $approveDisabled = $approvalLevel > $currentDesignationId ? 'disabled' : '';
                $rejectDisabled = $approvalLevel > $currentDesignationId ? 'disabled' : '';

                return "
                    <div class='status-container'>
                        <select class='approval-select' data-id='{$news->id}' >
                            {$statusOptions}
                        </select>
                        <div class='status-actions'>
                            <button class='btn btn-success approve-btn' data-id='{$news->id}' {$approveDisabled}>
                                <i class='fas fa-check'></i> Approve
                            </button>
                            <button class='btn btn-danger reject-btn' data-id='{$news->id}' {$rejectDisabled}>
                                <i class='fas fa-times'></i> Reject
                            </button>
                        </div>
                    </div>
                ";
            })
            ->editColumn('language', function ($news) {
                return $news->langrel ? $news->langrel->languages : 'N/A';
            })
            ->editColumn('domain', function ($news) {
                return $news->domainrel ? $news->domainrel->domainname : 'N/A';
            })
            ->editColumn('created_at', function ($news) {
                return $news->created_at->diffForHumans();
            })
            ->addColumn('edit', function ($row) {
                return '<a href="/EditNews/' . $row->id . '" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>';
            })
            ->addColumn('delete', function ($row) {
                return '<a href="/DeleteNews/' . $row->id . '" class="btn btn-sm btn-danger delete-btn"><i class="fas fa-trash-alt"></i></a>';
            })
            ->rawColumns(['status', 'edit', 'delete']) // Mark these columns as raw HTML
            ->make(true);
    } catch (\Exception $e) {
        \Log::error('Error in getnewsAjax: ' . $e->getMessage()); // Log the error for debugging
        return response()->json(['error' => 'An error occurred while processing the request.'], 500);
    }
}


public function updateStatus(Request $request)
{
    try {
        // Validate the request
        $request->validate([
            'blogid' => 'required|integer',
            'designationid' => 'required|integer',
            'userid' => 'required|integer',
            'approvalLevel' => 'required|integer',
        ]);

   

        $existingItem = blogs_has_approval::where('blog_id', $request->input('blogid'))
            ->first();

        if ($existingItem) {
            $existingItem->approval = 1;
            $existingItem->user_id = $request->input('userid');
            $existingItem->designation_id = $request->input('designationid');
            $existingItem->save(); 

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully for the existing record.',
            ]);
        } else {
            
            $item = new blogs_has_approval();
            $item->blog_id = $request->input('blogid');
            $item->designation_id = $request->input('designationid');
            $item->user_id = $request->input('userid');
            $item->approval = 1;
            $item->save(); 

            return response()->json([
                'success' => true,
                'message' => 'New record created successfully.',
            ]);
        }
    } catch (\Exception $e) {
        // Return error message
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ]);
    }
}


public function rejectStatus(Request $request)
{
    try {
        // Validate the request
        $request->validate([
            'blogid' => 'required|integer',
            'designationid' => 'required|integer',
            'userid' => 'required|integer',
            'approvalLevel' => 'required|integer|min:1|max:5',
        ]);

   

        $existingItem = blogs_has_approval::where('blog_id', $request->input('blogid'))
            ->first();

        if ($existingItem) {
            $existingItem->approval = 0;
            $existingItem->user_id = $request->input('userid');
            $existingItem->designation_id = $request->input('designationid')-1;
            $existingItem->save(); 

            return response()->json([
                'success' => true,
                'message' => 'Approval Rejected successfully for the existing record.',
            ]);
        } else {
            
            $item = new blogs_has_approval();
            $item->blog_id = $request->input('blogid');
            $item->designation_id = $request->input('designationid')-1;
            $item->user_id = $request->input('userid');
            $item->approval = 0;
            $item->save(); 

            return response()->json([
                'success' => true,
                'message' => 'Approval Rejected successfully.',
            ]);
        }
    } catch (\Exception $e) {
        // Return error message
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ]);
    }
}





    public function updateNewsStatus(Request $request)
    {
        try {
            $news = News::find($request->id);
            if ($news) {
                $news->status = $request->status; // Assuming 'status' is the column in your table
                $news->save();
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false, 'message' => 'News not found']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    
    public function GetdesignationAjax(Request $request)
{
    try {
        $query = \App\Models\Admin\Designation::with('departments')->select('id', 'department_id','level', 'designation_name', 'created_at');

        if ($request->has('startDate') && $request->has('endDate')) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        return DataTables::of($query)
        ->editColumn('department_id', function ($row) {
            return $row->departments ? $row->departments->department_name : 'N/A';
        })
            ->addColumn('edit', function ($row) {
                return '<a href="/Editdesgination/' . $row->id . '" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> </a>';
            })
            ->addColumn('delete', function ($row) {
                return '<a href="/Deletedesgination/' . $row->id . '" class="btn btn-sm delete-btn"><i class="fas fa-trash-alt"></i></a>';
            })
            ->editColumn('created_at', function ($news) {
                return $news->created_at->diffForHumans();
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
}
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
                    return '<button  id="depeditbtn" data-id="'. $row->id .'" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> 
                            </button>';
                })
                ->addColumn('delete', function ($row) {
                    return '<button  id="depdelbtn" data-id="'. $row->id .'" class="btn btn-sm btn-danger delete-btn">
                                <i class="fas fa-trash-alt"></i> 
                            </button>';
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
            $query = Blog::with('domainrel', 'langrel','statuss') // Load relationships
                ->select('id', 'slug', 'user_id', 'title', 'authorname', 'category', 'domain', 'created_at','status','designation');
            
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->input('startDate');
                $endDate = $request->input('endDate');
    
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
    
            return DataTables::of($query)
            // ->editColumn('status', function ($row) {
            //     return $row->statuss ? $row->statuss->status : 'N/A';
            // })
                ->editColumn('language', function ($row) {
                    return $row->langrel ? $row->langrel->languages : 'N/A';
                })
                ->editColumn('domain', function ($row) {
                    return $row->domainrel ? $row->domainrel->name : 'N/A';
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
    
    

    
    public function getmodulerecoverAjax(Request $request)
    {
        try {
            $query = Module::select('id', 'modulesname', 'parent_id')
    ->where('delete_status', 1);

            
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = $request->input('startDate');
                $endDate = $request->input('endDate');
    
                if (!empty($startDate) && !empty($endDate)) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
            
            return DataTables::of($query)
            
                ->addColumn('recover', function ($row) {
                    return '<a href="Modules/recover/' . $row->id . '" class="btn btn-sm btn-warning ">
                                <i class="fa-solid fa-hammer"></i>
                            </a>';
                })
                ->rawColumns(['recover']) // Allow raw HTML
                ->make(true);
    
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getmoduleAjax(Request $request)
    {
        try {
            $query = Module::select('id', 'modulesname', 'parent_id', 'updated_at', 'created_at')
    ->where('delete_status', 0);

            
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
                ->addColumn('mvc', function ($row) {
                    return '<button id="mvc" class="btn btn-sm btn-warning" data-name="'.$row->modulesname.'">
                               mvc
                            </button>';
                })
                ->addColumn('delete', function ($row) {
                    return '<a href="Modules/DeleteModule/' . $row->id . '" class="btn btn-sm btn-danger delete-btn">
                                <i class="fas fa-trash-alt"></i> 
                            </a>';
                })
                ->rawColumns(['addpermissions', 'mvc', 'delete']) // Allow raw HTML
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
