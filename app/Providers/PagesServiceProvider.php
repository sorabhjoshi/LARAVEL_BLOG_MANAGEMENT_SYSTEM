<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Admin\Pages;
use Illuminate\Support\Facades\Log;
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
        
View::composer('*', function ($view) {
    $pages = Pages::all();

    $view->with('pages', $pages);
});

    }
}
