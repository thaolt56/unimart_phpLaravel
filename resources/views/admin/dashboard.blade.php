@extends('layouts.admin');
@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                <div class="card-body">
                    <h5 class="card-title">{{$order_complete_count}}</h5>
                    <p class="card-text">Đơn hàng giao dịch thành công</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐANG XỬ LÝ</div>
                <div class="card-body">
                    <h5 class="card-title">{{$order_processing_count}}</h5>
                    <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header">DOANH SỐ</div>
                <div class="card-body">
                    <h5 class="card-title">{{number_format($num,0,'','.')}}₫</h5>
                    <p class="card-text">Doanh số hệ thống</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG HỦY</div>
                <div class="card-body">
                    <h5 class="card-title">{{$order_cancel_count}}</h5>
                    <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                </div>
            </div>
        </div>
      
    </div>
    <div class="row">
        <div class="col">
            <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐANG GIAO HÀNG</div>
                <div class="card-body">
                    <h5 class="card-title">{{$order_delivery_count}}</h5>
                    <p class="card-text">Số đơn đang giao hàng</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end analytic  -->
    <div class="card">
        <div class="card-header font-weight-bold">
            ĐƠN HÀNG MỚI
        </div>
        <div class="card-body">
            {{-- <table class="table table-striped"> --}}
                <table class="table table-striped ">
                    <thead>
                        <tr>
                           
                            <th scope="col">#</th>
                            <th scope="col">Mã</th>
                            <th scope="col">Khách hàng</th>
                            {{-- <th scope="col">Sản phẩm</th> --}}
                            <th scope="col">Số lượng</th>
                            <th scope="col">Giá trị</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    @if ($orders->total()>0)
                    <tbody>
                        <?php $t = 0 ?>
                        @foreach ($orders as $order)
                        <tr>
                            <?php $t++ ?>
                            <td>{{$t}}</td>
                            <td>{{$order->code_order}}</td>
                            <td>
                               {{$order->customer->name}} <br>
                               {{$order->customer->phone}}
                            </td>
                         
                            <td>{{$order->number}}</td>
                            <td>{{number_format($order->total,0,'','.')}}₫</td>
                            @if ($order->status == 'processing')
                            <td><span class="badge badge-primary p-2">{{$status_order[$order->status]}}</span></td>
                            @endif
                            @if ($order->status == 'delivery')
                            <td><span class="badge badge-warning p-2">{{$status_order[$order->status]}}</span></td>
                            @endif
                            @if ($order->status == 'complete')
                            <td><span class="badge badge-success p-2">{{$status_order[$order->status]}}</span></td>
                            @endif
                            @if ($order->status == 'cancel_order')
                            <td><span class="badge badge-dark p-2">{{$status_order[$order->status]}}</span></td>
                            @endif
                            
                            <td>{{date('d/m/Y', strtotime($order->created_at))}}</td>
                            <td>
                                <a href="{{route('order.order_detail',$order->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="order_detail"><i class="far fa-eye"></i></a>
                                <a href="{{route('order.cancel',$order->id)}}" onclick="return confirm('Bạn có chắc xóa bản ghi này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        
    
                    </tbody>
                    @else
                    <tr>
                        <td colspan="9"><p >Danh sách không tồn tại!</p></td>
                    </tr>  
                    @endif
                   
                </table>
            
            {{$orders->links()}}
        </div>
    </div>

</div>
@endsection