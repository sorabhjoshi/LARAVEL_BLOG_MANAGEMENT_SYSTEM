<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\Blog;
use App\Models\Admin\Blogcat;
use Illuminate\Http\Request;

class blogfront
{
    public function showblog()
{
    $Blogs = Blog::with('category')->get();
    $categories = Blogcat::withCount('blogs')->get();
    return view('Frontend.Blogs', compact('Blogs', 'categories'));
}
    public function showsingleblog($slug){
        $blog= Blog::whereLike('slug', $slug)->first();
        $Blogs = Blog::with('category')->get();
        // dd($news);
        return view('Frontend.Blogview',['blog' => $blog,'Blogs'=>$Blogs]);
    }
    public function showCategory($cat)
{
    $category = Blogcat::where('categorytitle', $cat)->first();
    if (!$category) {
        abort(404, 'Category not found');
    }
    $categories = Blogcat::withCount('blogs')->get();
    $blogs = Blog::where('category', $category->id)->get();
    $sideblogs = Blog::all();
    return view('Frontend.Blogcat', ['blogs' => $blogs, 'categories' => $categories,'sideblogs'=> $sideblogs]);
}

    
}
