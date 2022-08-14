<div class="sidebar fl-left">
    <div class="section" id="category-product-wp">
        <div class="section-head">
            <h3 class="section-title">Danh mục sản phẩm</h3>
        </div>
        <div class="secion-detail">
            <ul class="list-item">
                @foreach ($product_cat_parents as $item)
                <li>
                    {{-- <a href="{{route('product.cat',$item->id)}}" title="">{{$item->name}}</a> --}}
                    <a href="{{route('product.cat',['cat_id'=>$item->id,'slug'=>$item->slug])}}" title="">{{$item->name}}</a>
                    <ul class="sub-menu">
                        @foreach ($item->productCatChild as $cat_child)
                        <li>
                            {{-- <a href="{{route('product.cat',$cat_child->id)}}" title="">{{$cat_child->name}}</a> --}}
                            <a href="{{route('product.cat',['cat_id'=>$cat_child->id,'slug'=>$cat_child->slug])}}" title="">{{$cat_child->name}}</a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="section" id="selling-wp">
        <div class="section-head">
            <h3 class="section-title">Sản phẩm bán chạy</h3>
        </div>
        <div class="section-detail">
            <ul class="list-item">
                @foreach ($product_sell as $item)
                <li class="clearfix">
                  
                        <a href="{{route('product.detail',['id'=>$item->id,'slug'=>$item->slug])}}" title="" class="thumb fl-left">
                            <img src="{{asset($item->thumbnail)}}" alt="">
                        </a>
                        <div class="info fl-right">
                            <a href="{{route('product.detail',['id'=>$item->id,'slug'=>$item->slug])}}" title="" class="product-name">{{$item->name}}</a>
                            <div class="price">
                                <span class="new">{{number_format($item->price,0,'','.')}}₫ </span>
                                {{-- <span class="old">7.190.000đ</span> --}}
                            </div>
                            
                            <button type="button" data-id="{{$item->id}}" class="btn btn-outline-secondary add_cart" style="font-size: 12px">Thêm giỏ hàng</button>
                        </div>
                  
                </li>

                @endforeach
               
            </ul>
        </div>
    </div>
    {{-- <div class="section" id="banner-wp">
        <div class="section-detail">
            <a href="" title="" class="thumb">
                <img src="{{asset('user/public/images/banner.png')}}" alt="">
            </a>
        </div>
    </div> --}}
</div>


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

