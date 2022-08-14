<?php

namespace App\Http\Controllers\User;

use App\customer;
use App\Http\Controllers\Controller;
use App\Mail\orderMail;
use App\Product;
use App\order;
use App\order_detail;
use Illuminate\Support\Facades\DB;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserCartController extends Controller
{
    function show()
    {
        return view('user.product.cart');
    }

    function add(Request $request)
    {   
        if($request->ajax()){
            $id = $request->id;
            $product = Product::find($id);
             Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1, 
            'price' => $product->price,
            'options' => ['thumbnail' => $product->thumbnail],
            ]);

            return view('user.product.dropdown_cart');
           
        }
        
        
    }
    function buy_now(Request $request){
        $id = $request->id;
        $product = Product::find($id);
        Cart::add([
       'id' => $product->id,
       'name' => $product->name,
       'qty' => 1, 
       'price' => $product->price,
       'options' => ['thumbnail' => $product->thumbnail],
       ]);
       return redirect()->route('cart.show');
    }
    
    function remove($rowId)
    {

        Cart::remove($rowId);
        return redirect()->route('cart.show')->with('status', 'Bạn đã xóa 1 sản phẩm ra khỏi giỏ hàng!');
    }
    function destroy()
    {
        Cart::destroy();
        return redirect()->route('cart.show')->with('status', 'Bạn đã xóa toàn bộ giỏ hàng!');
    }
    //cart_ajax
    function update(Request $request)
    {
        if ($request->ajax()) {
            $num =  $request->get('num');
            $rowId = $request->get('rowId');
            Cart::update($rowId, $num);

            $subtotal = Cart::get($rowId)->subtotal;
            $total = Cart::total();
            $num = Cart::count();
            $data = array(
                'subtotal' => number_format($subtotal, 0, '', '.') . "₫",
                'total' => number_format($total, 0, '', '.') . "₫",
                'num' => $num,
            );
            return response()->json($data);
        }
    }

    //cart_checkout
    function checkout()
    {
        return view('user.product.cart_checkout');
    }

    function checkout_ok()
    {
        return view('user.product.checkout_ok');
    }


    function customer(Request $request)
    {   
        
        $request->validate(
            [
                'fullname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'phone' => 'required',
                'address' => 'required',
                'note' => 'required',

            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhât :min kí tự ',
                'max' => ':attribute có độ dài nhiều nhất :max kí tự',

            ],
            [
                'fullname' => 'Tên Khách hàng',
                'email' => 'Email',
                'phone' => 'Số điện thoại',
                'address' => 'Địa chỉ',
                'note' => 'Ghi chú'

            ]
        );
      
        //mail
        //sau khi gui mail cho khach hang thanh cong


        try {
            DB::beginTransaction();
            //insert vao customer
            $user =  customer::create([
                'name' => $request->input('fullname'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'content' => $request->input('note'),
            ]);
            $customer_id = $user->id;
           
            $random = Str::random(5);
            $code_order = 'UNI_' . $random;
            //insert vao order
            $order =  order::create([
                'code_order' => $code_order,
                'customer_id' => $customer_id,
                'number' => Cart::count(),
                'total' => Cart::total(),
                'status' => 'processing',

            ]);

            //insert vao order_detail
            $order_id = $order->id;
           
            foreach (Cart::content() as $item) {
                order_detail::create([
                    'order_id' => $order_id,
                    'product_id' => $item->id,
                    'qty' => $item->qty,


                ]);
            }
            $data = [
                'name' => $request->input('fullname'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'code_order' =>  $code_order,
            ];
    
            Mail::to($data['email'])->send(new orderMail($data));
            Cart::destroy();
          
    
            DB::commit();
            return redirect()->route('cart.checkout_ok');
        } catch (\Exception $exception) {
            Log::error("message" . $exception->getMessage() . "---line" . $exception->getLine());
            DB::rollBack();
        }
         //sendMail
      


      
    }
}
