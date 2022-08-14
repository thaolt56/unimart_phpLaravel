$(document).ready(function() {
    $('.add_cart').click(function() {
        var id = $(this).attr('data-id');
        var data = { id: id };

        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });
        $.ajax({
            type: "POST",
            url: "{{route('cart.add')}}", //this is only changes
            data: data,
            typeData: 'text',
            success: function(data) {
                $('.cart_count').html(data);
                // alertify.success('Thêm vào giỏ hàng thành công!');
            }
        });
    });

})