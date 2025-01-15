<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class news_has_approval extends Controller
{
    public function updateStatus(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'newsid' => 'required|integer',
                'designationid' => 'required|integer',
                'userid' => 'required|integer',
                'approvalLevel' => 'required|integer|min:1|max:5',
            ]);
    
       
    
            $existingItem = \App\Models\Admin\news_has_approval::where('news_id', $request->input('newsid'))
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
                
                $item = new \App\Models\Admin\news_has_approval();
                if ( $item->designation_id <= \App\Models\User::where('id', session('user_id'))->pluck('designation')->first()) {
                    $item->news_id = $request->input('newsid');
                    $item->designation_id = $request->input('designationid');
                    $item->user_id = $request->input('userid');
                    $item->approval = 1;
                    $item->save(); 
        
                    return response()->json([
                        'success' => true,
                        'message' => 'New record created successfully.',
                    ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'error' =>"User dosen't have the required permission",
                    ]);
                }
                
            }
        } catch (\Exception $e) {
            // Return error message
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
    
    
    public function rejectStatus(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'newsid' => 'required|integer',
                'designationid' => 'required|integer',
                'userid' => 'required|integer',
                'approvalLevel' => 'required|integer|min:1|max:5',
            ]);
    
       
    
            $existingItem = \App\Models\Admin\news_has_approval::where('news_id', $request->input('newsid'))
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
                
                $item = new \App\Models\Admin\news_has_approval();
                if ($item->designation_id <= \App\Models\User::where('id', session('user_id'))->pluck('designation')->first()) {
                    $item->news_id = $request->input('newsid');
                    $item->designation_id = $request->input('designationid')-1;
                    $item->user_id = $request->input('userid');
                    $item->approval = 0;
                    $item->save(); 
        
                    return response()->json([
                        'success' => true,
                        'message' => 'Approval Rejected successfully.',
                    ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => "User dosen't have the required permission",
                    ]);
                }
                
            }
        } catch (\Exception $e) {
            // Return error message
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
