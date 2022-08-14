@extends('layouts.user')
@section('css')
    <style>
     .demo {
    width:500px;
    height: auto;
   
}
ul #lightSlider {
    list-style: none outside none;
    padding-left: 0;
    margin-bottom:0;
}
ul #lightSlider li {
    display: block;
    float: left;
    margin-right: 6px;
    cursor:pointer;
}
ul #lightSlider li img {
    display: block;
    height: auto;
    max-width: 100%;
    object-fit: contain;
}
.lSGallery li.active a img{
    border: 1px solid red;
    border-radius: 5px;
   
}
.img_product{
    width: 450px;
    height: auto;
    object-fit: cover;
    display: block;
     margin-left: auto; 
     margin-right: auto;
}


}
    </style>
@endsection
@section('content')
<div id="main-content-wp" class="clearfix detail-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Điện thoại</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="detail-product-wp">
                <div class="section-detail clearfix">
                    <div class="thumb-wp fl-left">
                        <div class="demo">
                            <ul id="lightSlider">
                                @foreach ($product->image_detail as $img)
                                <li data-thumb="{{asset($img->product_images)}}"  data-src="{{asset($img->product_images)}}">
                                    <img class="img_product  img_thumb" src="{{asset($img->product_images)}}" />
                                </li>
                                @endforeach
                                
                               
                            </ul>
                        </div>
                     
                    </div>
                    <div class="thumb-respon-wp fl-left">
                        <img src="public/images/img-pro-01.png" alt="">
                    </div>
                    <div class="info fl-right">
                        <h3 class="product-name">{{$product->name}}</h3>
                        {{-- <div class="desc">
                            <p>Bộ vi xử lý :Intel Core i505200U 2.2 GHz (3MB L3)</p>
                            <p>Cache upto 2.7 GHz</p>
                            <p>Bộ nhớ RAM :4 GB (DDR3 Bus 1600 MHz)</p>
                            <p>Đồ họa :Intel HD Graphics</p>
                            <p>Ổ đĩa cứng :500 GB (HDD)</p>
                        </div> --}}
                        <div class="num-product">
                            <span class="title">Sản phẩm: </span>
                            <span class="status">{{$warehouse[$product->warehouse]}}</span>
                        </div>
                        <p class="price">{{number_format($product->price,0,'','.')}}₫</p>
                        {{-- <form action="{{route('cart.add',$product->id)}}" method="POST">
                            @csrf --}}
                            {{-- <div id="num-order-wp">
                                <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                <input type="text" name="num-order" value="1" id="num-order">
                                <a title="" id="plus"><i class="fa fa-plus"></i></a>
                            </div> --}}
                            <button type="button" data-id="{{$product->id}}" class="btn btn-success add_cart_detail">Thêm giỏ hàng</button>
                        {{-- </form> --}}
                     
                        {{-- <a href="{{route('cart.add',$product->id)}}"  title="Thêm giỏ hàng" class="add-cart" >Thêm giỏ hàng</a> --}}
                        {{-- <a onclick="AddCart({{$product->id}})" href="javascript:"  title="Thêm giỏ hàng" class="add-cart" >Thêm giỏ hàng</a> --}}
                    </div>
                </div>
            </div>
            <div class="section" id="post-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Mô tả sản phẩm</h3>
                </div>
                <div class="section-detail read_all_content">
                   {!!$product->content!!}
                </div>
            </div>
            <div class="section" id="same-category-wp">
                <div class="section-head">
                    <h3 class="section-title">Cùng chuyên mục</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($same_category as $item)
                        <li>
                            <a href="{{route('product.detail',['id'=>$item->id,'slug'=>$item->slug])}}" title="" class="thumbnail">
                                <img src="{{asset($item->thumbnail)}}">
                            </a>
                            <a href="{{route('product.detail',['id'=>$item->id,'slug'=>$item->slug])}}" title="" class="product-name">{{Str::of($item->name)->limit(35)}}</a>
                            <div class="price">
                                <span class="new">{{number_format($item->price,0,'','.')}}₫</span>
                                {{-- <span class="old">20.900.000đ</span> --}}
                            </div>
                            <div class="action clearfix">
                                <a href="javascript:" title="" data-id="{{$item->id}}" class="add_cart_detail add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="{{route('cart.buy_now',['id'=>$item->id])}}" title="" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach                      
                    </ul>
                </div>
            </div>
        </div>
       
            @include('user.component.sidebar')
           
        
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#lightSlider').lightSlider({
        gallery: true,
        item: 1,
        loop:true,
        slideMargin: 0,
        thumbItem: 9
        });
  
        $('.read_all_content').readall({
        showheight: null,
        showrows: 15
        });
         
      
   
    });
  
   
</script>
<!-- JavaScript -->
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
        $('.add_cart_detail').click(function(){
            var id = $(this).attr('data-id');
            var data = {id:id};
            // alert(data);
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });
            $.ajax({
                type: "POST",
                url: "{{route('cart.add')}}",//this is only changes
                data: data,
                typeData:'json',
                success: function(data) {
                    $('.dropdown_cart').empty();
                    $('.dropdown_cart').html(data);
                    alertify.success('Thêm vào giỏ hàng thành công!');
                }
            });
        });
 
    })
</script>
@endsection