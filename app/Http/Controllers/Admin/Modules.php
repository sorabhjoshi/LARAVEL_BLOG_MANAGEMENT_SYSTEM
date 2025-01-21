<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\Admim\Modules; // Import the Module model
use App\Models\Admin\Menu;
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
    
    public function RecoverModule($id)
    {
        $modulesdata = Module::find($id);
    
        $menuData = Menu::where('id', 4)->first();
        if (!$menuData) {
            return redirect()->back()->withErrors('Module not found.');
        }
        $modulesdata->delete_status = 0;
        $modulesdata->save();
        $jsonoutput = json_decode($menuData->json_output, true);
    
        $this->recovermoduledata($jsonoutput, $id);
    
        $menuData->json_output = json_encode($jsonoutput);
        if ($menuData->save() ) {
            return redirect()->back()->with('success', 'Module delete successful');
        } else {
            return redirect()->back()->withErrors('Module delete unsuccessful');
        }
    }
    public function DeleteModule($id)
    {
        $modulesdata = Module::find($id);
    
        $menuData = Menu::where('id', 4)->first();
        if (!$menuData) {
            return redirect()->back()->withErrors('Module not found.');
        }
        $modulesdata->delete_status = 1;
        $modulesdata->save();
        $jsonoutput = json_decode($menuData->json_output, true);
    
        $this->markModuleAsDeleted($jsonoutput, $id);
    
        $menuData->json_output = json_encode($jsonoutput);
        if ($menuData->save() ) {
            return redirect()->back()->with('success', 'Module delete successful');
        } else {
            return redirect()->back()->withErrors('Module delete unsuccessful');
        }
    }
    
    private function markModuleAsDeleted(&$menuItems, $moduleId)
    {
        foreach ($menuItems as &$item) {
            if ($item['moduleid'] == $moduleId) {
                $item['deletestatus'] = '1';
                return; 
            }
    
            if (!empty($item['children'])) {
                foreach ($item['children'] as &$child) {
                    if ($child['moduleid'] == $moduleId) {
                        $child['deletestatus'] = '1';
                        return;
                    }
                }
            }
        }
    }

    private function recovermoduledata(&$menuItems, $moduleId)
    {
        foreach ($menuItems as &$item) {
            if ($item['moduleid'] == $moduleId) {
                $item['deletestatus'] = '0';
                return; 
            }
    
            if (!empty($item['children'])) {
                foreach ($item['children'] as &$child) {
                    if ($child['moduleid'] == $moduleId) {
                        $child['deletestatus'] = '0';
                        return;
                    }
                }
            }
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
