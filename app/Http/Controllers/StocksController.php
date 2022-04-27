<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Stocks;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Rel_order_products;
use App\Models\Rel_order_stocks;
use Illuminate\Http\Request;


class StocksController extends Controller
{
    public function checkOrders(Request $request){
        $or_id = $request->or_id;

        if($or_id != ""){
            $orders = Orders::where('id',$or_id)->get();

            if($orders->isNotEmpty()){
                $or_pr = Rel_order_products::where('order_id',$or_id)->get();
                $products = [];
                foreach($or_pr as $pr){
                    $products[] = ['products'=>Products::where('id',$pr->id)->get(),"qty"=>$pr->qty];
                }
                return response()->json(['status'=>'1',"products"=>$products]);
            }else{
                return response()->json(['status'=>'0','message'=>'Order number not found',"products"=>""]);
            }
        }else{
            return response()->json(['status'=>'0','message'=>'Please Enter Order Number',"products"=>""]);
        }


    }

    public function checkStocks(Request $request)
    {
        $stock = $request->pr_label;
        $or_id = $request->or_id;

        $cm_id = Orders::where('id',$or_id)->get();
        $cust = Customer::where('id',$cm_id[0]->customer_id)->get();

        if($cust->isNotEmpty()){
            $gtin = substr($stock,$cust[0]->gtin_start,$cust[0]->gtin_end);
        }

        $check = Stocks::where(['product_label'=>$stock,'stock_type'=>$cm_id[0]->order_type])->pluck('product_label');

        if($check->isEmpty()){
            // $status = 1;
            $products = Products::where('gtin',$gtin)->get();

            if($products->isNotEmpty()){
                $addStocks = new Stocks();
                $addStocks->product_label = $stock;
                $addStocks->product_id = $products[0]->id;
                $addStocks->stock_type = $cm_id[0]->order_type;
                $addStocks->save();

                if(isset($addStocks->id)){
                    $stock_id = $addStocks->id;

                    $rel_os = new Rel_order_stocks();
                    $rel_os->order_id = $cm_id[0]->id;
                    $rel_os->stock_id = $stock_id;
                    $rel_os->customer_id = $cust[0]->id;
                    $rel_os->save();
                }




                $message = ['products'=> $products];
            }else{
                $message = ['message'=>"Product Code not found"];
            }
        }else{
            $status = 0;
            $message = ['message'=>"Product Scanned for this order"];
        }

        // return response()->json(['status'=>$status,'message'=>$message]);
        return response()->json($message);
    }

    public function checkStocksPallete(Request $request){
        $pl_stock = $request->pl_label;

        $pl_check = Stocks::where('pallete_label',$pl_stock)->groupBy('pallete_label')->pluck('pallete_label');

        if($pl_check->isEmpty()){
            $pl_exist = 'true';
        }else{
            $pl_exist = 'false';
        }

        return response($pl_exist);
    }

    public function storeProducts(Request $request){
        $pr_data = $request->pr_data;
        $pl_data = $request->pl_data;
        $bin_data = $request->bin_data;


        if($pr_data != "" || $pl_data != "" || $bin_data != ""){
            foreach($pr_data as $pr){
              $store[] = ['product_label'=>$pr,'pallete_label'=>$pl_data[0],'bin_loc'=>$bin_data[0]];
            }
            Stocks::insert($store);
            $message = "Complete";
        }else{
            $message = "Error Storing";
        }

        // return response(['pr'=>$pr_data,'pl'=>$pl_data,'bin'=>$bin_data]);
        return response(['message'=>$message]);
    }


}
