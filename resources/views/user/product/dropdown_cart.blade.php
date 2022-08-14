

  <div id="btn-cart">
    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
    <span id="num" class="cart_count">@if (Cart::count()>0 )
        {{Cart::count()}}
     @else  
     {{0}} 
    @endif</span>
</div>

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