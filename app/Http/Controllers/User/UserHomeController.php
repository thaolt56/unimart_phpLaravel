<?php

namespace App\Http\Controllers\User;

use App\Cat_product;
use App\slider;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserHomeController extends Controller
{
    function index()
    {
        $sliders =  slider::where('status', '=', 0)->get();
        $product_latest = Product::latest()->take(8)->get();

        $smartphone_cat = Cat_product::find(23);
        foreach ($smartphone_cat->productCatChild as $item) {

           $cat_child_id[] = $item->id;
        };
        $list_smartphone = Product::whereIn('cat_id',$cat_child_id)->latest()->take(8)->get();

        $laptop_cat = Cat_product::find(22);
        foreach ($laptop_cat->productCatChild as $item) {

            $laptop_cat_child_id[] = $item->id;
         };
         $list_laptop = Product::whereIn('cat_id', $laptop_cat_child_id)->latest()->take(8)->get();
       

        return view('user.home.index', compact(
            'sliders',
            'product_latest',
            'laptop_cat',
            'smartphone_cat',
            'list_smartphone',
            'list_laptop',
            
        ));
    }
}
