<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Cat_product;

class Cat_productController extends Controller
{
    function list_cat()
    {
        $cat_product = Cat_product::latest()->paginate(5);

        $cat_product_tree = Cat_product::all();
       
        $data_select = [];
        if (!empty($cat_product_tree)) {
            $cat_product_tree = data_tree($cat_product_tree);
            foreach ($cat_product_tree as $item) {
                $data_select[$item->id] = str_repeat('|--', $item->level) . $item->name;
            }
        }

        return view('admin.cat_product.list', compact('data_select', 'cat_product'));
    }

    function store(Request $request)
    {

        // return $request->input();
        $request->validate(
            [
                'name' => 'required|min:2|max:255',
                'category' => 'required',
                // 'status' => 'required',

            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhât :min kí tự ',
                'max' => ':attribute có độ dài nhiều nhất :max kí tự',
                'unique' => ':attribute đã tồn tại trong hệ thống!'
            ],
            [
                'name' => 'Tên danh mục',
                'category' => 'Danh mục',
                // 'status' => 'Trạng thái',

            ]
        );

        Cat_product::create([
            'name' => $request->input('name'),
            'parent_id' => $request->input('category'),
            'slug' => Str::slug($request->input('name')),
            // 'status' => $request->input('status'),
        ]);
        // return "ok";
        return redirect('admin/product/cat/list')->with('status', 'Bạn đã thêm danh mục sp thành công!');
    }

    function edit(Request $request)
    {
        $id = $request->id;
        $cat = Cat_product::find($id);
        $cat_product_tree = Cat_product::all();
        $data_select = [];
        if (!empty($cat_product_tree)) {
            $cat_product_tree = data_tree($cat_product_tree);
            foreach ($cat_product_tree as $item) {
                $data_select[$item->id] = str_repeat('|--', $item->level) . $item->name;
            }
        }
        return view('admin.cat_product.edit', compact('data_select', 'cat'));
    }

    function update(Request $request)
    {
        // return $request->input();
        $request->validate(
            [
                'name' => 'required|min:2|max:255',
                'category' => 'required',
                // 'status' => 'required',

            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhât :min kí tự ',
                'max' => ':attribute có độ dài nhiều nhất :max kí tự',
                'unique' => ':attribute đã tồn tại trong hệ thống!'
            ],
            [
                'name' => 'Tên danh mục',
                'category' => 'Danh mục',
                // 'status' => 'Trạng thái',

            ]
        );
        $id = $request->id;
        Cat_product::where('id', $id)->update([
            'name' => $request->input('name'),
            'parent_id' => $request->input('category'),
            'slug' => Str::slug($request->input('name')),
        ]);
        return redirect('admin/product/cat/list')->with('status', 'Bạn đã chỉnh sửa danh mục sp thành công!');
    }
    function delete(Request $request){
        $id = $request->id;
        Cat_product::destroy($id);
        return redirect('admin/product/cat/list')->with('status', 'Bạn đã xóa danh mục sp thành công!');
    }
}
