@extends('layouts.user')
@section('css')
    <style>
        .cart_ok{
            text-align: center
        }
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
            background-color: #f7f7f7!important;
        }
    </style>
@endsection
@section('content')
<div id="main-content-wp" class="cart-page">
 
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="?page=home" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Giỏ hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @if (Cart::count()>0)
    <div id="wrapper" class="wp-inner clearfix">
        @if (session('status'))
        <div class="alert alert-primary" role="alert">
            {{session('status')}}
        </div>
        @endif
        <div class="section" id="info-cart-wp">
            <div class="section-detail table-responsive">
              
                <table class="table">
                    <thead>
                        <tr>
                            <td>STT</td>
                            <td>Ảnh sản phẩm</td>
                            <td>Tên sản phẩm</td>
                            <td>Giá sản phẩm</td>
                            <td>Số lượng</td>
                           
                            <td>Thành tiền</td>
                            <td>Tác vụ</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $t = 0;
                        @endphp
                        @foreach (Cart::content() as $item)
                        @php
                            $t+=1;
                        @endphp
                        <tr>
                            <td>{{$t}}</td>
                            <td>
                                <a href="{{route('product.detail',['id'=>$item->id,'slug'=>Str::slug($item->name)])}}" title="" class="thumb">
                                    <img src="{{asset($item->options->thumbnail)}}" alt="">
                                </a>
                            </td>
                            <td>
                                <a href="{{route('product.detail',['id'=>$item->id,'slug'=>Str::slug($item->name)])}}" title="" class="name-product">{{$item->name}}</a>
                            </td>
                            <td>{{number_format($item->price,0,'','.')}}₫</td>
                            <td>
                                <input type="number" min="1" max="5" rowId="{{$item->rowId}}"  name="num-order" value="{{$item->qty}}" class="num-order">
                            </td>
                            <td class="rowId_{{$item->rowId}}">{{number_format($item->subtotal,0,'','.')}}₫</td>
                            <td>
                                {{-- <a href="" title="" class="del-product"><i class="fa fa-trash-o"></i></a> --}}
                                <a href="{{route('cart.remove',$item->rowId)}}" onclick="return confirm('Bạn có chắc xóa sản phẩm này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                            </td>
                           
                        </tr>
                        @endforeach
                       
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                    <p id="total-price" class="fl-right">Tổng giá: <span id="total_price">{{number_format(Cart::total(),0,'','.')}}₫</span></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                    <div class="fl-right">
                                        {{-- <a href="" title="" id="update-cart">Cập nhật giỏ hàng</a> --}}
                                        <a href="{{route('cart.checkout')}}" title="" id="checkout-cart">Thanh toán</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="section" id="action-cart-wp">
            <div class="section-detail">
                <p class="title">Click vào <span>“Cập nhật giỏ hàng”</span> để cập nhật số lượng. Nhập vào số lượng <span>0</span> để xóa sản phẩm khỏi giỏ hàng. Nhấn vào thanh toán để hoàn tất mua hàng.</p>
                <a href="{{route('home')}}" title="" id="buy-more">Mua tiếp</a><br/>
                <a href="{{route('cart.destroy')}}" onclick="return confirm('Bạn có chắc xóa tòan bộ giỏ hàng?')" title="" id="delete-cart">Xóa giỏ hàng</a>
            </div>
        </div>
    </div>          
    @else
    <div id="wrapper" class="wp-inner clearfix">
       
        <div class="cart_ok">
          <div class="icon_cart">
              <img class="" width="150px"  src="{{asset('user/public/images/empty-cart.png')}}" alt="">
          </div>
         
          <div class="card w-100">
              <div class="card-body">
                <h3 class="card-title">KHÔNG CÓ SẢN PHẨM TRONG GIỎ HÀNG</h3>
                <div class="card-text">
                  <a href="{{route('home')}}" class="btn btn-primary">Quay lại trang chủ</a>
                  
                </div>
                
              </div>
            </div>
        </div>
        
  </div>
    @endif
   
</div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $('.num-order').click(function(){
                var num = $(this).val();
               var rowId = $(this).attr('rowId');
              var data = {num:num, rowId:rowId};
              $.ajaxSetup({

                headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

                });

        $.ajax({
            url:"{{route('cart.update')}}", //file xu ly url
            type: 'POST', // day len url theo phuong thuc post
            data: data, //du lieu day len 
            dataType: 'json', // kieu du lieu tra ve
            success: function(data) {

              $(".rowId_"+rowId).html(data.subtotal);
              $("#total_price").html(data.total);
              $('.cart_count').html(data.num);
              

            },
            error: function(xhr, ajaxoptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }



        });
            })
        })
    </script>
@endsection