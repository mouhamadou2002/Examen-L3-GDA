<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Product;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('allCategories', Category::all());
        });
        View::composer('layouts.admin', function ($view) {
            $ruptureCount = Product::where('stock', '<=', 0)->count();
            $view->with('ruptureCount', $ruptureCount);
        });
    }
}
