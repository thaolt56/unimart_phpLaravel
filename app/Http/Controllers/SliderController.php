<?php

namespace App\Http\Controllers;
use App\slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{ 
  function __construct()
  {
      $this->middleware(function($request, $next){
          session(['module_active' =>'sliders']);
          return $next($request);
      });
  }
    function list(Request $req){
      $status = $req->input('status');
      // return $status;
    if ($status == 'destroy') {
      $list_act = [
        'forceDelete' => 'Xóa vĩnh viễn',
        'restore' => 'Khôi phục'
      ];

      $sliders  = slider::latest()->onlyTrashed()->paginate(5);
    } else if ($status == 'public') {
      $list_act = [
        'destroy' => 'Xóa tạm thời',
        'pending' => 'Chờ duyệt'
      ];

      $sliders  = slider::latest()->where('status', '=', 0)->paginate(5);
    } else if ($status == 'pending') {
      $list_act = [
        'destroy' => 'Xóa tạm thời',
        'public' => 'Công khai'
      ];
      $sliders = slider::latest()->where('status', '=', 1)->paginate(5);
    } else {
      $list_act = [
        'destroy' => 'Xóa tạm thời'
      ];

      $sliders  = slider::latest()->paginate(5);
    }


    $count_status_full = slider::count();
    $count_status_public = slider::where('status', '=', '0')->count();
    $count_status_pending = slider::where('status', '=', '1')->count();
    $count_status_destroy = slider::onlyTrashed()->count();
    $count = [$count_status_full, $count_status_public, $count_status_pending, $count_status_destroy];


    //     $sliders = slider::latest()->paginate(5);
        return view('admin.Slider.list',compact('sliders','count','list_act'));
    }
    function store(Request $req){
      
    $req->validate(
      [
        'status' => 'required',
        'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',

      ],
      [
        'required' => ':attribute không được để trống',
        'max' => ':attribute có độ dài nhiều nhất :max kí tự hoặc (Kb)',
        'image' => ':attribute Không đúng dịnh dạng ảnh',
      ],
      [
        'status' => 'Trạng thái',
        'image' => 'Ảnh slider',

      ]
    );
    $input = [
      'user_id' =>Auth::id(),
      'status' => $req->input('status'),
    ];
    //validation -> image
    if ($req->hasFile('image')) {
      $file = $req->file('image');
      $file_name = $file->getClientOriginalName();
      // echo $file->getSize();
      // echo $file->getClientOriginalExtension();
      $file->move('public/upload/sliders', $file_name);
      $path_image = 'upload/sliders/' . $file_name;
      $input['slider_path'] = $path_image;
    }
    slider::create($input);
    return redirect()->back()->with('status', 'Bạn thêm ảnh thành công!');
    }

    function delete(Request $req){
        $id = $req->id;
        slider::destroy($id);
        return redirect()->back()->with('status', 'Bạn xóa ảnh slider thành công!');
    }

    function action(Request $req){
        // return $req->input();
        $list_checkbox = $req->input('list_checkbox');
    if (!empty($list_checkbox)) {
      $select = $req->input('select');
      if (!empty($select)) {
        if ($select == 'destroy') {
          // slider::destroy('id', $list_checkbox);
          slider::whereIn('id', $list_checkbox)->delete();
          return redirect()->back()->with('status', 'Bạn đã xóa tạm thời các bản ghi thành công !');
        } else if ($select == 'pending') {
          slider::whereIn('id', $list_checkbox)->update(['status' => '1']);
          return redirect()->back()->with('status', 'Bạn đã cho phép "chờ duyệt" các bản ghi thành công !');
        } else if ($select == 'public') {
          slider::whereIn('id', $list_checkbox)->update(['status' => '0']);
          return redirect()->back()->with('status', 'Bạn đã cho phép "công khai" các bản ghi thành công !');
        } else if ($select == 'forceDelete') {
          slider::whereIn('id', $list_checkbox)->forceDelete();
          return redirect()->back()->with('status', 'Bạn đã xóa vĩnh viễn các bản ghi thành công !');
        } else if ($select == 'restore') {
          slider::whereIn('id', $list_checkbox)->restore();
          return redirect()->back()->with('status', 'Bạn đã khôi phục các bản ghi thành công !');
        }
      } else {
        return redirect()->back()->with('status', 'Bạn cần chọn tác vụ!');
      }
    } else {
      return redirect()->back()->with('status', 'Bạn cần chọn bản ghi');
    }
    }
}
