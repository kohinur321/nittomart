<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Setting;
use App\Models\SubCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view){
         $view->with('addtoCartCount', Cart::where('ip_address', request()->ip())->count());
         $view->with('cartProducts',  Cart::where('ip_address', request()->ip())->with('product')->get());
         $view->with('frontendSettings', Setting::first());
         $view->with('allCategories', Category::with('subCategories')->get());
         $view->with('allSubCategories', SubCategory::get());
        });
    }
}
