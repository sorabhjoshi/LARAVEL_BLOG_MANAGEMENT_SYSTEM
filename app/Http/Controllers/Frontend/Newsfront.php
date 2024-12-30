<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\Blog;
use App\Models\Admin\News;
use App\Models\Admin\Newscat;
use Illuminate\Http\Request;
use Str;

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

public function loadMoreNews(Request $request)
{
    $offset = $request->input('offset', 0);  
    $limit = $request->input('limit', 3);  

    $news = News::skip($offset)->take($limit)->get();  
    $count = News::count();
 
    $data = $news->map(function ($news) {
        return [
            'title' => $news->title,
            'slug' => $news->slug,
            'image' => asset($news->image),  
            'description' => Str::limit(strip_tags($news->description), 100, '...')
        ];
    });

    return response()->json([
        'status' => 'success',
        'data' => $data,
        'count'=>$count,
    ]);
}
public function showCategory($cat)
{
    $perPage = 2; // Number of news items per page
    $categoryname= $cat;
    // Fetch the category and news related to this category
    $category = Newscat::where('categorytitle', $cat)->firstOrFail();
    $News = $category->news()->paginate($perPage);

    // Fetch categories for sidebar and recent news
    $categories = Newscat::withCount('news')->get();
    $sidenews = News::latest()->take(5)->get();

    return view('Frontend.Newscat', compact('News', 'categories', 'sidenews', 'perPage', 'category','categoryname'));
}



public function loadMoreNewsCat(Request $request)
{
    $offset = $request->input('offset', 0);  // Get the offset
    $limit = $request->input('limit', 2);  // Get the number of items to load
    $category = $request->input('category');  // Get the category slug

    // Fetch the category by the slug
    $categoryObj = Newscat::where('categorytitle', $category)->firstOrFail();
    
    // Fetch news for the specified category with pagination
    $news = $categoryObj->news()
        ->skip($offset)
        ->take($limit)
        ->get();

        $data = $news->map(function ($news) {
            return [
                'title' => $news->title,
                'slug' => $news->slug,
                'image' => asset($news->image),  
                'description' => Str::limit(strip_tags($news->description), 100, '...')
            ];
        });
    // Return the news data in JSON format
    return response()->json([
        'status' => 'success',
        'data' => $data,
        'count' => $categoryObj->news()->count(),  // Total count for checking if there are more items
    ]);
}







}
