<?php

namespace App\Providers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Cat_product;
use App\Product;
use Illuminate\Support\Facades\View;

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
        $product_cat_parents = Cat_product::where('parent_id','=',0)->get();
        $product_sell = Product::where('highlight','=','0')->take(8)->get();


       view::share(compact('product_cat_parents','product_sell'));
    }
 
}

