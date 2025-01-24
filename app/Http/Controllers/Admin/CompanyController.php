<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index()
    { 
        $columns = ['name',        'email',        'created_at'];
        $Company = Company::select('id','name',        'email',        'created_at');
        return view('Blogbackend.company.index', compact('Company','columns'));
    }

    public function create()
    {
        return view('Blogbackend.company.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Add validation rules
        ]);

        Company::create($validated);

        return redirect()->route('company.index')->with('success', 'Record created successfully!');
    }

    public function edit($id)
    {
        $Company = Company::findOrFail($id);
        return view('Blogbackend.company.edit', compact('Company'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            // Add validation rules
        ]);

        $Company = Company::findOrFail($id);
        $Company->update($validated);

        return redirect()->route('company.index')->with('success', 'Record updated successfully!');
    }

    public function destroy($id)
    {
        $Company = Company::findOrFail($id);
        $Company->delete();

        return redirect()->route('company.index')->with('success', 'Record deleted successfully!');
    }
}
