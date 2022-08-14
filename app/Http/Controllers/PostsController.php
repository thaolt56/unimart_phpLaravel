<?php

namespace App\Http\Controllers;

use App\category_post;
use Illuminate\Support\Str;

use App\post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostsController extends Controller
{   
    function __construct()
    {
        $this->middleware(function($request, $next){
            session(['module_active' =>'posts']);
            return $next($request);
        });
    }
    function add()
    {
        $category = category_post::all();
        $category = data_tree($category);
        foreach ($category as $item) {
            $data_select[$item->id] = str_repeat('|--', $item->level) . $item->name;
        }
        return view('admin.Posts.add', compact('data_select'));
    }

    function store(Request $request)
    {
        // return $request->input();
        $request->validate(
            [
                'title' => 'required|string|unique:posts|max:255',
                'content' => 'required|',
                'category' => 'required',
                'status' => 'required',
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',

            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài nhiều nhất :max kí tự hoặc (Kb)',
                'unique' => ':attribute đã tồn tại trong hệ thống!',
                'image' => ':attribute Không đúng dịnh dạng ảnh',
            ],
            [
                'name' => 'Tên người dùng',
                'content' => 'Email',
                'category' => 'danh mục',
                'status' => 'Trạng thái',
                'image' => 'Ảnh bài viết',

            ]
        );
        $input = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'cat_id' => $request->input('category'),
            'status' => $request->input('status'),
            'user_id' => Auth::id(),
            'slug' => str::slug($request->input('title')),

        ];
        //validation -> image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_name = $file->getClientOriginalName();
            // echo $file->getSize();
            // echo $file->getClientOriginalExtension();
            $file->move('public/upload/post', $file_name);
            $path_image = 'upload/post/' . $file_name;
            $input['thumbnail'] = $path_image;
        }


        post::create($input);

        return redirect('admin/post/list')->with('status', 'Bạn đã thêm bài viết thành công!');
    }

    function list(Request $request)
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
            $posts  = post::onlyTrashed()->where('title', 'LIKE', "%{$keyword}%")->paginate(5);
        } else if ($status == 'public') {
            $list_act = [
                'destroy' => 'Xóa tạm thời',
                'pending' => 'Chờ duyệt'
            ];
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $posts  = post::where('title', 'LIKE', "%{$keyword}%")->where('status', '=', 'public')->paginate(5);
        } else if ($status == 'pending') {
            $list_act = [
                'destroy' => 'Xóa tạm thời',
                'public' => 'Công khai'
            ];
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $posts  = post::where('title', 'LIKE', "%{$keyword}%")->where('status', '=', 'pending')->paginate(5);
        } else {
            $list_act = [
                'destroy' => 'Xóa tạm thời'
            ];
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $posts  = post::where('title', 'LIKE', "%{$keyword}%")->paginate(5);
        }



        $count_status_full = post::count();
        $count_status_public = post::where('status', '=', 'public')->count();
        $count_status_pending = post::where('status', '=', 'pending')->count();
        $count_status_destroy = post::onlyTrashed()->count();
        $count = [$count_status_full, $count_status_public, $count_status_pending, $count_status_destroy];
        return view('admin.Posts.list', compact('posts', 'count', 'list_act'));
    }

    function delete(Request $request)
    {
        $id = $request->id;
        post::destroy($id);
        return redirect('admin/post/list')->with('status', 'Bạn đã xoá thành công bản ghi!');
    }

    function edit(Request $request)
    {
        $category = category_post::all();
        $category = data_tree($category);
        foreach ($category as $item) {
            $data_select[$item->id] = str_repeat('|--', $item->level) . $item->name;
        }
        $id =  $request->id;
        $post = post::withTrashed()->find($id);
        //  return dd($post);
        return view('admin.Posts.edit', compact('post', 'data_select'));
    }

    //xu ly phan update
    function update(Request $request)
    {
        $id = $request->id;
        // return $id;
          
        // validation
        $request->validate(
            [
                'title' => 'required|string|max:255|unique:posts,title,'.$id.',id',
                'content' => 'required',
                'category' => 'required',
                'status' => 'required',
                'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',

            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài nhiều nhất :max kí tự hoặc (Kb)',
                'unique' => ':attribute đã tồn tại trong hệ thống!',
                'image' => ':attribute Không đúng dịnh dạng ảnh'
            ],
            [
                'name' => 'Tên người dùng',
                'content' => 'Email',
                'category' => 'danh mục',
                'status' => 'Trạng thái',
                'image' => 'Ảnh bài viết',

            ]
        );
        $input = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'cat_id' => $request->input('category'),
            'status' => $request->input('status'),
            'user_id' => Auth::id(),
            'slug' => str::slug($request->input('title')),

        ];
        //validation -> image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_name = $file->getClientOriginalName();
            // echo $file->getSize();
            // echo $file->getClientOriginalExtension();
            $file->move('public/upload/post', $file_name);
            $path_image = 'upload/post/' . $file_name;
            $input['thumbnail'] = $path_image;
        }

        post::withTrashed()->where('id', $id)->update($input);
        // return "ok";
        return redirect('admin/post/list')->with('status', 'Bạn đã cập nhật thành công bài viết!');
    }

    function list_action(Request $request)
    {
        // return $request->input();
        $list_checkbox = $request->input('list_checkbox');
        if (!empty($list_checkbox)) {
            $select = $request->input('select');
            if (!empty($select)) {
                if ($select == 'destroy') {
                    post::destroy('id', $list_checkbox);
                    return redirect('admin/post/list')->with('status', 'Bạn đã xóa tạm thời các bản ghi thành công !');
                } else if ($select == 'pending') {
                    post::whereIn('id', $list_checkbox)->update(['status' => 'pending']);
                    return redirect('admin/post/list')->with('status', 'Bạn đã cho phép "chờ duyệt" các bản ghi thành công !');
                } else if ($select == 'public') {
                    post::whereIn('id', $list_checkbox)->update(['status' => 'public']);
                    return redirect('admin/post/list')->with('status', 'Bạn đã cho phép "công khai" các bản ghi thành công !');
                } else if ($select == 'forceDelete') {
                    post::whereIn('id', $list_checkbox)->forceDelete();
                    return redirect('admin/post/list')->with('status', 'Bạn đã xóa vĩnh viễn các bản ghi thành công !');
                }
                 else if ($select == 'restore') {
                    post::whereIn('id', $list_checkbox)->restore();
                    return redirect('admin/post/list')->with('status', 'Bạn đã khôi phục các bản ghi thành công !');
                }
            } else {
                return redirect('admin/post/list')->with('status', 'Bạn cần chọn tác vụ!');
            }
        } else {
            return redirect('admin/post/list')->with('status', 'Bạn cần chọn bản ghi');
        }
    }
}
