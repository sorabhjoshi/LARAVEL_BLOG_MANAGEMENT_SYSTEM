<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log; // <-- Add this import

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $menuData = Menu::where('id', 4)->first();

        // Uncomment and modify if needed
        // $module = Module::get(); 

        if ($menuData) {
            $menuData->json_output = json_decode($menuData->json_output, true);
        }

        // Log the data to the log file
        Log::debug('Menu Data:', ['menu' => $menuData]);
// dd($menuData);
        // Share the menu data across views
        View::share('menu', $menuData);
    }
}
