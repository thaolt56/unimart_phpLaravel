<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cat_product;
use App\slider;
use App\Product;

class UserProductController extends Controller
{
    function product_cat(Request $request)
    {
        $select_sort = [
            0 => 'Sắp xếp',
            1 => 'Từ A-Z',
            2 => 'Từ Z-A',
            3 => 'Giá cao xuống thấp',
            4 => 'Giá thấp lên cao',
        ];
        $sort = $request->input('sort');

        $r_price = $request->input('r-price');
        $r_brand = $request->input('r-brand');
        $cat_id = $request->cat_id;
        // return dd($r_brand);

        $product_cat = Cat_product::find($cat_id);
        $cat_child_id = array();
        if ($product_cat->parent_id == 0) {
            foreach ($product_cat->productCatChild as $item) {

                $cat_child_id[] = $item->id;
            };
            $productCatParent = $product_cat;
        } else {
            $cat_child_id[] = $cat_id;
            $productCatParent = $product_cat->productCatParent;
        }

        //sap xep sort
        if ($sort == 1) {
            $list_product_by_cat = Product::whereIn('cat_id', $cat_child_id)->orderBy('name', 'ASC')->latest()->paginate(12);
        } else if ($sort == 2) {
            $list_product_by_cat = Product::whereIn('cat_id', $cat_child_id)->orderBy('name', 'DESC')->latest()->paginate(12);
        } else if ($sort == 3) {
            $list_product_by_cat = Product::whereIn('cat_id', $cat_child_id)->orderBy('price', 'DESC')->latest()->paginate(12);
        } else if ($sort == 4) {
            $list_product_by_cat = Product::whereIn('cat_id', $cat_child_id)->orderBy('price', 'ASC')->latest()->paginate(12);
        } else {
            $list_product_by_cat = Product::whereIn('cat_id', $cat_child_id)->latest()->paginate(12);
        }
        //loc san pham
        if (empty($r_brand)) {
            if ($r_price == "duoi-2.000.000") {
                $list_product_by_cat = Product::where('price', '<', 2000000)->whereIn('cat_id',  $cat_child_id)->latest()->paginate(12);
            } else  if ($r_price == "2.000.000-den-5.000.000") {
                $list_product_by_cat = Product::where('price', '>', 2000000)->where('price', '<', 5000000)->whereIn('cat_id',  $cat_child_id)->latest()->paginate(12);
            } else if ($r_price == "5.000.000-den-8.000.000") {
                $list_product_by_cat = Product::where('price', '>', 5000000)->where('price', '<', 8000000)->whereIn('cat_id',  $cat_child_id)->latest()->paginate(12);
            } else if ($r_price == "8.000.000-den-12.000.000") {
                $list_product_by_cat = Product::where('price', '>', 8000000)->where('price', '<', 12000000)->whereIn('cat_id',  $cat_child_id)->latest()->paginate(12);
            } else if ($r_price == "tren-12.000.000") {
                $list_product_by_cat = Product::where('price', '>', 12000000)->whereIn('cat_id',  $cat_child_id)->latest()->paginate(12);
            }
        } else {
            if ($r_price == "duoi-2.000.000") {
                $list_product_by_cat = Product::where('price', '<', 2000000)->whereIn('cat_id',  $cat_child_id)->latest()->paginate(12);
            } else  if ($r_price == "2.000.000-den-5.000.000") {
                $list_product_by_cat = Product::where('price', '>', 2000000)->where('price', '<', 5000000)->whereIn('cat_id',  $r_brand)->latest()->paginate(12);
            } else if ($r_price == "5.000.000-den-8.000.000") {
                $list_product_by_cat = Product::where('price', '>', 5000000)->where('price', '<', 8000000)->whereIn('cat_id',  $r_brand)->latest()->paginate(12);
            } else if ($r_price == "8.000.000-den-12.000.000") {
                $list_product_by_cat = Product::where('price', '>', 8000000)->where('price', '<', 12000000)->whereIn('cat_id',  $r_brand)->latest()->paginate(12);
            } else if ($r_price == "tren-12.000.000") {
                $list_product_by_cat = Product::where('price', '>', 12000000)->whereIn('cat_id', $r_brand)->latest()->paginate(12);
            } else {
                $list_product_by_cat = Product::whereIn('cat_id', $r_brand)->latest()->paginate(12);
            }
        }

        return view(
            'user.product.cat',
            compact(
                'list_product_by_cat',
                'product_cat',
                'productCatParent',
                'cat_id',
                'select_sort',
                'sort',
                'r_brand',
                'r_price'
            )
        );
    }

    function product_detail(Request $request){
        $warehouse = array(
            0 => 'Hết hàng',
            1 => 'Còn hàng'
        );
        $id = $request->id;
        $product = Product::find($id);
        $cat_id = $product->cat_id;

        //same_category_product
        $same_category = Product::where('cat_id',$cat_id)->take(10)->get();
        // return dd($same_category);
        return view('user.product.product_detail',compact('product','same_category','warehouse'));
    }


    function product_search(Request $request){
      if($request->ajax()){
        $key = $request->get('key');
        $search_product = Product::where('name','LIKE','%'.$key.'%')->take(5)->get();
      
        return view('user.product.search_ajax',compact('search_product',));
       
      }
    }

}
