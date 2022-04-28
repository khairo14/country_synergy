<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Stocks;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Rel_order_products;
use App\Models\Rel_order_stocks;
use App\Models\Bins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                    $products[] = ['products'=>Products::where('id',$pr->product_id)->get(),"qty"=>$pr->qty];
                }
                return response()->json(['status'=>'1',"products"=>$products]);
            }else{
                return response()->json(['status'=>'0','message'=>'Order number not found',"products"=>""]);
            }
        }else{
            return response()->json(['status'=>'0','message'=>'Please Enter Order Number',"products"=>""]);
        }
    }

    public function checkStocks(Request $request){
        $stock = $request->pr_label;
        $or_id = $request->or_id;

        $cm_id = Orders::where('id',$or_id)->get();
        $cust = Customer::where('id',$cm_id[0]->customer_id)->get();

        if($cust->isNotEmpty()){
            $gtin = substr($stock,$cust[0]->gtin_start,$cust[0]->gtin_end);
        }

        if($cm_id[0]->order_type === 'In'){
            $check = Stocks::where(['product_label'=>$stock])->pluck('product_label');
            if($check->isEmpty()){
                $addStocks = new Stocks();
                $addStocks->product_label = $stock;
                $addStocks->save();

                if(isset($addStocks->id)){
                    $stock_id = $addStocks->id;
                    $products = Products::where('gtin',$gtin)->get();
                    if($products->isNotEmpty()){
                        $rel_os = new Rel_order_stocks();
                        $rel_os->order_id = $cm_id[0]->id;
                        $rel_os->stock_id = $stock_id;
                        $rel_os->product_id = $products[0]->id;
                        $rel_os->stock_type = $cm_id[0]->order_type;
                        $rel_os->save();
                    }else{
                        $rel_os = new Rel_order_stocks();
                        $rel_os->order_id = $cm_id[0]->id;
                        $rel_os->stock_id = $stock_id;
                        $rel_os->product_id = Null;
                        $rel_os->stock_type = $cm_id[0]->order_type;
                        $rel_os->save();
                    }

                    if(isset($rel_os->id)){
                        $scannedItems = $this->getStocks($or_id);
                    }

                    $status = 1;
                    $message = $scannedItems;
                }else{
                    $status = 0;
                    $message = ['message'=>"Error Please Scan Again"];
                }
            }else{
                $status = 0;
                $message = ['message'=>"Product Already Scanned"];
            }
        }else{
            $check = Stocks::where(['product_label'=>$stock])->get();
            if($check->isNotEmpty()){
                    $stck = Rel_order_stocks::where('stock_id',$check[0]->id)->get();
                    if($stck->isNotEmpty()){
                        Rel_order_stocks::where('stock_id',$stck[0]->id)->update(['stock_type'=>"Out"]);
                        $status = 1;
                        $scannedItems = $this->getStocks($or_id);
                        $message = $scannedItems;
                    }
            }else{
                $status = 0;
                $message = ['message'=>"Item doesn't exist in Stocks"];
            }
        }


        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function checkBins(Request $request){
        $loc = $request->bin_label;
        $or_id =$request->or_id;
        $bin = Bins::where('name',$loc)->get();
        $chkStock = Rel_order_stocks::where('order_id',$or_id)->whereNotNull('stock_id')->get();

        if($bin->isEmpty()){
            if($chkStock->isNotEmpty()){
                $addBin = new Bins();
                $addBin->name = $loc;
                $addBin->save();

                if(isset($addBin->id)){
                    $bin_id = $addBin->id;
                    Rel_order_stocks::where('order_id',$or_id)->update(['bin_location'=>$bin_id]);

                    $status = 1;
                    $bin_location = $this->getBin($or_id);
                }else{
                    $status = 0;
                    $bin_location = 'Error Adding Location';
                }
            }else{
                    $status = 0;
                    $bin_location = 'Add Products First';
            }
        }else{
            if($chkStock->isNotEmpty()){
                $bin_id = $bin[0]->id;
                Rel_order_stocks::where('order_id',$or_id)->update(['bin_location'=>$bin_id]);
                $status = 1;
                $bin_location = $this->getBin($or_id);
            }else{
                $status = 0;
                $bin_location = 'Add Products First';
            }

        }

        return response()->json(['status'=>$status,'message'=>$bin_location]);
    }

    public function getStocks($or_id){
        $orType = Orders::where('id',$or_id)->get();
        if($orType[0]->order_type === 'In'){
            $pr = Rel_order_stocks::where('order_id',$or_id)->groupBy('product_id')->pluck('product_id');
            if($pr->isNotEmpty()){
                foreach($pr as $id){
                    $product = Products::where('id',$id)->get();
                    $count = Rel_order_stocks::where(['order_id'=>$or_id,'stock_id'=>$id])->get()->count();
                    $orQty = Rel_order_products::where(['order_id'=>$or_id,'product_id'=>$id])->pluck('qty');
                    if($orQty->isNotEmpty()){
                        foreach($orQty as $orCount){
                            $orCount = $orCount;
                        }
                    }else{
                        $orCount = 0;
                    }

                    if($product->isEmpty()){
                        $scannedItems[] = ['plu'=>'0','PRname'=>'Product Not recognized','PKcount'=>$count,'OrCount'=>'0','remaining'=>'0'];
                    }else{
                        $remaining = (int)$orCount - $count;
                        $scannedItems[] = ['plu'=>$product[0]->product_code,'PRname'=>$product[0]->product_name,'PKcount'=>$count,'OrCount'=>$orCount,'remaining'=> $remaining];
                    }
                }
            }else{
                $scannedItems = [];
            }
        }else{
            $pr = Rel_order_stocks::where('stock_type',$orType[0]->order_type)->get();
            if($pr->isNotEmpty()){
                foreach($pr as $id){
                    $product = Products::where('id',$id->product_id)->get();
                    $count = Rel_order_stocks::where(['product_id'=>$id->product_id,'stock_type'=>$orType[0]->order_type])->get()->count();
                    $orQty = Rel_order_products::where(['order_id'=>$or_id,'product_id'=>$id->product_id])->pluck('qty');
                    if($orQty->isNotEmpty()){
                        foreach($orQty as $orCount){
                            $orCount = $orCount;
                        }
                    }else{
                        $orCount = 0;
                    }

                    if($product->isEmpty()){
                        $scannedItems[] = ['plu'=>'0','PRname'=>'Product Not recognized','PKcount'=>$count,'OrCount'=>'0','remaining'=>'0'];
                    }else{
                        $remaining = Rel_order_stocks::where(['product_id'=>$id,'stock_type'=>'In'])->get()->count();
                        // $remaining = (int)$orCount - $count;
                        $scannedItems[] = ['plu'=>$product[0]->product_code,'PRname'=>$product[0]->product_name,'PKcount'=>$count,'OrCount'=>$orCount,'remaining'=> $remaining];
                    }
                }
            }else{
                $scannedItems = [];
            }
        }



        return $scannedItems;
    }

    public function getBin($or_id){
        $bin = Rel_order_stocks::where(['order_id'=>$or_id])->groupBy('bin_location')->pluck('bin_location');

        if($bin->isEmpty()){
            $location = ['bin_id'=>0,'location'=>''];
        }else{
            $bin_loc = Bins::where('id',$bin)->get();
            if($bin_loc->isNotEmpty()){
                $location = ['bin_id'=>$bin_loc[0]->id,'location'=>$bin_loc[0]->name];
            }else{
                $location = ['bin_id'=>0,'location'=>''];
            }
        }

        return $location;
    }

    public function getOrderType($or_id){
        $or = Orders::where('id',$or_id)->get();
        if($or->isNotEmpty()){
            $type = $or[0]->order_type;
        }else{
            $type = "";
        }
        return $type;
    }
    // public function storeProducts(Request $request){
    //     $pr_data = $request->pr_data;
    //     $pl_data = $request->pl_data;
    //     $bin_data = $request->bin_data;


    //     if($pr_data != "" || $pl_data != "" || $bin_data != ""){
    //         foreach($pr_data as $pr){
    //           $store[] = ['product_label'=>$pr,'pallete_label'=>$pl_data[0],'bin_loc'=>$bin_data[0]];
    //         }
    //         Stocks::insert($store);
    //         $message = "Complete";
    //     }else{
    //         $message = "Error Storing";
    //     }

    //     // return response(['pr'=>$pr_data,'pl'=>$pl_data,'bin'=>$bin_data]);
    //     return response(['message'=>$message]);
    // }


}
