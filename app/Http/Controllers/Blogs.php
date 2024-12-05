<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class Blogs extends Controller
{
    public function addblogdata(Request $request)
{
    $user = session('user');
    if (!$user) {
        return redirect()->route('login')->withErrors('Please login to add a blog');
    }

    $request->validate([
        'author_name' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'image' => 'required',
        'content' => 'required|string',
        'category' => 'required|string',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = 'images/' . $imageName;
        $image->move(public_path('images'), $imageName);
    }

    $slug = Str::slug($request->input('title'));
    $existingSlugCount = Blog::where('slug', $slug)->count();
    if ($existingSlugCount > 0) {
        $slug = $slug . '-' . time();
    }

    Blog::create([
        'authorname' => $request->input('author_name'),
        'title' => $request->input('title'),
        'image' => $imagePath,
        'description' => $request->input('content'),
        'category' => $request->input('category'),
        'slug' => $slug,
        'userid' => $user->id,  // Store the user ID here
    ]);

    return redirect()->back()->with('success', 'Blog added successfully!');
}

    


    

}
