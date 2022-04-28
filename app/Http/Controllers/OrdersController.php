<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Rel_order_products;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function viewOrders(){
        $company = Customer::OrderBy('name')->get();
        // $orders= Orders::all();

        // foreach($orders as $order){
        //     $or_id = $order->id;
        //     $or_typ = $order->order_type;
        //     $or_dd = $order->dispatch;
        //     $or_dd = date('d-m-Y',strtotime($or_dd));
        //     $prs = Rel_order_products::where('order_id',$or_id)->with('products')->get();

        //     $or_pr[] = ['order_id'=>$or_id,'or_typ'=>$or_typ,'dispatch'=>$or_dd,$prs];
        // }

        return view('orders.orderView')->with(['company'=>$company]);
    }

    public function viewCompOrder(Request $request){
        $company = $request->comp_id;

        if($company != 0){
            $orders = Orders::where('customer_id',$company)->get();
        }else{
            $orders = Orders::all();
        }

        if($orders->isNotEmpty()){
            foreach($orders as $order){
                $or_id = $order->id;
                $or_typ = $order->order_type;
                $or_dd = $order->dispatch;
                $or_dd = date('d-m-Y',strtotime($or_dd));
                $prs = Rel_order_products::where('order_id',$or_id)->with('products')->get();

                $or_pr[] = ['order_id'=>$or_id,'or_typ'=>$or_typ,'dispatch'=>$or_dd,'products'=>$prs];
            }
            return response()->json(['status'=>'1','message'=>$or_pr]);
        }else{
            return response()->json(['status'=>'0','message'=>'no order to show']);
        }

    }

    public function getCustomer(){
        $company = Customer::OrderBy('name')->get();
        return view('orders.orderCreate')->with(['company'=>$company]);
    }

    public function productList(Request $request){
        $cm_id = $request->cm_id;

        if($cm_id != ""){
            $prods = Products::where("company_id",$cm_id)->get();

            return response()->json(["products"=>$prods,"status"=>"1"]);
        }else{
            return response()->json(["status"=>"0"]);
        }
    }

    public function getProduct(Request $request){
        $pr_id = $request->pr_id;

        if($pr_id != ""){
            $prod = Products::where("id",$pr_id)->get();
            return response()->json(["product"=>$prod,"status"=>"1"]);
        }else{
            return response()->json(["status"=>"0"]);
        }
    }

    public function addOrderIn(Request $request){
        $cm_id = $request->cm_id;
        $or_typ = $request->or_typ;
        $pr_data = $request->pr_data;

        if($or_typ != ""){
            $order = new Orders();
            $order->customer_id = $cm_id;
            $order->order_type = $or_typ;
            $order->dispatch = Carbon::now();
            $order->save();

            if(isset($order->id)){
                $order_id = $order->id;

                foreach($pr_data as $pr){
                    $prod = Products::where(['product_code'=>$pr['col1'],'company_id'=>$cm_id])->pluck('id');
                    $pr_qty = $pr['col3'];

                    $rel_op = new Rel_order_products();
                    $rel_op->order_id = $order_id;
                    $rel_op->product_id = $prod[0];
                    $rel_op->qty = $pr_qty;
                    $rel_op->save();
                }
                return response()->json(["status"=>'1',"message"=>"Orders added"]);
            }else{
                return response()->json(["status"=>'0',"message"=>"Orders Failed to save"]);
            }
        }else{
            return response()->json(["status"=>'0',"message"=>"Orders Failed to save"]);
        }
    }
}
