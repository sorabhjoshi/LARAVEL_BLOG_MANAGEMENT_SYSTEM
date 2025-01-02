<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Language;
use Illuminate\Http\Request;

class Languages extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['languageName' => 'required|string|max:255']);
    
        Language::create(['languages' => $request->languageName]);
    
        return response()->json(['success' => true, 'message' => 'Language added successfully!']);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate(['languageName' => 'required|string|max:255']);
    
        $language = Language::findOrFail($id);
        $language->update(['languages' => $request->languageName]);
    
        return response()->json(['success' => true, 'message' => 'Language updated successfully!']);
    }
    
    public function destroy($id)
    {
        $language = Language::findOrFail($id);
        $language->delete();
    
        return response()->json(['success' => true, 'message' => 'Language deleted successfully!']);
    }
    
}
