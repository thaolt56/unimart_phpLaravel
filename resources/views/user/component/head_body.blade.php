<style>
    .search_ajax{
        width: 400px;
        position: relative;
    }
    .search_result{
        background-color: antiquewhite;
        position: absolute;
        width: 400px;
        z-index: 1000;
       
    }
    .search_result .media{
        border-bottom: 1px solid rgb(105, 97, 97);
    }
    .search_result .media-body{
        padding: 0px 7px;
    }
    .search_result .media-left{
        padding: 5px;
    }
</style>
<div id="head-body" class="clearfix">
    <div class="wp-inner">
        <a href="{{route('home')}}" title="" id="logo" class="fl-left"><img src="{{asset('user/public/images/logo.png')}}"/></a>
        <div id="search-wp" class="fl-left">
           <div class="search_ajax">
            <form method="POST" action="">
                <input type="text" name="search_ajax" id="s" class="search_ajax" placeholder="Nhập từ khóa tìm kiếm tại đây!">
                {{-- <button type="submit" id="sm-s">Tìm kiếm</button> --}}
               
            </form>
           </div>
            <div class="search_result">
              
            </div>
        </div>
        <div id="action-wp" class="fl-right">
            <div id="advisory-wp" class="fl-left">
                <span class="title">Tư vấn</span>
                <span class="phone">0987.654.321</span>
            </div>
            <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
            {{-- <a href="?page=cart" title="giỏ hàng" id="cart-respon-wp" class="fl-right">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                <span id="num">2</span>
            </a> --}}
            <div id="cart-wp" class="fl-right dropdown_cart ">
                <a href="{{route('cart.show')}}">
                    <div id="btn-cart" style="color: #fff;">
                    
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        <span id="num" class="cart_count">@if (Cart::count()>0 )
                            {{Cart::count()}}
                         @else  
                         {{0}} 
                        @endif</span>
                    
                   
                </div>
                </a>

                @if (Cart::count()>0)
                <div id="dropdown">
                    <p class="desc">Có <span class="cart_count">{{Cart::count()}} </span>sản phẩm trong giỏ hàng</p>
                    <ul class="list-cart">
                        @foreach (Cart::content() as $item)
                        <li class="clearfix">
                            <a href="" title="" class="thumb fl-left">
                                <img src="{{asset($item->options->thumbnail)}}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="" title="" class="product-name">{{$item->name}}</a>
                                <p class="price">{{number_format($item->price,0,'','.')}}₫</p>
                                <p class="qty">Số lượng: <span>{{$item->qty}}</span></p>
                            </div>
                        </li>
                        @endforeach
                      
                     
                    </ul>
                    <div class="total-price clearfix">
                        <p class="title fl-left">Tổng:</p>
                        <p class="price fl-right">{{number_format(Cart::total(),0,'','.')}}₫</p>
                    </div>
                    <div class="action-cart clearfix">
                        <a href="{{route('cart.show')}}" title="Giỏ hàng" class="view-cart fl-left">Giỏ hàng</a>
                        <a href="{{route('cart.checkout')}}" title="Thanh toán" class="checkout fl-right">Thanh toán</a>
                    </div>
                </div>
                @endif
                
            </div>
        </div>
    </div>
</div>

<script>
   $(document).ready(function(){
       $('.search_ajax').keyup(function(){
           var key = $(this).val();
           if(key != ''){
            var data = {key:key};
           $.ajaxSetup({

            headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

             });
            $.ajax({
                type: "POST",
                url: "{{route('product.search')}}",//this is only changes
                data: data,
                typeData:'json',
                success: function(data) {
                $('.search_result').show(500);
                $('.search_result').html(data);
            
                // console.log(data);
           
                }
            });
           }else {
            $('.search_result').hide();
                $('.search_result').html('');
           }
         
       })
   })
</script>