@extends('layouts.user')
@section('css')
    <style>
        .tag {
    background-color: #28973a;
    margin-bottom: 2px;
    padding: 5px 10px 5px 10px; 
    display: inline;
}
    </style>
  
@endsection
@section('content')
<div id="main-content-wp" class="clearfix category-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    @if ($product_cat->parent_id == 0)
                    <li>
                        <a href="" title="">{{$product_cat->name}}</a>
                    </li>
                    @else
                    <li>
                        <a href="" title="">{{$product_cat->productCatParent->name}}</a>
                    </li>
                    <li>
                        <a href="" title="">{{$product_cat->name}}</a>
                    </li>
                    @endif
                 
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
           
            <div class="section" id="list-product-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title fl-left">{{$productCatParent->name}}</h3>
                    <div class="filter-wp fl-right">
                        <p class="desc">Danh mục {{ $product_cat->name}} có <strong>{{$list_product_by_cat->total()}}</strong> sản phẩm</p>
                        <div class="form-filter">
                            <form method="" action="">
                                <select name="sort">
                                    @foreach($select_sort as $k=>$v)
                                        <option 
                                        {{$k==$sort?"selected":""}}
                                         value="{{$k}}">{{$v}}</option>
                                    @endforeach
                                 
                                </select>
                                <button type="submit">Lọc</button>
                            </form>
                        </div>
                    </div>
                </div>
               
                <div class="section-detail">
                    @if ($list_product_by_cat->total()>0)
                    <ul class="list-item clearfix">
                        @foreach ($list_product_by_cat as $product)
                        <li>
                            <a href="{{route('product.detail',['id'=>$product->id,'slug'=>$product->slug])}}" title="" class="thumbnail">
                                <img src="{{asset($product->thumbnail)}}">
                            </a>
                            <a href="{{route('product.detail',['id'=>$product->id,'slug'=>$product->slug])}}" title="" class="product-name">{{Str::of($product->name)->limit(35)}}</a>
                            <div class="price">
                                <span class="new">{{number_format($product->price,0,'','.')}}₫</span>
                                {{-- <span class="old">20.900.000đ</span> --}}
                            </div>
                            <div class="action clearfix">
                                <a href="javascript:" data-id="{{$product->id}}" class="add-cart add_cart_cat fl-left">Thêm giỏ hàng</a>
                              
                                <a href="{{route('cart.buy_now',['id'=>$product->id])}}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>     
                        @endforeach
                                      
                       
                    </ul>
                    @else
                    {{-- <span class="tag">Danh mục không có sản phẩm</span> --}}
                    <img src="{{asset('user/public/images/sorry_shopping.png')}}" class="" alt="">
                    @endif
                   
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail">
                   {{$list_product_by_cat->links()}}
                </div>
            </div>
        </div>
        @include('user.component.sidebar_filter')
    </div>
</div>
@endsection

   
@section('js')
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
        $('.add_cart_cat').click(function(){
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
