<?php

namespace App\Http\Controllers;

use App\order;
use App\order_detail;
use App\customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'dashboard']);
            return $next($request);
        });
    }


    function show()
    {
        $status_order = [
            'processing' => 'Đang xử lý',
            'delivery' => 'Đang giao hàng',
            'complete' => 'Hoàn thành',
            'cancel_order' => 'Hủy đơn',
        ];
        $orders = order::latest()->paginate(1);
        $order_complete_count = order::where('status', 'complete')->count();
        $order_processing_count = order::where('status', 'processing')->count();
        $order_cancel_count = order::where('status', 'cancel_order')->count();
        $order_delivery_count = order::where('status', 'delivery')->count();

        $order_complete = order::where('status','complete')->get();
        $num = 0;
        foreach($order_complete as $item){
            $num += $item->total;
        }
        
        return view(
            'admin.dashboard',
            compact(
                'orders',
                'status_order',
                'order_complete_count',
                'order_processing_count',
                'order_cancel_count',
                'order_delivery_count',
                'num',
            )
        );
    }
}
