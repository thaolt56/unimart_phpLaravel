@extends('layouts.admin')
@section('title', 'Chi tiết đơn hàng')

@section('content')
@if (session('status'))
<div class="alert alert-primary" role="alert">
    {{session('status')}}
</div>
@endif
    <div id="content" class="container-fluid detail-order">
        <div class="card info-order">
            <div class="card-header font-weight-bold">
                Thông tin đơn hàng
            </div>
            <div class="card-body">
                <ul class="list-item">
                    <li> 
                        <h5 class="title">
                            <i class="fas fa-info-circle"></i>
                            Thông tin khách hàng
                        </h5>
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Họ và tên</th>
                                    <th>Mã đơn hàng</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Email</th>
                                    <th>Thời gian đặt hàng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$order->customer->name}}</td>
                                    <td>{{$order->code_order}}</td>
                                    <td>{{$order->customer->phone}}</td>
                                    <td>{{$order->customer->address}}</td>
                                    <td>{{$order->customer->email}}</td>
                                    <td>{{date('d/m/Y', strtotime($order->created_at))}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </li>
                    <form action="{{route('order_detail.action',$order->id)}}" method="POST" >
                        @csrf
                        <li>
                            <h5 class="title">
                                <i class="fas fa-tasks"></i>
                                Tình trạng đơn hàng
                            </h5>
                            <select name="status" id="">
                                @foreach ($status_order as $k => $v)
                                    <option value="{{ $k }}" @if ($order->status == $k)
                                        {{"selected = 'selected'"}}
                                    @endif>
                                     {{$v}}
                                    </option>
                                @endforeach
                            </select>
                            <input type="submit" class="btn btn-primary" value="Cập nhật đơn hàng" name="btn-updateOrder">
                            
                        </li>
                    </form>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-header font-weight-bold">
                Chi tiết đơn hàng
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" >Ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $t = 0;
                        @endphp
                        @foreach ($order_detail as $item)
                        @php
                            $t+=1;
                        @endphp
                            <tr>
                                <td scope="row">{{$t}}</td>
                                <td><img width="120px" src="{{asset($item->product->thumbnail)}}" alt=""></td>
                                <td>{{$item->product->name}}</td>
                                <td>{{number_format($item->product->price,0,'','.')}}₫</td>
                                <td>{{$item->qty}}</td>
                                <td>{{number_format($item->product->price*$item->qty,0,'','.')}}₫</td>
                             
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header font-weight-bold">
                Giá trị đơn hàng
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td class="title-num">Tổng số lượng sản phẩm</td>
                        <td class="detail-num">{{$order->number}} sản phẩm</td>
                    </tr>
                    <tr class="total-order">
                        <td class="text-success">Tổng giá trị đơn hàng</td>
                        <td class="text-success">{{number_format($order->total,0,'','.')}}₫</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection

