<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Admin\Pages;

class PagesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Share $pages data with specific views
        View::composer('Frontend.Components.layout2', function ($view) {
            $pages = Pages::all();
            $view->with('pages', $pages);
        });
    }
}

