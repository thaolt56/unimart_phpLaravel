<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class paymentController extends Controller
{
    function payment(){
        return view('user.payment.pay');
    }
}
