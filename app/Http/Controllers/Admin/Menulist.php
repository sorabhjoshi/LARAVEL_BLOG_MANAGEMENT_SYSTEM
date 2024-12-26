<?php

namespace App\Http\Controllers\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class Menulist extends Controller
{
   public function edit($id)
    {
        $edit = Menu::find($id)->toArray();
        if ($edit) {
            return view('Blogbackend.Utils.Editmenutable', compact('edit'));
        } else {
            return redirect()->route('menulist')->with('error', 'Menu not found');
        }
    }

    // Delete method
    public function delete($id)
    {
        $menu = Menu::find($id);
        if ($menu) {
            $menu->delete();
            return redirect()->back()->with('success', 'saved');
        } else {
            return response()->json(['success' => false, 'message' => 'Menu not found']);
        }
    }
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);
        if ($menu) {
            // Validate the input
            $request->validate([
                'category' => 'required|string|max:255',
                'permission' => 'required|string|max:255',
            ]);

            // Update the menu details
            $menu->category = $request->category;
            $menu->permission = $request->permission;
            $menu->save();

            // Redirect to the menu list with success message
            return redirect()->route('menulist')->with('success', 'Menu updated successfully');
        } else {
            return redirect()->route('menulist')->with('error', 'Menu not found');
        }
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'category' => 'required|string|max:255',
            'permission' => 'required|string|max:255',
        ]);

        $menu = new Menu();
        $menu->category = $request->category;
        $menu->permission = $request->permission;
        $menu->save();

        return redirect()->route('menulist')->with('success', 'Menu added successfully');
    }
    
    public function Addmenubar($id)
    {
        
        $menu = Menu::whereid($id)->first();
        $finalmenu_output = json_decode($menu, true);
        // dd($finalmenu_output);
        if ($finalmenu_output ) {
            return view('Blogbackend.Addmenubar', compact('finalmenu_output'));
        } else {
            return redirect()->route('menulist')->with('error', 'Menu not found');
        }
       
      
        
    }
    
    function updatejsondata(Request $request){
        $blog = Menu::find($request->id);
        if ($blog) {
            $blog->json_output = $request->input('json_output');
            if ($blog->save()) {
                return redirect()->route('menulist')->with('success', 'Blog updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to update the blog.');
            }
        } else {
            return redirect()->route('addmenubar')->with('error', 'Blog not found.');
        }
    }
    
    public function access($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    
        return view('roles.roleaccess',compact('role','permission','rolePermissions'));
    }
}
