<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\OrderLines;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function viewOrders(){
        $customers = Customers::all();

        $orders = Orders::all();

        if($orders->isNotEmpty()){
            foreach($orders as $order){
                $or_line = OrderLines::where('order_id',$order->id)->get();
                $disdate = $order->created_at->format('Y/m/d');
                $orwidlines[] = ['or_id'=>$order->id,'lines'=>$or_line,'dispatch'=>$disdate,'or_qty'=>$order->order_qty,'inv_id'=>$order->invoice_id,'status'=>$order->status];
            }
        }else{
            $orwidlines = [];
        }
        return view('orders.orderView')->with(['customers'=>$customers,'orders'=>$orwidlines]);
    }
}
