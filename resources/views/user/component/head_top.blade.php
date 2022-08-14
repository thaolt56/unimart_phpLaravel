<div id="head-top" class="clearfix">
    <div class="wp-inner">
        <a href="{{route('payment')}}" title="" id="payment-link" class="fl-left">Hình thức thanh toán</a>
        <div id="main-menu-wp" class="fl-right">
            <ul style="margin-bottom: 0px!important" id="main-menu" class="clearfix">
                <li>
                    <a href="{{route('home')}}" title="">Trang chủ</a>
                </li>
                {{-- <li>
                    <a href="?page=category_product" title="">Sản phẩm</a>
                </li> --}}
                <li>
                    <a href="{{url('blog')}}" title="">Blog</a>
                </li>
                <li>
                    {{-- <a href="{{url('page/2')}}" title="">Giới thiệu</a> --}}
                    <a href="{{route('page',['slug'=>'gioi-thieu'])}}" title="">Giới thiệu</a>
                </li>
                <li>
                    <a href="{{route('page',['slug'=>'lien-he'])}}" title="">Liên hệ</a>
                </li>
            </ul>
        </div>
    </div>
</div>