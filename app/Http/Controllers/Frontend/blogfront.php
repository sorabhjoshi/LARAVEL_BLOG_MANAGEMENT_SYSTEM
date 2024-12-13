<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\Blog;
use App\Models\Admin\Blogcat;
use Illuminate\Http\Request;
use Str;

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

public function loadMoreBlogs(Request $request)
{
    $offset = $request->input('offset', 0);  
    $limit = $request->input('limit', 3);  

    $blogs = Blog::skip($offset)->take($limit)->get();  
    $count = Blog::count();
 
    $data = $blogs->map(function ($blog) {
        return [
            'title' => $blog->title,
            'slug' => $blog->slug,
            'image' => asset($blog->image),  
            'description' => Str::limit(strip_tags($blog->description), 100,
           '...')
        ];
    });
    return response()->json([
        'status' => 'success',
        'data' => $data,
        'count'=>$count,
    ]);
}

}
