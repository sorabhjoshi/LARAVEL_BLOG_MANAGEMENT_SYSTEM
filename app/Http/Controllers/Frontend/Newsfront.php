<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\Blog;
use App\Models\Admin\News;
use App\Models\Admin\Newscat;
use Illuminate\Http\Request;

class Newsfront
{
    public function shownews(Request $request) {  
        $Blogs = News::with('category')->get();
        $categories = Newscat::withCount('news')->get();
        $tags= News::all();
        // $users = News::all();
        return view('Frontend.News', [
            'news' => $Blogs,
            'tags' => $tags,
            'category' => $categories,
        ]);
    }

    public function showsinglenews($slug){
        $news= News::whereLike('slug', $slug)->first();
        $tags = News::with('category')->get();
        // dd($news);
        return view('Frontend.Newsview',['news' => $news,'tags'=>$tags]);
    }

    public function showCategory($cat)
{
    $category = Newscat::where('categorytitle', $cat)->first();
    if (!$category) {
        abort(404, 'Category not found');
    }
    $categories = Newscat::withCount('news')->get();
    $News = News::where('category', $category->id)->get();
    $sidenews = News::all();
    return view('Frontend.Newscat', ['News' => $News, 'categories' => $categories,'sidenews'=> $sidenews]);
}
    
}
