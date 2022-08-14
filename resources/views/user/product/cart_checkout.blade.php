@extends('layouts.user')

@section('content')
<div id="main-content-wp" class="checkout-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="?page=home" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Thanh toán</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <form method="POST" action="{{route('cart.customer')}}" name="form-checkout">
        @csrf
    <div id="wrapper" class="wp-inner clearfix">
        <div class="section" id="customer-info-wp">
            <div class="section-head">
                <h1 class="section-title">Thông tin khách hàng</h1>
            </div>
            <div class="section-detail">
            
                   
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="fullname">Họ tên</label>
                            <input type="text" name="fullname" id="fullname" value="{{old('fullname')}}">
                            @error('fullname')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-col fl-right">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="{{old('email')}}">
                            @error('email')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="address">Địa chỉ</label>
                            <input type="text" name="address" id="address" value="{{old('address')}}">
                            @error('address')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-col fl-right">
                            <label for="phone">Số điện thoại</label>
                            <input type="tel" name="phone" id="phone" value="{{old('phone')}}">
                            @error('phone')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="notes">Ghi chú</label>
                            <textarea name="note">{{old('note')}}</textarea>
                            @error('note')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
              
            </div>
        </div>
        <div class="section" id="order-review-wp">
            <div class="section-head">
                <h1 class="section-title">Thông tin đơn hàng</h1>
            </div>
            <div class="section-detail">
                <table class="shop-table">
                    <thead>
                        <tr>
                            <td></td>
                            <td>Sản phẩm</td>
                            <td>Tổng</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Cart::content() as $item)

                        <tr class="cart-item">
                            <td>
                                <a href="{{route('product.detail',['id'=>$item->id,'slug'=>Str::slug($item->name)])}}" title="" class="thumb">
                                    <img width="100px" src="{{asset($item->options->thumbnail)}}" alt="">
                                </a>
                            </td>
                            <td class="product-name">{{$item->name}}<strong class="product-quantity">({{number_format($item->price,0,'','.')}}₫ x {{$item->qty}})</strong></td>
                            <td class="product-total">{{number_format($item->subtotal,0,'','.')}}₫</td>
                        </tr>
                        @endforeach
                       
                      
                    </tbody>
                    <tfoot>
                        <tr class="order-total">
                            <td></td>
                            <td>Tổng đơn hàng:</td>
                           
                            <td><strong class="total-price">{{number_format(Cart::total(),0,'','.')}}₫</strong></td>
                        </tr>
                    </tfoot>
                </table>
                {{-- <div id="payment-checkout-wp">
                    <ul id="payment_methods">
                        <li>
                            <input type="radio" id="direct-payment" name="payment-method" value="direct-payment">
                            <label for="direct-payment">Thanh toán tại cửa hàng</label>
                        </li>
                        <li>
                            <input type="radio" id="payment-home" name="payment-method" value="payment-home">
                            <label for="payment-home">Thanh toán tại nhà</label>
                        </li>
                    </ul>
                </div> --}}
                <div class="place-order-wp clearfix">
                    <input type="submit" id="order-now" value="Đặt hàng">
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
@endsection