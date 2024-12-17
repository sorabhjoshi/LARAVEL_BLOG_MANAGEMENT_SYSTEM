<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\Admim\Modules; // Import the Module model
use App\Models\Admin\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class Modules extends Controller
{
    public function Addmodule(){
        $modulesdata = \App\Models\Admin\Module::all(); 
        return view('Blogbackend.Utils.Addmodule', ['modulesdata' => $modulesdata]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_name' => 'required|string|max:255',
            'parent_module' => 'nullable|exists:modules,id',
        ]);

        try {
            // Log::info('Validated Data: ', $validated);

            $module = new Module();
            $module->modulesname = $request->input('module_name');
            $module->parent_id = $request->input('parent_module') ?: null;  
            $module->save();
            // dd( $module);
            Log::info('Module Saved Successfully', ['module_name' => $request->module_name]);

            return redirect()->route('Modules');
        } catch (\Exception $e) {
            Log::error('Error Saving Module', ['error' => $e->getMessage()]);

            return redirect()->back()->with('error', 'Error saving module: ' . $e->getMessage());
        }
    }

    public function DeleteModule($id){
        $modulesdata = \App\Models\Admin\Module::find($id);
        
        if ($modulesdata->delete()) {
            return redirect()->back()->with( key: 'Module delete successful');
        } else {
            return redirect()->back()->withErrors('error', key: 'Module delete unsuccessful');
        }
    }

    public function editmodule($id)
    {
        $modulesdata = Module::all();
    
        $module = Module::find($id);
    
        if (!$module) {
            return redirect()->back()->with('error', 'Module not found.');
        }
    
        $parentname = null;
        if ($module->parent_id) {
            $parentname = Module::find($module->parent_id);
        }
        
        return view('Blogbackend.Utils.EditModules', [
            'module' => $module,
            'parentname' => $parentname,
            'modulesdata' => $modulesdata
        ]);
    }

    public function storeedit(Request $request)
    {
        $validated = $request->validate([
            'module_name' => 'required|string|max:255',
            'parent_module' => 'nullable|exists:modules,id',
        ]);

        try {
            $module = Module::find($request->input('id'));
            $module->modulesname = $request->input('module_name');
            $module->parent_id = $request->input('parent_module') ?: null;  
            $module->save();

            return redirect()->route('Modules');
        } catch (\Exception $e) {
            Log::error('Error Saving Module', ['error' => $e->getMessage()]);

            return redirect()->back()->with('error', 'Error saving module: ' . $e->getMessage());
        }
    }
    
    
    
}
