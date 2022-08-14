<?php

namespace App\Http\Controllers;

use App\Cat_product;
use App\Product;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    function __construct()
    {
        $this->middleware(function($request, $next){
            session(['module_active' =>'products']);
            return $next($request);
        });
    }

    function add_product()
    {
        $cat_product_tree = Cat_product::all();
        $data_select = [];
        if (!empty($cat_product_tree)) {
            $cat_product_tree = data_tree($cat_product_tree);
            foreach ($cat_product_tree as $item) {
                $data_select[$item->id] = str_repeat('|--', $item->level) . $item->name;
            }
        }
        // return dd($cat_product_tree);
        return view('admin.products.add', compact('data_select'));
    }
    function store(Request $request)
    {
        // return $request->input();
        $request->validate(
            [
                'name' => 'required|string|unique:products|max:255',
                'price' => 'required',
                'detail' => 'required',
                'desc' => 'required',

                'status' => 'required',
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'image_detail' => 'required',
                'image_detail.*' => 'mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:2048',
                'category' => 'required',
                'highlight' => 'required',
                'status' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài nhiều nhất :max kí tự hoặc (Kb)',
                'unique' => ':attribute đã tồn tại trong hệ thống!',
                'image' => ':attribute Không đúng dịnh dạng ảnh',
                // 'image_detail' => ':attribute Không đúng dịnh dạng ảnh',
            ],
            [
                'name' => 'Tên sản phẩm',
                'price' => 'Giá',
                'desc' => 'Mô tả ngắn sản phẩm',
                'detail' => 'chi tiết sản phẩm',
                'status' => 'Trạng thái',
                'category' => 'Danh mục',
                'image' => 'Ảnh bài viết',
                'image_detail' => 'Ảnh chi tiết bài viết',
                'highlight' => 'Nổi bật',

            ]
        );

        $input = [
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'desc' => $request->input('desc'),
            'content' => $request->input('detail'),
            'status' => $request->input('status'),
            'warehouse' => $request->input('warehouse'),
            'cat_id' => $request->input('category'),
            'highlight' => $request->input('highlight'),
            'user_id' => Auth::id(),
            'slug' => str::slug($request->input('name')),

        ];

        //validation -> image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_name = $file->getClientOriginalName();
            // echo $file->getSize();
            // echo $file->getClientOriginalExtension();
            $file->move('public/upload/product', $file_name);
            $path_image = 'upload/product/' . $file_name;
            $input['thumbnail'] = $path_image;
        }

        //validate ->images
        $product = Product::create($input);
        $product_id = $product->id;
        // return $product_id;

        if ($request->hasFile('image_detail')) {
            foreach ($request->file('image_detail') as $file) {
                $file_name = $file->getClientOriginalName();
                $file->move('public/upload/product_detail', $file_name);
                // $path_image[] = 'upload/product_detail/' . $file_name;
                Image::create([
                    'product_images' => 'upload/product_detail/' . $file_name,
                    'status' => 'public',
                    'product_id' => $product_id,
                ]);
            }
        }



        return redirect('admin/product/list')->with('status', 'Bạn đã thêm sản phẩm thành công!');
    }

    function list_product(Request $request)
    {
        $status = $request->input('status');
        // $list_act = [
        //     'destroy' => 'Xóa tạm thời'
        // ];

        if ($status == 'destroy') {
            $list_act = [
                'forceDelete' => 'Xóa vĩnh viễn',
                'restore' => 'Khôi phục'
            ];
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $list_products  = Product::onlyTrashed()->where('name', 'LIKE', "%{$keyword}%")->paginate(5);
        } else if ($status == 'public') {
            $list_act = [
                'destroy' => 'Xóa tạm thời',
                'pending' => 'Chờ duyệt'
            ];
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $list_products  = Product::where('name', 'LIKE', "%{$keyword}%")->where('status', '=', 'public')->paginate(5);
        } else if ($status == 'pending') {
            $list_act = [
                'destroy' => 'Xóa tạm thời',
                'public' => 'Công khai'
            ];
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $list_products  = Product::where('name', 'LIKE', "%{$keyword}%")->where('status', '=', 'pending')->paginate(5);
        } else {
            $list_act = [
                'destroy' => 'Xóa tạm thời'
            ];
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $list_products  = Product::where('name', 'LIKE', "%{$keyword}%")->paginate(5);
        }
        $count_status_full = Product::count();
        $count_status_public = Product::where('status', '=', 'public')->count();
        $count_status_pending = Product::where('status', '=', 'pending')->count();
        $count_status_destroy = Product::onlyTrashed()->count();
        $count = [$count_status_full, $count_status_public, $count_status_pending, $count_status_destroy];
        // return view('admin.Posts.list', compact('posts', 'count', 'list_act'));


        return view('admin.products.list', compact('list_products', 'count', 'list_act', 'status'));
    }

    function delete_product(Request $request)
    {

        $id = $request->id;
        Product::destroy($id);
        return redirect('admin/product/list')->with('status', 'Bạn đã xóa thành công bản ghi!');
    }

    function list_action(Request $request)
    {
        // return $request->input();
        $list_checkbox = $request->input('list_checkbox');
        if (!empty($list_checkbox)) {
            $select = $request->input('select');
            if (!empty($select)) {
                if ($select == 'destroy') {
                    Product::destroy('id', $list_checkbox);
                    return redirect('admin/product/list')->with('status', 'Bạn đã xóa tạm thời các bản ghi thành công !');
                } else if ($select == 'pending') {
                    Product::whereIn('id', $list_checkbox)->update(['status' => 'pending']);
                    return redirect('admin/product/list')->with('status', 'Bạn đã cho phép "chờ duyệt" các bản ghi thành công !');
                } else if ($select == 'public') {
                    Product::whereIn('id', $list_checkbox)->update(['status' => 'public']);
                    return redirect('admin/product/list')->with('status', 'Bạn đã cho phép "công khai" các bản ghi thành công !');
                } else if ($select == 'forceDelete') {
                    Product::whereIn('id', $list_checkbox)->forceDelete();
                    return redirect('admin/product/list')->with('status', 'Bạn đã xóa vĩnh viễn các bản ghi thành công !');
                } else if ($select == 'restore') {
                    Product::whereIn('id', $list_checkbox)->restore();
                    return redirect('admin/product/list')->with('status', 'Bạn đã khôi phục các bản ghi thành công !');
                }
            } else {
                return redirect('admin/product/list')->with('status', 'Bạn cần chọn tác vụ!');
            }
        } else {
            return redirect('admin/product/list')->with('status', 'Bạn cần chọn bản ghi');
        }
    }

    function edit_product(Request $request)
    {
        // return $request->id;
        $id = $request->id;
        $product = Product::find($id);
        $list_images = Product::find($id)->image_detail;

        //   foreach($list_images as $image){
        //       echo $image->product_images;
        //   }
        $cat_product_tree = Cat_product::all();
        $data_select = [];
        if (!empty($cat_product_tree)) {
            $cat_product_tree = data_tree($cat_product_tree);
            foreach ($cat_product_tree as $item) {
                $data_select[$item->id] = str_repeat('|--', $item->level) . $item->name;
            }
        }
        return view('admin.products.edit', compact('product', 'data_select', 'list_images'));
    }

    function update(Request $req)
    {
        $id = $req->id;
        // return $id;

        // return $req->input();
        $req->validate(
            [
                'name' => 'required|string|max:255,|unique:products,name,'.$id.',id',

                'price' => 'required',
                'detail' => 'required',
                'desc' => 'required',
                'status' => 'required',
                'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                // 'image_detail' => 'required',
                'image_detail.*' => 'mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:2048',
                'category' => 'required',
                'highlight' => 'required',
                'status' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài nhiều nhất :max kí tự hoặc (Kb)',
                'unique' => ':attribute đã tồn tại trong hệ thống!',
                'image' => ':attribute Không đúng dịnh dạng ảnh',
                // 'image_detail' => ':attribute Không đúng dịnh dạng ảnh',
            ],
            [
                'name' => 'Tên sản phẩm',
                'price' => 'Giá',
                'desc' => 'Mô tả ngắn sản phẩm',
                'detail' => 'chi tiết sản phẩm',
                'status' => 'Trạng thái',
                'category' => 'Danh mục',
                'image' => 'Ảnh bài viết',
                'image_detail' => 'Ảnh chi tiết bài viết',
                'highlight' => 'Nổi bật',

            ]
        );

        $input = [
            'name' => $req->input('name'),
            'price' => $req->input('price'),
            'desc' => $req->input('desc'),
            'content' => $req->input('detail'),
            'status' => $req->input('status'),
            'warehouse' => $req->input('warehouse'),
            'cat_id' => $req->input('category'),
            'highlight' => $req->input('highlight'),
            'user_id' => Auth::id(),
            'slug' => str::slug($req->input('name')),

        ];

        //validation -> image
        if ($req->hasFile('image')) {
            $file = $req->file('image');
            $file_name = $file->getClientOriginalName();
            // return $file_name;
            $file->move('public/upload/product', $file_name);
            $path_image = 'upload/product/' . $file_name;
            $input['thumbnail'] = $path_image;
        }

        //validate ->images
        Product::withTrashed()->where('id', $id)->update($input);

        // return $product_id;
//xoa roi them lai o bang Images
        if ($req->hasFile('image_detail')) {
            Image::where('product_id',$id)->forceDelete();
            foreach ($req->file('image_detail') as $file) {
                $file_name = $file->getClientOriginalName();
                $file->move('public/upload/product_detail', $file_name);
                // $path_image[] = 'upload/product_detail/' . $file_name;
                Image::create([
                    'product_images' => 'upload/product_detail/' . $file_name,
                    'status' => 'public',
                    'product_id' => $id,
                ]);
            }
        }

        return redirect('admin/product/list')->with('status', 'Bạn đã cập nhật thành công bản ghi!');
    }
}
