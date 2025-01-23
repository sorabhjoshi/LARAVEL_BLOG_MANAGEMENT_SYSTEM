<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\Blog;
use App\Models\Admin\News;
use Illuminate\Http\Request;

class Home
{
    public function dashboard(Request $request)
{
    // Fetch blogs where approval's designation_id is 5
    $blogs = Blog::with('approval') // Load the approval relationship
        ->whereHas('approval', function ($query) {
            $query->where('designation_id', 5); // Filter by designation_id
        })
        ->get();

    // Fetch news where approval's designation_id is 5
    $news = News::with('approval') // Load the approval relationship
        ->whereHas('approval', function ($query) {
            $query->where('designation_id', 5); // Filter by designation_id
        })
        ->get();

    // Pass the filtered data to the view
    return view('Frontend.Dashboard', [
        'users' => $blogs,
        'news' => $news,
    ]);
}

}
