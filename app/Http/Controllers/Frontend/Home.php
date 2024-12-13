<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\Blog;
use App\Models\Admin\News;
use Illuminate\Http\Request;

class Home
{
    public function dashboard(Request $request){
    $users = Blog::all();
    $news = News::all(); 
    return view('Frontend.Dashboard', [
        'users' => $users,
        'news' => $news,
    ]);
	}
}
