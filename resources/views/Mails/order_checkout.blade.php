<div style="padding:15px;max-width:600px;background-color:white;margin:0px auto"><div class="adM">
</div><h3 style="margin-top:0px">Cảm ơn quý khách đã đặt hàng tại UNIMART</h3>
<div id="m_5216270500100441317customer">
    <h3 style="color:1aaa3e;border-bottom:1px solid #2bbd43">Thông tin khách hàng</h3>
    <p>
        <strong>Tên khách hàng: </strong>
        {{$data['name']}}
    </p>
    <p>
        <strong>Email: </strong>
        <a href="mailto:{{$data['email']}}" target="_blank">{{$data['email']}}</a>
    </p>
    <p>
        <strong>Điện thoại: </strong>
       {{$data['phone']}}
    </p>
    <p>
        <strong>Địa chỉ: </strong>
       {{$data['address']}}
    </p>
</div>
<div id="m_5216270500100441317order-detail">
    <h3 style="color:1aaa3e;border-bottom:1px solid #2bbd43">Chi tiết đơn hàng {{$data['code_order']}}</h3>
    <table style="width:100%;background-color:#eeeeee" cellspacing="0">
        <thead style="background-color:1aaa3e;color:#1f191b">
            <tr>
                <td width="35%" style="padding:5px"><strong>Tên sản phẩm</strong></td>
                <td width="20%" style="text-align:center"><strong>Giá</strong></td>
                <td width="15%"><strong>Số lượng</strong></td>
                <td width="20%" style="padding:5px;text-align:right"><strong>Thành tiền</strong></td>
            </tr>
        </thead>
        <tbody>
            @foreach (Cart::content() as $item)
            <tr>
                <td style="padding:5px">{{$item->name}}</td>
                <td style="text-align:center">
                    {{number_format($item->price,0,'','.')}}₫
                </td>
              
                <td style="text-align:center">{{$item->qty}}</td>
                <td style="padding:5px;text-align:right">
                    {{number_format($item->subtotal,0,'','.')}}₫
                </td>
            </tr>
            @endforeach
              
               
                            </tbody>
        <tbody><tr>
            <td colspan="3" style="font-weight:bold;padding:5px">Tổng giá trị đơn hàng:</td>
            <td colspan="2" style="font-weight:bold;padding:5px;text-align:right">
                {{number_format(Cart::total(),0,'','.')}}₫
            </td>
        </tr>
    </tbody></table>
</div>
<div id="m_5216270500100441317info">
    <br>
    <p>
        <b style="color:1aaa3e">Quý khách đã đặt hàng thành công!</b><br>
       
        • Nhân viên giao hàng sẽ liên hệ với Quý khách qua Số Điện thoại trước khi giao hàng 24 tiếng.<br>
        <b><br>Cám ơn Quý khách đã sử dụng Sản phẩm của cửa hàng chúng tôi. Xin chân thành cảm ơn</b>
    </p><div class="yj6qo"></div><div class="adL">
</div></div><div class="adL">
</div></div>