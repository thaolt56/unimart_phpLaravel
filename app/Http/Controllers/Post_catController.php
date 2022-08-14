<?php

namespace App\Http\Controllers;


use Illuminate\Support\Str;
use App\category_post;
use Illuminate\Http\Request;

class Post_catController extends Controller
{
    function list()
    {
        $category = category_post::all();
        // $category = data_tree($category);
        // foreach($category as $item){
        //     $data_select[$item->id] = str_repeat('|--',$item->level).$item->name;
        // }
        $data_select=[];
        if (!empty($category)) {
            $category = data_tree($category);
            foreach ($category as $item) {
                $data_select[$item->id] = str_repeat('|--', $item->level) . $item->name;
            }
        }
       
        return view('admin.Posts.list_cat', compact('data_select','category'));
    }

    function store(Request $request)
    {
        // return $request->input();
        $request->validate(
            [
                'name' => 'required|min:3|max:255|unique:category_posts',
                'category' => 'required',
                // 'status' => 'required',

            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhât :min kí tự ',
                'max' => ':attribute có độ dài nhiều nhất :max kí tự',
                'unique'=>':attribute đã tồn tại trong hệ thống!'
            ],
            [
                'name' => 'Tên danh mục',
                'category' => 'Danh mục',
                // 'status' => 'Trạng thái',

            ]
        );

        category_post::create([
            'name' => $request->input('name'),
            'parent_id' => $request->input('category'),
            'slug' => Str::slug($request->input('name')),
            // 'status' => $request->input('status'),
        ]);
        // return "ok";
        return redirect('admin/post/cat/list')->with('status','Bạn đã thêm danh mục thành công!');
    }

    function delete(Request $request){
        $id= $request->id;
        category_post::destroy($id);
        return redirect('admin/post/cat/list')->with('status','Bạn đã xóa danh mục thành công!');
    }
}
