@extends('layouts.user')
@section('css')
    
@endsection
@section('content')
    
<div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">
        <div class="main-content fl-right">
            {{-- slider --}}
           @include('user.component.slider')
            <div class="section" id="support-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <div class="thumb">
                                <img src="{{asset('user/public/images/icon-1.png')}}">
                            </div>
                            <h3 class="title">Miễn phí vận chuyển</h3>
                            <p class="desc">Tới tận tay khách hàng</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="{{asset('user/public/images/icon-2.png')}}">
                            </div>
                            <h3 class="title">Tư vấn 24/7</h3>
                            <p class="desc">1900.9999</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="{{asset('user/public/images/icon-3.png')}}">
                            </div>
                            <h3 class="title">Tiết kiệm hơn</h3>
                            <p class="desc">Với nhiều ưu đãi cực lớn</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="{{asset('user/public/images/icon-4.png')}}">
                            </div>
                            <h3 class="title">Thanh toán nhanh</h3>
                            <p class="desc">Hỗ trợ nhiều hình thức</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="{{asset('user/public/images/icon-5.png')}}">
                            </div>
                            <h3 class="title">Đặt hàng online</h3>
                            <p class="desc">Thao tác đơn giản</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="section" id="feature-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm nổi bật</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($product_latest as $product)
                        <li>
                            <a href="{{route('product.detail',['id'=>$product->id,'slug'=>$product->slug])}}" title="" class="thumbnail">
                                <img  src="{{asset($product->thumbnail)}}">
                            </a>
                            <a href="{{route('product.detail',['id'=>$product->id,'slug'=>$product->slug])}}" title="" class="product-name">{{Str::of($product->name)->limit(35)}}</a>
                            <div class="price">
                                <span class="new">{{number_format($product->price,0,'','.')}}₫</span>
                                {{-- <span class="old">6.190.000đ</span> --}}
                            </div>
                            <div class="action clearfix" >
                               
                                <a href="javascript:" title="" data-id="{{$product->id}}" class="add_cart add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="{{route('cart.buy_now',['id'=>$product->id])}}" title="" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                     
                    </ul>
                </div>
            </div>
            <div class="section" id="list-product-wp">
                <div class="section-head">
                    <h3 class="section-title">{{$smartphone_cat->name}}</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        @foreach ($list_smartphone as $smartphone)
                       
                        <li>
                           
                            <a href="{{route('product.detail',['id'=>$smartphone->id,'slug'=>$smartphone->slug])}}" title="" class="thumbnail">
                                <img src="{{asset($smartphone->thumbnail)}}">
                            </a>
                            <a href="{{route('product.detail',['id'=>$smartphone->id,'slug'=>$smartphone->slug])}}" title="" class="product-name">{{Str::of($smartphone->name)->limit(35)}}</a>
                            <div class="price">
                                <span class="new">{{number_format($smartphone->price,0,'','.')}}₫</span>
                                {{-- <span class="old">8.990.000đđ</span> --}}
                            </div>
                            <div class="action clearfix">
                               
                                <a href="javascript:" title="Thêm giỏ hàng" data-id="{{$smartphone->id}}"  class="add_cart add-cart fl-left add_cart">Thêm giỏ hàng</a>
                                <a href="{{route('cart.buy_now',['id'=>$smartphone->id])}}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                      
                        </li>
                        @endforeach
                        

                    </ul>
                </div>
            </div>
            <div class="section" id="list-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Laptop</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        @foreach ($list_laptop as $laptop)
                        <li>
                            <form action="{{route('cart.add',$laptop->id)}}" method="POST">
                                @csrf
                            <a href="{{route('product.detail',['id'=>$laptop->id,'slug'=>$laptop->slug])}}" title="" class="thumbnail">
                                <img src="{{asset($laptop->thumbnail)}}">
                            </a>
                            <a href="{{route('product.detail',['id'=>$laptop->id,'slug'=>$laptop->slug])}}" title="" class="product-name">{{Str::of($laptop->name)->limit(35)}}</a>
                            <div class="price">
                                <span class="new">{{number_format($laptop->price,0,'','.')}}₫</span>
                                {{-- <span class="old">8.690.000đ</span> --}}
                            </div>
                            <div class="action clearfix">
                                {{-- <button type="submit" class="btn btn-outline-secondary" style="font-size: 12px">Thêm giỏ hàng</button>
                                <button type="button" class="btn btn-outline-danger" style="font-size: 12px">Mua ngay</button> --}}
                                <a href="javascript:" title="Thêm giỏ hàng" data-id="{{$laptop->id}}" class="add_cart add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="{{route('cart.buy_now',['id'=>$laptop->id])}}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </form>
                        </li>
                        @endforeach
                       
                   
                      
                    </ul>
                </div>
            </div>
        </div>
        {{-- sidebar --}}
        @include('user.component.sidebar')
    </div>
</div>
@endsection

<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
<script>
    $(document).ready(function(){
        $('.add_cart').click(function(){
            var id = $(this).attr('data-id');
            var data = {id:id};

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });
            $.ajax({
                type: "POST",
                url: "{{route('cart.add')}}",//this is only changes
                data: data,
                typeData:'text',
                success: function(data) {
                    $('.dropdown_cart').empty();
                    $('.dropdown_cart').html(data);                    
                    alertify.success('Thêm vào giỏ hàng thành công!');
                }
            });
        });
 
    })
</script>