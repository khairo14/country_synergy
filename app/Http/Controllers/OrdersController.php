<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    //
    public function viewOrders(){
        return view('orders.orderView');
    }
}
