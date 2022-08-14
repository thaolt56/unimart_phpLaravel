<?php

namespace App\Http\Controllers;

use App\order;
use App\customer;
use App\order_detail;
use App\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    function __construct()
  {
      $this->middleware(function($request, $next){
          session(['module_active' =>'orders']);
          return $next($request);
      });
  }
    function list(Request $request)
    {
        $status_order = [
            'processing' => 'Đang xử lý',
            'delivery' => 'Đang giao hàng',
            'complete' => 'Hoàn thành',
            'cancel_order' => 'Hủy đơn',
        ];

        $status = $request->input('status');

        if ($status == 'cancel_order') {
            $list_act = [
                'forceDelete' => 'Xóa vĩnh viễn',
                'processing' => 'Đang xử lý'
            ];
        
            $orders  = order::where('status', '=', 'cancel_order')->paginate(5);
        } else if ($status == 'processing') {
            $list_act = [
                'cancel_order' => 'Hủy đơn hàng',
                'delivery' => 'Đang giao hàng',
                'complete' => 'Hoàn thành',
            ];
            
            $orders  = order::where('status', '=', 'processing')->paginate(5);
        } else if ($status == 'delivery') {
            $list_act = [
                'cancel_order' => 'Hủy đơn hàng',
                'complete' => 'Hoàn thành',
                'processing' => 'Đang xử lý',
            ];
            
            $orders  = order::where('status', '=', 'delivery')->paginate(5);
        } else if ($status == 'complete') {
            $list_act = [
                'cancel_order' => 'Hủy đơn hàng',
                'delivery' => 'Đang giao hàng',
                'processing' => 'Đang xử lý',
            ];
           
            $orders  = order::where('status', '=', 'complete')->paginate(5);
        } else {
            $list_act = [
                'cancel_order' => 'Hủy đơn hàng',
            ];
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $customers = customer::where('name', 'LIKE', "%{$keyword}%")->get();
            $customer_id = [];
            foreach ($customers as $item) {
                $customer_id[] = $item->id;
            }
            $orders  = order::whereIn('customer_id', $customer_id)->latest()->paginate(5);
        }
        $count_status_full = order::count();
        $count_status_cancel_order = order::where('status', '=', 'cancel_order')->count();
        $count_status_processing = order::where('status', '=', 'processing')->count();
        $count_status_delivery = order::where('status', '=', 'delivery')->count();
        $count_status_complete = order::where('status', '=', 'complete')->count();
        $count = [
            $count_status_full, $count_status_complete,  $count_status_delivery, $count_status_processing,
            $count_status_cancel_order
        ];
      
        return view('admin.order.list', compact('orders', 'status_order', 'count', 'list_act'));
    }
    function action(Request $request)
    {
        // return $request->input();
        $list_checkbox = $request->input('list_checkbox');
        if (!empty($list_checkbox)) {
            $select = $request->input('select');
            // return $select;
            if (!empty($select)) {
                if ($select == 'cancel_order') {
                    order::whereIn('id', $list_checkbox)->update(['status' => 'cancel_order']);
                    return redirect('admin/order/list')->with('status', 'Bạn đã hủy đơn hàng thành công !');
                } else if ($select == 'processing') {
                    order::whereIn('id', $list_checkbox)->update(['status' => 'processing']);
                    return redirect('admin/order/list')->with('status', 'Bạn đã chuyển trạng thái "Đang xử lý" cho đơn hàng thành công !');
                } else if ($select == 'delivery') {
                    order::whereIn('id', $list_checkbox)->update(['status' => 'delivery']);
                    return redirect('admin/order/list')->with('status', 'Bạn đã chuyển trạng thái "Giao hàng" cho đơn hàng thành công !');
                } else if ($select == 'complete') {
                    order::whereIn('id', $list_checkbox)->update(['status' => 'complete']);
                    return redirect('admin/order/list')->with('status', 'Bạn đã chuyển trạng thái "Hoàn thành" cho đơn hàng thành công !');
                } else if ($select == 'forceDelete') {
                    order::whereIn('id', $list_checkbox)->forceDelete();
                    return redirect('admin/order/list')->with('status', 'Bạn đã xóa vĩnh viễn đơn hàng thành công !');
                }
            } else {
                return redirect('admin/order/list')->with('status', 'Bạn cần chọn tác vụ!');
            }
        } else {
            return redirect('admin/order/list')->with('status', 'Bạn cần chọn bản ghi');
        }
    }

    function detail(Request $request)
    {
        $status_order = [
            'processing' => 'Đang xử lý',
            'delivery' => 'Đang giao hàng',
            'complete' => 'Hoàn thành',
            'cancel_order' => 'Hủy đơn',
        ];
        $id = $request->id;
        $order = order::find($id);
        $order_detail = order_detail::where('order_id', $id)->get();
        
     
        return view('admin.order.detail', compact('order', 'status_order','order_detail'));
    }

    function order_detail_action(Request $request)
    {
        $status = $request->input('status');
        $id = $request->id;
       order::where('id',$id)->update([
           'status' => $status,
       ]);
       return redirect()->back()->with('status','Đã cập nhật trạng thái cho đơn hàng thành công!');
    }

    function cancel(Request $request){
        $id = $request->id;
       order::where('id',$id)->update([
           'status'=>'cancel_order'
       ]);
       return redirect()->back()->with('status','Đã cập nhật xóa đơn hàng thành công!');
    }
}
