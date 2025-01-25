<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\BlogList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogListController extends Controller
{
    public function index()
    {
        $columns = ['id', 'name', 'email'];
        $BlogList = BlogList::all();
        return view('Blogbackend.bloglist.index', compact('BlogList', 'columns'));
    }

    public function create()
    {
        return view('Blogbackend.bloglist.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'email' => 'required'
        ]);

        BlogList::create($validated);

        return redirect()->route('bloglist.index')
            ->with('success', 'Record created successfully!');
    }

    public function edit($id)
    {
        $BlogList = BlogList::findOrFail($id);
        return view('Blogbackend.bloglist.edit', compact('BlogList'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'email' => 'required'
        ]);

        $BlogList = BlogList::findOrFail($id);
        $BlogList->update($validated);

        return redirect()->route('bloglist.index')
            ->with('success', 'Record updated successfully!');
    }

    public function destroy($id)
    {
        $BlogList = BlogList::findOrFail($id);
        $BlogList->delete();

        return redirect()->route('bloglist.index')
            ->with('success', 'Record deleted successfully!');
    }
}
