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
    $perPage = 2;  // Initially fetch 2 blogs
    $categoryname = $cat;
    
    $category = Blogcat::where('categorytitle', $cat)->first();
    
    if (!$category) {
        abort(404, 'Category not found');
    }

    // Get category counts
    $categories = Blogcat::withCount('blogs')->get();

    // Fetch only 2 blogs initially for the selected category
    $blogs = Blog::where('category', $category->id)->take($perPage)->get();

    // Get all side blogs for the sidebar
    $sideblogs = Blog::all();

    return view('Frontend.Blogcat', [
        'blogs' => $blogs,
        'categories' => $categories,
        'sideblogs' => $sideblogs,
        'perPage' => $perPage,
        'categoryname' => $categoryname
    ]);
}


public function loadMoreblogscat(Request $request)
{
    $offset = $request->input('offset', 0);  
    $limit = $request->input('limit', 2);  

    $category = Blogcat::where('categorytitle', $request->input('category'))->first();

    if (!$category) {
        return response()->json(['status' => 'error', 'message' => 'Category not found']);
    }

    $blogs = Blog::where('category', $category->id)
                ->skip($offset)
                ->take($limit)
                ->get();

    $data = $blogs->map(function ($blog) {
        return [
            'title' => $blog->title,
            'slug' => $blog->slug,
            'image' => asset($blog->image),  
            'description' => Str::limit(strip_tags($blog->description), 100, '...')
        ];
    });

    $totalBlogs = Blog::where('category', $category->id)->count();

    return response()->json([
        'status' => 'success',
        'data' => $data,
        'totalBlogs' => $totalBlogs,
    ]);
}



public function loadMoreBlogs(Request $request)
{
    
    $offset = $request->input('offset', 0);
    $limit = $request->input('limit', 2);

    $blogs = Blog::skip($offset)->take($limit)->get();
    
    $data = $blogs->map(function ($blog) {
        return [
            'title' => $blog->title,
            'slug' => $blog->slug,
            'image' => asset($blog->image),  
            'description' => Str::limit(strip_tags($blog->description), 100, '...')
        ];
    });
 
    return response()->json([
        'status' => 'success',
        'data' => $data,
        'count' => Blog::count() 
    ]);
}

}
