@extends('layouts.user')
@section('css')
    <style>
        /* .cart_ok{
            text-align: center
        } */
        .card-text{
            font-size: 18px;
            /* color: #1aaa3e; */
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
                <img class="" width="700px"  src="{{asset('user/public/images/hinh-thuc-thanh-toan.png')}}" alt="">
            </div>
           
            <div class="card w-100">
                <div class="card-body">
                  <h3 class="card-title">HƯỚNG DẪN THANH TOÁN</h3>
                  <div class="card-text">
                    <p><span style="font-size: 12pt;">- <strong>Tiền mặt:</strong> Thanh toán trực tiếp tại cửa hàng hoặc nhân viên của cửa hàng thu tiền tại nơi giao hàng</span></p>
                    <p><span style="font-size: 12pt;">- <strong>Trả góp:</strong> Trả góp bằng thẻ tín dụng</span></p>
                    <p><span style="font-size: 12pt;">- <strong>Internet Banking:</strong> Bằng cách chuyển khoản&nbsp;</span></p>
                    <p><span style="font-size: 12pt;">- <strong>Quẹt thẻ</strong>: Hỗ trợ quẹt thẻ ATM nội địa và ngoại địa</span></p>
                    <p style="text-align: justify;"><span style="font-size: 12pt;"><strong>Danh sách ngân hàng thanh toán online:</strong>&nbsp;ABBANK, ACB, Agribank, BAOVIET Bank, BIDV, DongA Bank, Eximbank, GPBank, HDBank, HSBC, IVB, Kienlongbank, LienVietPostBank, MB, MSB, Nam A Bank, OceanBank, PBVN, PG Bank, PVcomBank, Sacombank, SAIGONBANK, SeABank, SHB, SHBVN, Techcombank, TPBank, VIB, VietABank, Vietbank, Vietcombank, VietinBank, VPBank...</span></p>
                  </div>
                  <a href="{{route('home')}}" class="btn btn-primary">Quay lại trang chủ</a>
                </div>
              </div>
          </div>
          
    </div>
@endsection