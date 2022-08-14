<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    function __construct()
    {
        $this->middleware(function($request, $next){
            session(['module_active' =>'pages']);
            return $next($request);
        });
    }

    function add(Request $request)
    {

        return view('admin.pages.add');
    }
    function action_add(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255|unique:pages',
                'content' => 'required|min:3|max:10000',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhât :min kí tự ',
                'max' => ':attribute có độ dài nhiều nhất :max kí tự',
                'unique' => 'Dữ liệu đã tồn tại',
            ],
            [
                'title' => 'Tiêu để trang',
                'content' => 'Nội dụng',
            ]
        );
        Page::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'creator' => Auth::user()->name,

        ]);
        return redirect('admin/page/list')->with('status', 'Bạn đã thêm trang thành công!');
    }

    function list(Request $request)
    {
        // $keyword = "";
        // if ($request->input('keyword')) {
        //     $keyword = $request->input('keyword');
        // }
        // $list_pages = Page::where('title', 'LIKE', "%{$keyword}%")->paginate(5);


        // return view('admin.pages.list', compact('list_pages'));
        $status = $request->input('status');
        $list_act = [
            'delete' => 'Xóa tạm thời'
        ];

        if ($status == 'trash') {
            $list_act = [
                'forceDelete' => 'Xóa vĩnh viễn',
                'restore' => 'Khôi phục'
            ];
            $pages = Page::onlyTrashed()->paginate(5);
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $pages = Page::where('title', 'LIKE', "%{$keyword}%")->paginate(5);
        }

        $count_status_active = Page::count();
        $count_status_trash = Page::onlyTrashed()->count();
        $count = [$count_status_active, $count_status_trash];
        return view('admin.pages.list', compact('pages', 'count', 'list_act'));
    }

    function delete(Request $request)
    {
        $id = $request->id;
        Page::destroy($id);
        return redirect('admin/page/list')->with('status', 'Bạn đã xóa thành công trang!');
    }

    function edit(Request $request)
    {
        $id = $request->id;
        $page =   Page::find($id);
        return view('admin.pages.update', compact('page'));
    }

    function action_update(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255|unique:pages',
                'content' => 'required|min:3|max:10000',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhât :min kí tự ',
                'max' => ':attribute có độ dài nhiều nhất :max kí tự',
                'unique' => 'Dữ liệu đã tồn tại',
            ],
            [
                'title' => 'Tiêu để trang',
                'content' => 'Nội dụng',
            ]
        );
        $id = $request->id;
        Page::where('id', $id)->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'editor' => Auth::user()->name,

        ]);

        return redirect('admin/page/list')->with('status', 'Bạn đã chỉnh sửa trang thành công!');
    }

    function action_checkbox(Request $request)
    {
        $list_check = $request->input('list_checkbox');
        if (!empty($list_check)) {

            $action = $request->input('select_action');
            if ($action == '0') {
                return redirect('admin/page/list')->with('status', 'Bạn chưa chọn tác vụ!');
            }
            if ($action == 'delete') {
                Page::destroy($list_check);
                return redirect('admin/page/list')->with('status', 'Bạn đã xóa bản ghi thành công!');
            }
            if ($action == 'restore') {
                Page::onlyTrashed()->whereIn('id', $list_check)->restore();
                return redirect('admin/page/list')->with('status', 'Bạn đã khôi phục bản ghi thành công!');
            }
            if ($action == 'forceDelete') {
                Page::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                return redirect('admin/page/list')->with('status', 'Bạn đã xóa vĩnh viễn bản ghi thành công!');
            }
        } else {
            return redirect('admin/page/list')->with('status', 'Bạn cần chọn bản ghi !');
        }
    }
}
