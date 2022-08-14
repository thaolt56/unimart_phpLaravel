@extends('layouts.user')
@section('css')
    <style>
        .cart_ok{
            text-align: center
        }
        .card-text{
            font-size: 18px;
            color: #1aaa3e;
        }
        .icon_cart {
            display: flex;
            justify-content: center;
        }
        .card{
            border-style:none!important;
        }
    </style>
@endsection
@section('content')
<div id="wrapper" class="wp-inner clearfix">
       
          <div class="cart_ok">
            <div class="icon_cart">
                <img class="" width="450px"  src="{{asset('user/public/images/icon-dat-hang-thanh-cong-09.jpg')}}" alt="">
            </div>
           
            <div class="card w-100">
                <div class="card-body">
                  <h3 class="card-title">Đặt hàng thành công!</h3>
                  <div class="card-text">
                    <strong>  Cảm ơn Quý Khách đã đặt hàng tại UNIMART</strong>
                        <p>Chúng tôi sẽ liên hệ Quý Khách để xác nhận đơn hàng trong thời gian sớm nhất</p>
                        <p> Xin chân thành cảm ơn!</p>
                  </div>
                  <a href="{{route('home')}}" class="btn btn-primary">Quay lại trang chủ</a>
                </div>
              </div>
          </div>
          
    </div>
@endsection