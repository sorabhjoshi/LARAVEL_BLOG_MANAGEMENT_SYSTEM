<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Pages
{
    public function showpage($slug){
        // $Page= Pages::whereLike('slug', $slug)->first();
        $Page = \App\Models\Admin\Pages::where('slug', 'like', '%' . $slug . '%')->first();

        // dd($Page);
        return view('Frontend.Pages',['Page' => $Page]);
    }
}
