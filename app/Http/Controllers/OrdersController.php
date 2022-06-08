<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\OrderLines;
use App\Models\Orders;
use App\Models\ProductHistory;
use App\Models\Products;
use App\Models\ScanProducts;
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
                $orwidlines[] = ['or_id'=>$order->id,'lines'=>$or_line,'dispatch'=>$disdate,'inv_id'=>$order->invoice_id,'status'=>$order->status];
            }
        }else{
            $orwidlines = [];
        }
        return view('orders.orderView')->with(['customers'=>$customers,'orders'=>$orwidlines]);
    }

    public function getOrderStock($order_id){

        $order = Orders::where('id',$order_id)->get();
        $customers = Customers::all();
        $or_lines= OrderLines::where('order_id',$order[0]->id)->get();

        $pr_lines = ProductHistory::where(['order_id'=>$order[0]->id,'actions'=>'Out'])->get();
        if($pr_lines->isNotEmpty()){
            foreach($pr_lines as $pr){
                $sp = ScanProducts::where('id',$pr->scanned_id)->get();
                if($sp[0]->gtin != "" || $sp[0]->gtin !=" "){
                    $pr = Products::where('gtin',$sp[0]->gtin)->get();
                    if($pr->isNotEmpty()){
                        $prods[] = ['label'=>$sp[0]->label,'plu'=>$pr[0]->product_code,'name'=>$pr[0]->product_name,
                        'weight'=>$pr[0]->size,'desc'=>$pr[0]->description];
                    }else{
                        $prods[] = ['label'=>$sp[0]->label,'gtin'=>'','plu'=>'','name'=>'','weight'=>'','desc'=>''];
                    }
                }else{
                    $prods[] = ['label'=>$sp[0]->label,'gtin'=>'','plu'=>'','name'=>'','weight'=>'','desc'=>''];
                }
            }
        }else{
            $prods[] = ['label'=>'No Product Available','gtin'=>'No Product Available','plu'=>'No Product Available','name'=>'No Product Available','weight'=>'No Product Available','desc'=>'No Product Available'];
        }

        return view('orders.orderStock')->with(['orders'=>$order,'customers'=>$customers,'or_lines'=>$or_lines,'products'=>$prods]);
    }

    public function viewCreate(){
        $customers = Customers::all();
        return view('orders.orderCreate')->with(['customers'=>$customers]);
    }

    public function getProduct($id){
        $prods = Products::where('company_id',$id)->get();

        return $prods;
    }

    public function addOrder(Request $request){
        $cx = $request->cx;
        $or_typ = $request->or_type;
        $products = $request->products;

        if($cx != "" || $or_typ != "" || $products != ""){
            $order = new Orders();
            $order->status = 'Incomplete';
            $order->save();

            if(isset($order->id)){
                $order_id = $order->id;

                foreach($products as $product){
                    $or_line = new OrderLines();
                    $or_line->order_id = $order_id;
                    $or_line->or_plu = $product['plu'];
                    $or_line->or_gtin =$product['gtin'];
                    $or_line->or_prod_name = $product['pname'];
                    $or_line->or_qty = $product['qty'];
                    $or_line->order_type = $or_typ;
                    $or_line->save();
                }
                $status = 1;
                $message = "Order Successfully Created - Order #".$order_id;
            }else{
                $status = 0;
                $message = "Failed To create Order";
            }
        }else{
            $status = 0;
            $message = "Something went wrong";
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }
}
