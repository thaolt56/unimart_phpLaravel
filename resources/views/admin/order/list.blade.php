@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
    <div class="alert alert-primary" role="alert">
        {{session('status')}}
    </div>
    @endif
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách đơn hàng</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="text" class="form-control form-search" placeholder="Tìm kiếm" name="keyword" value="{{request()->input('keyword')}}">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status'=>'full'])}}" class="text-primary">Tất cả<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'complete'])}}" class="text-primary">Hoàn thành<span class="text-muted">({{$count[1]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'delivery'])}}" class="text-primary">Đang giao hàng<span class="text-muted">({{$count[2]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'processing'])}}" class="text-primary">Đang xử lý<span class="text-muted">({{$count[3]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'cancel_order'])}}" class="text-primary">Đơn hàng hủy<span class="text-muted">({{$count[4]}})</span></a>
            </div>
            <form action="{{route('order.action')}}" method="POST">
                @csrf
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" id="" name="select">
                    <option value="">Chọn</option>
                  
                    @foreach ($list_act as $k => $v)
                    <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                 
                </select>
                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
            </div>
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="checkall">
                        </th>
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
                    @foreach ($orders as $order)
                    <tr>
                        <td>
                            <input type="checkbox" name="list_checkbox[]" value="{{$order->id}}">
                        </td>
                        <td>1</td>
                        <td>{{$order->code_order}}</td>
                        <td>
                           {{$order->customer->name}} <br>
                           {{$order->customer->phone}}
                        </td>
                        {{-- <td><a href="#">Samsung Galaxy A51 (8GB/128GB)</a></td> --}}
                        <td>{{$order->number}}</td>
                        <td>{{$order->total}}VND</td>
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
        </form>
            {{$orders->links()}}
        </div>
    </div>
</div>
@endsection