<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

class ImagesController extends Controller
{



  function images(Request $req)
  {

    $status = $req->input('status');
    $product_id = $req->id;

    if ($status == 'destroy') {
      $list_act = [
        'forceDelete' => 'Xóa vĩnh viễn',
        'restore' => 'Khôi phục'
      ];

      $images  = Image::where('product_id', $product_id)->onlyTrashed()->paginate(5);
    } else if ($status == 'public') {
      $list_act = [
        'destroy' => 'Xóa tạm thời',
        'pending' => 'Chờ duyệt'
      ];

      $images  = Image::where('product_id', $product_id)->where('status', '=', 'public')->paginate(5);
    } else if ($status == 'pending') {
      $list_act = [
        'destroy' => 'Xóa tạm thời',
        'public' => 'Công khai'
      ];
      $images  = Image::where('product_id', $product_id)->where('status', '=', 'pending')->paginate(5);
    } else {
      $list_act = [
        'destroy' => 'Xóa tạm thời'
      ];

      $images  = Image::where('product_id', $product_id)->paginate(5);
    }


    $count_status_full = Image::where('product_id', $product_id)->count();
    $count_status_public = Image::where('product_id', $product_id)->where('status', '=', 'public')->count();
    $count_status_pending = Image::where('product_id', $product_id)->where('status', '=', 'pending')->count();
    $count_status_destroy = Image::where('product_id', $product_id)->onlyTrashed()->count();
    $count = [$count_status_full, $count_status_public, $count_status_pending, $count_status_destroy];

    // $product_id = $req->id;
    // $images = Image::where('product_id', $product_id)->latest()->paginate(5);
    // // return $images;

    return view('admin.products.images', compact('images', 'count', 'list_act', 'product_id'));
  }

  function delete(Request $req)
  {
    $id = $req->id;
    Image::destroy($id);
    return redirect()->back()->with('status', 'Đã xóa thành công ảnh!');
  }

  function list_action(Request $req)
  {
    // return $req->input();
    $list_checkbox = $req->input('list_checkbox');
    if (!empty($list_checkbox)) {
      $select = $req->input('select');
      if (!empty($select)) {
        if ($select == 'destroy') {
          Image::destroy('id', $list_checkbox);
          return redirect()->back()->with('status', 'Bạn đã xóa tạm thời các bản ghi thành công !');
        } else if ($select == 'pending') {
          Image::whereIn('id', $list_checkbox)->update(['status' => 'pending']);
          return redirect()->back()->with('status', 'Bạn đã cho phép "chờ duyệt" các bản ghi thành công !');
        } else if ($select == 'public') {
          Image::whereIn('id', $list_checkbox)->update(['status' => 'public']);
          return redirect()->back()->with('status', 'Bạn đã cho phép "công khai" các bản ghi thành công !');
        } else if ($select == 'forceDelete') {
          Image::whereIn('id', $list_checkbox)->forceDelete();
          return redirect()->back()->with('status', 'Bạn đã xóa vĩnh viễn các bản ghi thành công !');
        } else if ($select == 'restore') {
          Image::whereIn('id', $list_checkbox)->restore();
          return redirect()->back()->with('status', 'Bạn đã khôi phục các bản ghi thành công !');
        }
      } else {
        return redirect()->back()->with('status', 'Bạn cần chọn tác vụ!');
      }
    } else {
      return redirect()->back()->with('status', 'Bạn cần chọn bản ghi');
    }
  }
  function add(Request $req)
  {
    $product_id = $req->id;
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
        'image' => 'Ảnh bài viết',

      ]
    );
    $input = [
      'product_id' =>$product_id,
      'status' => $req->input('status'),
    ];
    //validation -> image
    if ($req->hasFile('image')) {
      $file = $req->file('image');
      $file_name = $file->getClientOriginalName();
      // echo $file->getSize();
      // echo $file->getClientOriginalExtension();
      $file->move('public/upload/product_detail', $file_name);
      $path_image = 'upload/product_detail/' . $file_name;
      $input['product_images'] = $path_image;
    }
    Image::where('product_id',$product_id)->create($input);
    return redirect()->back()->with('status', 'Bạn thêm ảnh thành công!');
  }
}
