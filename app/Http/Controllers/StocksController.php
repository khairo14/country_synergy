<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Locations;
use App\Models\OrderLines;
use App\Models\Orders;
use App\Models\Pallets;
use App\Models\ProductHistory;
use App\Models\Products;
use App\Models\ScanProducts;
use App\Models\Stocks;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class StocksController extends Controller
{
    // views
    public function scanProducts(){
        $customers = Customers::orderBy('name')->get();

        return view('scan.scanProduct')->with(['customers'=>$customers]);
    }

    public function scanPallets(){
        $customers = Customers::orderBy('name')->get();

        return view('scan.scanPallet')->with(['customers'=>$customers]);
    }

    public function viewPalletOut(){
        $customers = Customers::orderBy('name')->get();

        return view('scan.scanPalletOut')->with(['customers'=>$customers]);
    }

    public function viewProductOut(){
        return view('scan.scanProductOut');
    }

    public function viewOrderOut(){
        return view('scan.scanOrderOut');
    }

    public function viewAdd2pallet(){
        return view('scan.scanAddToPallet');
    }

    public function findProduct(){
        $customers = Customers::orderBy('name')->get();

        return view('scan.scanTransferProduct')->with(['customers'=>$customers]);
    }

    public function findPallet(){
        return view('scan.scanTransferPallet');
    }

    public function viewMerge(){
        return view('scan.scanMergePallet');
    }

    public function viewStockTake(){
        return view('scan.scanStockTake');
    }

    // functions
    public function productChecker(Request $request){
        $label = $request->label;
        $cust = $request->cust;

        $barcode = $this->barcodeChecker($cust,$label);
        $existInStock = ScanProducts::where('label',$label)->get();

        if($existInStock->isNotEmpty()){
            $status = 0;
            $message = ['message1'=>'Product Already Stored','message2'=>$existInStock];
        }else{
            $exist = Products::where('gtin',$barcode['gtin'])->get();
            if($exist->isNotEmpty()){
                $status = 1;
                $message = $exist;
            }else{
                $status = 2;
                $message = ['message1'=>'Product not registered - please add later','message2'=>$barcode];
            }
        }
        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function weightConvert($w){
        if(strlen($w)<=4){
            $weight = $w/100;
        }else if(strlen($w)==5){
            $weight = $w/1000;
        }else if(strlen($w)==6){
            $weight = $w/10000;
        }else{
            $weight = 0;
        }
        return round($weight,2);
    }

    public function dateConvert($d){
        if(strlen($d) == 6){
            $year = '20'.substr($d,0,2);
            $month = substr($d,2,2);
            $day = substr($d,4,2);
            $date = $year.'-'.$month.'-'.$day;
        }else{
            $date = "";
        }
        return $date;
    }

    public function barcodeChecker($cs,$str){
        $str = preg_replace('/\s/','',$str);
        $lngth = strlen($str);

        if($cs == 1){
            switch($lngth){
                case($lngth==48):
                    $gtin = substr($str,2,14);
                    $weight = $this->weightConvert((float)substr($str,28,6));
                    $date = $this->dateConvert(substr($str,18,6));
                break;
                default:
                    $gtin = "";
                    $weight = "";
                    $date = "";
            }
        }else if($cs == 2){
            switch($lngth){
                case($lngth>=54):
                    $gtin = substr($str,2,14);
                    $weight = $this->weightConvert((float)substr($str,20,6));
                    $date = $this->dateConvert(substr($str,28,6));
                break;
                case($lngth==44):
                    $gtin = substr($str,2,14);
                    $weight = $this->weightConvert((float)substr($str,20,6));
                    $date = $this->dateConvert(substr($str,28,6));
                break;
                case($lngth==42):
                    $gtin = substr($str,2,14);
                    $weight = $this->weightConvert((float)substr($str,20,6));
                    $date = $this->dateConvert(substr($str,28,6));
                break;
                case($lngth==48):
                    $gtin = substr($str,2,14);
                    $weight = $this->weightConvert((float)substr($str,20,6));
                    $date = $this->dateConvert(substr($str,28,6));
                break;
                case($lngth==20):
                    $gtin = substr($str,0,6);
                    $weight = $this->weightConvert((float)substr($str,6,4));
                    $date = "";
                break;
                case($lngth==22):
                    $gtin = substr($str,0,6);
                    $weight = $this->weightConvert((float)substr($str,6,4));
                    $date = "";
                break;
                case($lngth==30):
                    $gtin = substr($str,25,5);
                    $weight = $this->weightConvert((float)substr($str,8,4));
                    $date = "";
                break;
                case($lngth==34):
                    $gtin = substr($str,2,14);
                    $weight = "";
                    $date = $this->dateConvert(substr($str,18,6));
                break;
                default:$gtin = "";$weight = "";$date = "";
            }
        }else{
            switch($lngth){
                case(0):
                    $gtin = "";
                    $weight = "";
                    $date = "";
                break;
                default:
                    $gtin = "";
                    $weight = "";
                    $date = "";
            }
        }

        return ["weight"=>$weight,"gtin"=>$gtin,"date"=>$date,"length"=>$lngth];
    }

    public function palletChecker(Request $request){
        $label = $request->pallet;

        $pallet = Pallets::where('name',$label)->get();

        if($pallet->isNotEmpty()){
            $status = 1;
            $exist = $pallet;;
        }else{
            $status = 0;
            $exist = 'false';
        }

        return ['status'=>$status,'exist'=>$exist];
    }

    public function locationChecker(Request $request){
        $loc = $request->loc;

        $location = Locations::where('name',$loc)->get();

        if($location->isNotEmpty()){
            $status = 1;
            $exist = $location;
        }else{
            $status = 0;
            $exist = "Location not found - will be added if continue";
        }
        return ['status'=>$status,'exist'=>$exist];
    }

    public function addProducts(Request $request){
        $cx_id = $request->cx;
        $products = $request->products;
        $pallet = $request->pallet;
        $loc = $request->loc;
        $cust = Customers::where('id',$cx_id)->get();
        $count = count($request->products);

        if($cx_id != "" || $pallet != "" || $products !=""){
            $addPallet = new Pallets();
            $addPallet->name = $pallet;
            $addPallet->save();

            if(isset($addPallet->id)){
                $location = $this->locationChecker($request,$loc);
                if($location['status']==0){
                    $newLoc = new Locations();
                    $newLoc->name = $loc;
                    $newLoc->save();
                    if(isset($newLoc->id)){
                        $loc_id = $newLoc->id;
                        $loc_name = $loc;
                    }
                }else{
                    $loc_id = $location['exist'][0]['id'];
                    $loc_name = $location['exist'][0]['name'];
                }

                $addStock = new Stocks();
                $addStock->customer_id = $cx_id;
                $addStock->pallet_id = $addPallet->id;
                $addStock->location_id = $loc_id;
                $addStock->status = "In";
                $addStock->save();

                if($products != ""){
                    foreach($products as $product){
                        $plabel = $product['label'];
                        $scanProd = new ScanProducts();
                        $scanProd->label = $plabel;
                        $scanProd->save();

                        if(isset($scanProd->id)){
                            $prod_history = new ProductHistory();
                            $prod_history->scanned_id = $scanProd->id;
                            $prod_history->new_pallet_id = $addPallet->id;
                            $prod_history->actions = "In";
                            $prod_history->save();
                        }else{
                            Stocks::where('id',$addStock->id)->delete();
                            Pallets::where('id',$addPallet->id)->delete();
                        }
                    }
                }else{
                    Stocks::where('id',$addStock->id)->delete();
                    Pallets::where('id',$addPallet->id)->delete();
                }
            }

            if(isset($addStock->id)){
                $date = $addStock->created_at;
                $date = $date->format('d/m/Y');
            }

        }else{

        }
        return view('print.printLabel')->with(['cust'=>$cust,'label'=>$pallet,'storedate'=>$date,'location'=>$loc_name,'count'=>$count]);

    }

    public function saveProdToPallet(Request $request){
        $cx = $request->cx;
        $products = $request->products;
        $pallet= $request->pallet;

            if($products !=""){
                foreach($products as $product){
                    $scanProd = new ScanProducts();
                    $scanProd->label = $product['label'];
                    $scanProd->save();
                    if(isset($scanProd->id)){
                        $prod_history = new ProductHistory();
                        $prod_history->scanned_id = $scanProd->id;
                        $prod_history->new_pallet_id = $pallet;
                        $prod_history->actions = "In";
                        $prod_history->save();
                    }
                }
                $status = 1;
                $message = "Products Successfully Added To Stocks";
            }else{
                $status = 0;
                $message = "No Products Added - Please Refresh";
            }
        return response()->json(['status'=>$status,'message'=>$message]);
    }

    // Stock out - Pallet out
    public function palletOutCheck(Request $request){
        $p = $request->pallet;

        $pallet = Pallets::where('name',$p)->get();

        if($pallet->isNotEmpty()){
            $stock = Stocks::where('pallet_id',$pallet[0]->id)->where('status','In')->get();
            if($stock->isNotEmpty()){
                $location = Locations::where('id',$stock[0]->location_id)->get();
                if($location->isNotEmpty()){
                    $loc_name = $location[0]->name;
                }
                $ph_count = ProductHistory::where('new_pallet_id',$pallet[0]->id)->where('actions','In')->count();

                $status = 1;
                $message = ['pallet_id'=>$stock[0]->pallet_id,'pallet_name'=>$pallet[0]->name,'location'=>$loc_name,'qty'=>$ph_count];
            }else{
                $status = 0;
                $message = "Pallet already Out - Check Orders";
            }
        }else{
            $status = 0;
            $message = "Pallet Not found.";
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function palletOut(Request $request){
        $label = $request->label;
        $now = Carbon::now();

        if($label != ""){
            $order = new Orders();
            $order->customer_id = "";
            $order->status = "Incomplete";
            $order->save();
            if(isset($order->id)){
                $order_id = $order->id;
                foreach($label as $p_name){
                    $pallet = Pallets::where(['name'=>$p_name['label']])->get();
                    if($pallet->isNotEmpty()){
                        $pr_qty = collect([]);
                        $ph = ProductHistory::where(['new_pallet_id'=>$pallet[0]->id,'actions'=>'In'])->get();
                        if($ph->isNotEmpty()){
                            foreach($ph as $prod_hist){
                                $sp = ScanProducts::where('id',$prod_hist->scanned_id)->get();
                                if($sp->isNotEmpty()){
                                    $stks = Stocks::where(['pallet_id'=>$pallet[0]->id,'status'=>'In'])->get();
                                    if($stks->isNotEmpty()){
                                        $codes = $this->barcodeChecker($stks[0]->customer_id,$sp[0]->label);
                                        if($codes != ""){
                                            $prod_dtls = Products::where('gtin',$codes['gtin'])->get();
                                            if($prod_dtls->isNotEmpty()){
                                                $pr_qty->push(['plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name,'gtin'=>$prod_dtls[0]->gtin]);
                                            }else{
                                                $pr_qty->push(['plu'=>'0000','name'=>'','gtin'=>'']);
                                            }
                                        }else{
                                            $pr_qty->push(['plu'=>'0000','name'=>'','gtin'=>'']);
                                        }
                                    }
                                    $change_ph = ProductHistory::find($prod_hist->id);
                                    $change_ph->order_id = $order_id;
                                    $change_ph->order_out_date = $now;
                                    $change_ph->actions = 'Out';
                                    $change_ph->save();
                                }
                            }

                                $stks = Stocks::where(['pallet_id'=>$pallet[0]->id,'status'=>'In'])->get();
                                $new_stks = Stocks::find($stks[0]->id);
                                $new_stks->status = 'Out';
                                $new_stks->save();

                                $pr = $pr_qty->groupBy(['plu']);
                                $or_lines = $pr->map(function ($prs) {
                                    return ['plu'=>$prs[0]['plu'],'name'=>$prs[0]['name'],'count'=>$prs->count()];
                                });

                                foreach($or_lines as $or_line){
                                    $new_line = new OrderLines();
                                    $new_line->order_id = $order_id;
                                    $new_line->sc_plu = $or_line['plu'];
                                    $new_line->sc_prod_name = $or_line['name'];
                                    $new_line->sc_qty = $or_line['count'];
                                    $new_line->save();
                                }
                        }
                    }else{
                        $status = 0;
                        $message = "Pallet ".$p_name['label']."Not Found";
                    }
                }
                $addcx = Orders::find($order_id);
                $addcx->customer_id = $stks[0]->customer_id;
                $addcx->save();

                $status = 1;
                $message = "Order Created - Check Order Page - Order #".$order_id;
            }else{
                $status = 0;
                $message = "Unable to Create Order";
            }

        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    // Stock out - product out
    public function checkStockProduct(Request $request){
        $label = $request->label;

        $exist = ScanProducts::where('label',$label)->get();
        if($exist->isNotEmpty()){
            $ph = ProductHistory::where('scanned_id',$exist[0]->id)->where('actions','In')->get();
            if($ph->isNotEmpty()){
                $stock = Stocks::where('pallet_id',$ph[0]->new_pallet_id)->get();
                if($stock->isNotEmpty()){
                    $cx = $stock[0]->customer_id;
                    $codes = $this->barcodeChecker($cx,$exist[0]->label);
                    if($codes != ""){
                        $prod_dtls = Products::where('gtin',$codes['gtin'])->get();
                        if($prod_dtls->isNotEmpty()){
                            $status = 1;
                            $message = ['label'=>$label,'plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name];
                        }else{
                            $status = 2;
                            $message = ['label'=>$label];
                        }
                    }else{
                        $status = 2;
                        $message = ['label'=>$label];
                    }
                }else{
                    $status = 0;
                    $message = 'Product Not Stock';
                }
            }else{
                $status = 0;
                $message = 'Product is Already Delivered - Check Logs';
            }
        }else{
            $status = 0;
            $message = 'Product not found in Stocks';
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function orderProductOut(Request $request){
        $prods = $request->prods;
        $now = Carbon::now();

        if($prods != ""){
            $order = new Orders();
            $order->customer_id = "";
            $order->status = "Incomplete";
            $order->save();
            if(isset($order->id)){
                $order_id = $order->id;
            }

            $pr_qty = collect([]);
            foreach($prods as $prod){
                $sp = ScanProducts::where('label',$prod['label'])->get();
                if($sp->isNotEmpty()){
                    $ph = ProductHistory::where('scanned_id',$sp[0]->id)->get();
                    if($ph->isNotEmpty()){
                        $stock = Stocks::where('pallet_id',$ph[0]->new_pallet_id)->get();
                        $codes = $this->barcodeChecker($stock[0]->customer_id,$sp[0]->label);
                        if($codes != ""){
                            $prod_dtls = Products::where('gtin',$codes['gtin'])->get();
                            if($prod_dtls->isNotEmpty()){
                                $pr_qty->push(['plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name,'gtin'=>$prod_dtls[0]->gtin]);
                            }else{
                                $pr_qty->push(['plu'=>'0000','name'=>'','gtin'=>'']);
                            }
                        }else{
                            $pr_qty->push(['plu'=>'0000','name'=>'','gtin'=>'']);
                        }

                        $new_ph = ProductHistory::find($ph[0]->id);
                        $new_ph->order_id = $order_id;
                        $new_ph->order_out_date = $now;
                        $new_ph->actions = "Out";
                        $new_ph->save();
                    }
                }
            }
            $pr = $pr_qty->groupBy(['plu']);
            $or_lines = $pr->map(function ($prs) {
                return ['plu'=>$prs[0]['plu'],'name'=>$prs[0]['name'],'gtin'=>$prs[0]['gtin'],'count'=>$prs->count()];
            });

            foreach($or_lines as $or_line){
                $new_line = new OrderLines();
                $new_line->order_id = $order_id;
                $new_line->order_type = 'Out';
                $new_line->sc_plu = $or_line['plu'];
                $new_line->sc_gtin = $or_line['gtin'];
                $new_line->sc_prod_name = $or_line['name'];
                $new_line->sc_qty = $or_line['count'];
                $new_line->save();
            }
            $ph_count = ProductHistory::where('new_pallet_id',$ph[0]->new_pallet_id)->where('actions','In')->count();
            if($ph_count == 0){
                $update_stk = Stocks::find($stock[0]->id);
                $update_stk->status = 'Out';
                $update_stk->save();
            }

            $addcx = Orders::find($order->id);
            $addcx->customer_id = $stock[0]->customer_id;
            $addcx->save();

            $status = 1;
            $message = "Order Created - Check Order Page - Order #".$order_id;
        }else{
            $status = 0;
            $message = "Unable to Create Order";
        }
        return response()->json(['status'=>$status,'message'=>$message]);

    }

    // Stock out - orders
    public function getOrder($id){
        if($id != ""){
            $order = Orders::where('id',$id)->get();
            if($order->isNotEmpty()){
                $status = $order[0]->status;
                if($status == 'Incomplete'){
                    $or_line = OrderLines::where('order_id',$id)->get();
                    if($or_line->isNotEmpty()){
                        $status = 1;
                        $message = ['order'=>$order,'or_line'=>$or_line];
                    }
                }else{
                    $status = 0;
                    $message = 'Order Already Completed';
                }

            }else{
                $status = 0;
                $message ='Order Not Found';
            }
        }else{
            $status = 0;
            $message ='Invalid Order';
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function addProdToOrder(Request $request){
        $or_id = $request->order_id;
        $pr_lbl = $request->label;
        $now = Carbon::now();

        if($pr_lbl == "" || $pr_lbl == " "){
            $status = 0;
            $message = "Please Scan Again";
        }else{
            $scn_id = ScanProducts::where('label',$pr_lbl)->get();
            if($scn_id->isEmpty()){
                $status = 0;
                $message = "Product Not Found";
            }else{
                $chk_ph = ProductHistory::where(['scanned_id'=>$scn_id[0]->id,'actions'=>'In'])->get();
                if($chk_ph->isEmpty()){
                    $status = 0;
                    $message = "Product Already Added to Order / Delivered - see Product Tracking";
                }else{
                    $stock = Stocks::where(['pallet_id'=>$chk_ph[0]->new_pallet_id,'status'=>'In'])->get();
                    if($stock->isEmpty()){
                        $status = 0;
                        $message = "Unable to Find Product Location From Stocks";
                    }else{
                        $prod_dtls = Products::where('gtin',$scn_id[0]->gtin)->get();

                        $new_ph = ProductHistory::find($chk_ph[0]->id);
                        $new_ph->order_id = $or_id;
                        $new_ph->order_out_date = $now;
                        $new_ph->actions = "Out";
                        $new_ph->save();

                        $stk_qty = $stock[0]->qty - 1;
                        if($stk_qty <= 0){
                            $new_stk = Stocks::find($stock[0]->id);
                            $new_stk->qty = $stk_qty;
                            $new_stk->status = 'Out';
                            $new_stk->save();
                        }else{
                            $new_stk = Stocks::find($stock[0]->id);
                            $new_stk->qty = $stk_qty;
                            $new_stk->save();
                        }

                        $scan_gtin = $scn_id[0]->gtin;
                        if($scan_gtin != "" || $scan_gtin != null){
                            $or_line = OrderLines::where(['order_id'=>$or_id,'or_gtin'=>$scan_gtin])->get();
                            if($or_line->isNotEmpty()){
                                $sc_qty = $or_line[0]->sc_qty;
                                if($sc_qty != "" || $sc_qty != null){
                                    $new_sc_qty = $sc_qty + 1;
                                    $update_or_line = OrderLines::find($or_line[0]->id);
                                    $update_or_line->sc_qty = $new_sc_qty;
                                    $update_or_line->save();
                                }else{
                                    $update_or_line = OrderLines::find($or_line[0]->id);
                                    $update_or_line->sc_qty = 1;
                                    $update_or_line->sc_prod_name =  $or_line[0]->or_prod_name;
                                    $update_or_line->sc_gtin = $or_line[0]->or_gtin;
                                    $update_or_line->sc_plu =  $or_line[0]->or_plu;
                                    $update_or_line->save();
                                }
                            }else{
                                $sc_line = OrderLines::where(['order_id'=>$or_id,'sc_gtin'=>$scan_gtin])->get();
                                if($sc_line->isNotEmpty()){
                                        $new_sc_qty = $sc_line[0]->sc_qty + 1;
                                        $update_or_line = OrderLines::find($sc_line[0]->id);
                                        $update_or_line->sc_qty = $new_sc_qty;
                                        $update_or_line->save();
                                }else{
                                    $add_line = new OrderLines();
                                    $add_line->order_id = $or_id;
                                    $add_line->order_type = "Out";
                                    $add_line->sc_plu = $prod_dtls[0]->product_code;
                                    $add_line->sc_gtin = $scan_gtin;
                                    $add_line->sc_prod_name = $prod_dtls[0]->product_name;
                                    $add_line->sc_qty = 1;
                                    $add_line->save();
                                }
                            }
                            $new_or = OrderLines::where('order_id',$or_id)->get();
                            $status = 1;
                            $message = ['or_line'=>$new_or];
                        }else{
                            $status = 0;
                            $message = "Unable to Add Products to Order Lines";

                            $stk_qty = $stock[0]->qty + 1;
                            $revert_stock = Stocks::find($stock[0]->id);
                            $revert_stock->qty = $stk_qty;
                            $revert_stock->status = 'In';
                            $revert_stock->save();

                            $revert_ph = ProductHistory::find($chk_ph[0]->id);
                            $revert_ph->order_id = null;
                            $revert_ph->order_out_date = null;
                            $revert_ph->actions = "In";
                            $revert_ph->save();
                        }
                    }
                }
            }
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    // Transfer
    public function trnsfrProdNewPallet(Request $request){
        $loc_name = $request->loc;
        $loc_id = $request->loc_id;
        $p_name = $request->pallet;
        $products = $request->products;
        $cx = $request->cx;

        if($p_name != ""){
            $pallet = Pallets::where('name',$p_name)->get();
            if($pallet->isNotEmpty()){
                $status = 0;
                $message = "Pallet Name Already Exist Try Again";
            }else{
                $new_pallet = new Pallets();
                $new_pallet->name = $p_name;
                $new_pallet->save();
                if(isset($new_pallet->id)){
                    $location = Locations::where('name',$loc_name)->get();
                    if($location->isNotEmpty()){
                        $loc_id = $location[0]->id;
                    }else{
                        $newLoc = new Locations();
                        $newLoc->name = $loc_name;
                        $newLoc->save();
                        if(isset($newLoc->id)){
                            $loc_id = $newLoc->id;
                        }
                    }

                    foreach($products as $product){
                        $ph = ProductHistory::where('scanned_id',$product['p_id'])->get();
                        $new_ph = ProductHistory::find($ph[0]->id);
                        $new_ph->old_pallet_id = $ph[0]->new_pallet_id;
                        $new_ph->new_pallet_id = $new_pallet->id;
                        $new_ph->save();

                    }
                        $up_stk = new Stocks();
                        $up_stk->customer_id = $cx;
                        $up_stk->pallet_id = $new_pallet->id;
                        $up_stk->location_id = $loc_id;
                        $up_stk->status = "In";
                        $up_stk->save();

                    $status = 1;
                    $message = $p_name;
                }else{
                    $status = 0;
                    $message = "Unable to Create New Pallet";
                }
            }
        }else{
            $status = 0;
            $message = "Unable to Create New Pallet";
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function trsnfrProdExistPallet(Request $request){
        $prod = $request->prod;
        $p_name = $request->p_name;
        $p_id = $request->p_id;

        if($p_name != ""){
            foreach($prod as $pr){
                $old_pallet_id = ProductHistory::where('id',$pr['ph_id'])->pluck('new_pallet_id');
                $new_ph = ProductHistory::find($pr['ph_id']);
                $new_ph->old_pallet_id = $old_pallet_id[0];
                $new_ph->new_pallet_id = $p_id;
                $new_ph->save();
            }
            $status = 1;
            $message = "Transfer Succesfull";
        }else{
            $status = 0;
            $message = "Unable to locate Pallet";
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function trnsfrPalltChck(Request $request){
        $p_name = $request->pallet;

        $pallet = Pallets::where('name',$p_name)->get();
        if($pallet->isNotEmpty()){
            $stk_loc = Stocks::where('pallet_id',$pallet[0]->id)->pluck('location_id');
            if($stk_loc->isNotEmpty()){
                $loc_id = $stk_loc[0];
                $loc_name = Locations::where('id',$loc_id)->pluck('name');
            }else{
                $status = 0;
                $message = "Pallet Missing";
            }
            $status = 1;
            $message = ["name"=>$pallet[0]->name,'p_id'=>$pallet[0]->id,'loc_name'=>$loc_name[0],'loc_id'=>$loc_id];
        }else{
            $status = 0;
            $message = "Pallet Not found Please Scan Again";
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function trnsfrLocChck(Request $request){
        $loc_name = $request->loc_name;

        $loc = Locations::where('name',$loc_name)->get();

        if($loc->isNotEmpty()){
            $status = 1;
            $message = ['loc_id'=>$loc[0]->id,'loc_name'=>$loc[0]->name];
        }else{
            $status = 0;
            $message = "Location Not Found but will be added on the List";
        }

        return response()->json(['status'=>$status,'message'=>$message]);

    }

    public function trnsfrSave(Request $request){
        $p_id = $request->p_id;
        $new_loc_id = $request->new_loc_id;
        $new_loc_name = $request->new_loc_name;

        if($new_loc_id == 0){
            $add_loc = new Locations();
            $add_loc->name = $new_loc_name;
            $add_loc->save();

            if(isset($add_loc->id)){
                $stk_id = Stocks::where('pallet_id',$p_id)->pluck('id');
                if($stk_id->isNotEmpty()){
                    $update_stk = Stocks::find($stk_id[0]);
                    $update_stk->location_id = $add_loc->id;
                    $update_stk->save();
                }
                $status = 1;
                $message = "New Pallet Location Save";
            }else{
                $status = 0;
                $message = "Unable to Save a New location";
            }
        }else{
            $stk_id = Stocks::where('pallet_id',$p_id)->pluck('id');
            if($stk_id->isNotEmpty()){
                $update_stk = Stocks::find($stk_id[0]);
                $update_stk->location_id = $new_loc_id;
                $update_stk->save();

                $status = 1;
                $message = "New Pallet Location Save";
            }
        }

        return response()->json(['status'=>$status,'message'=>$message]);

    }

    public function PalletCheck(Request $request){
        $p_name = $request->p_name;

        $pallet = Pallets::where('name',$p_name)->get();
        if($pallet->isNotEmpty()){
            $stock = Stocks::where('pallet_id',$pallet[0]->id)->get();

            $ph = ProductHistory::where('new_pallet_id',$pallet[0]->id)->where('actions','In')->get();
            $pr_qty = collect([]);
            if($ph->isNotEmpty()){
                foreach($ph as $p){
                    $sp = ScanProducts::where('id',$p->scanned_id)->get();
                    if($sp->isNotEmpty()){
                        $codes = $this->barcodeChecker($stock[0]->customer_id,$sp[0]->label);
                        if($codes != ""){
                            $prod_dtls = Products::where('gtin',$codes['gtin'])->get();
                            if($prod_dtls->isNotEmpty()){
                                $pr_qty->push(['plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name,'gtin'=>$prod_dtls[0]->gtin]);
                            }else{
                                $pr_qty->push(['plu'=>'0000','name'=>'','gtin'=>'']);
                            }
                        }else{
                            $pr_qty->push(['plu'=>'0000','name'=>'','gtin'=>'']);
                        }
                    }
                }
                $pr = $pr_qty->groupBy(['plu']);
                $lines = $pr->map(function ($prs) {
                    return ['plu'=>$prs[0]['plu'],'name'=>$prs[0]['name'],'gtin'=>$prs[0]['gtin'],'count'=>$prs->count()];
                });

                $status = 1;
                $message = ['lines'=>$lines,'pallet_id'=>$pallet[0]->id,'pallet_name'=>$pallet[0]->name];
            }else{
                $status = 0;
                $message = "No Products Found.";
            }
        }else{
            $status = 0;
            $message = "Pallet Not Found";
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function saveMerge(Request $request){
        $p1 = $request->p1;
        $p2 = $request->p2;

        if($p1 != "" || $p2 != ""){
            $c1 = Stocks::where('pallet_id',$p1)->get();
            $c2 = Stocks::where('pallet_id',$p2)->get();

            if($c1[0]->customer_id != $c2[0]->customer_id){
                $status = 0;
                $message = "Cannot Merge Pallet from different Customer";
            }elseif($c1[0]->status == "Out" || $c2[0]->status == "Out"){
                $status = 0;
                $message = "Cannot Merge Pallet That's already Out";
            }elseif($c1[0]->status == "Dump" || $c2[0]->status == "Dump"){
                $status = 0;
                $message = "Cannot Merge Pallet To Dump Pallet";
            }else{
                $ph1 = ProductHistory::where('new_pallet_id',$p1)->where('actions','In')->get();
                foreach($ph1 as $ph){
                    $update_ph = ProductHistory::find($ph->id);
                    $update_ph->old_pallet_id = $p1;
                    $update_ph->new_pallet_id = $p2;
                    $update_ph->save();
                }

                $update_stk2 = Stocks::find($c1[0]->id);
                $update_stk2->status = "MergeToPallet-".$c2[0]->pallet_id;
                $update_stk2->save();

                $status = 1;
                $message = "Merging Succesfull";
            }

        }else{
            $status = 0;
            $message = "unable to merge - Missing pallet";
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    // Stock Take
    public function stkPalletCheck(Request $request){
        $pname = $request->pname;

        if($pname != ""){
            $pallets = Pallets::where('name',$pname)->get();

            if($pallets->isNotEmpty()){
                $p_id = $pallets[0]->id;
                $stock = Stocks::where('pallet_id',$p_id)->get();
                if($stock->isNotEmpty()){
                    $stk_status = $stock[0]->status;
                    if($stk_status == "In"){
                        $ph = ProductHistory::where('new_pallet_id',$p_id)->where('actions','In')->get();
                        $pr_qty = collect([]);
                        if($ph->isNotEmpty()){
                            foreach($ph as $p){
                                $sp = ScanProducts::where('id',$p->scanned_id)->get();
                                if($sp->isNotEmpty()){
                                    $codes = $this->barcodeChecker($stock[0]->customer_id,$sp[0]->label);
                                    if($codes != ""){
                                        $prod_dtls = Products::where('gtin',$codes['gtin'])->get();
                                        if($prod_dtls->isNotEmpty()){
                                            $pr_qty->push(['plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name]);
                                        }else{
                                            $pr_qty->push(['plu'=>'0000','name'=>'','gtin'=>'']);
                                        }
                                    }else{
                                        $pr_qty->push(['plu'=>'0000','name'=>'','gtin'=>'']);
                                    }
                                }
                            }
                        }
                        $pr = $pr_qty->groupBy(['plu']);
                        $stk_lines = $pr->map(function ($prs) {
                            return ['plu'=>$prs[0]['plu'],'name'=>$prs[0]['name'],'count'=>$prs->count()];
                        });

                        $l_id = $stock[0]->location_id;
                        $l_name = Locations::where('id',$l_id)->pluck('name');

                        $status = 1;
                        $message = ['stk_line'=>$stk_lines,'location'=>$l_name,'pallet'=>$pname];
                    }else{
                        $status = 2;
                        $message = "Pallet Is Out and No Product Stock";
                    }
                }else{
                    $status = 0;
                    $message = "Pallet No Longer In Stock";
                }

            }else{
                $status = 0;
                $message = "Pallet Not Found";
            }
        }else{
            $status = 0;
            $message = "Pallet Name Cannot Be Empty";
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function stkProductCheck(Request $request){
        $lbl = $request->lbl;
        $p_name = $request->pallet;

        if($lbl != ""){
            $sc_id = ScanProducts::where('label',$lbl)->get();
            if($sc_id->isNotEmpty()){
                $pallet = Pallets::where('name',$p_name)->get();
                if($pallet->isNotEmpty()){
                    $ph = ProductHistory::where('scanned_id',$sc_id[0]->id)->get();
                    $cur_pallet = $ph[0]->new_pallet_id;
                    $sc_pallet = $pallet[0]->id;

                    $stks = Stocks::where(['pallet_id'=>$pallet[0]->id,'status'=>'In'])->get();
                    if($stks->isNotEmpty()){
                        $codes = $this->barcodeChecker($stks[0]->customer_id,$lbl);
                        if($codes != ""){
                            $prod_dtls = Products::where('gtin',$codes['gtin'])->get();
                            if($prod_dtls->isNotEmpty()){
                                $prod_details = ['plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name,'gtin'=>$prod_dtls[0]->gtin];
                            }else{
                                $prod_details = ['plu'=>'0000','name'=>'','gtin'=>''];
                            }
                        }else{
                            $prod_details = ['plu'=>'0000','name'=>'','gtin'=>''];
                        }
                    }

                    if($sc_pallet == $cur_pallet){
                        $status = 1;
                        $message = "Ok";
                        $message2 = $prod_details;
                    }else{
                        $status = 1;
                        $message = "Product Located From Pallet-".$pallet[0]->name." Will transfer to this Pallet";
                        $message2 = $prod_details;

                    }
                }
            }else{
                $status = 1;
                $message = "Product Not In Stock But will be added once completed";
                $prod_details = ['plu'=>'0000','name'=>''];
                $message2 = $prod_details;

            }
        }else{
            $status = 0;
            $message = "Invalid Product";
            $message2 = "";

        }
        return response()->json(['status'=>$status,'message'=>$message,'message2'=>$message2]);
    }

    public function stkUpdatePallet(Request $request){
        $products = $request->products;
        $pallet = $request->pallet;
        $loc = $request->loc;

        if($pallet != "" || $products != ""){
            $p_id = Pallets::where('name',$pallet)->get();
            $cur_qty = count($products);

            $ph = ProductHistory::where('new_pallet_id',$p_id[0]->id)->get();
            if($ph->isNotEmpty()){
                $p = Pallets::where('name','Dump')->get();
                if($p->isNotEmpty()){
                    $trash_pallet = $p[0]->id;
                }else{
                    $new_p = new Pallets();
                    $new_p->name = "Dump";
                    $new_p->save();

                    if(isset($new_p->id)){
                        $trash_pallet = $new_p->id;
                    }else{
                        $trash_pallet = $p[0]->id;
                    }
                }

                foreach($ph as $scph){
                    $upPH = ProductHistory::find($scph['id']);
                    $upPH->new_pallet_id = $trash_pallet;
                    $upPH->actions = "Dump";
                    $upPH->save();
                }

                $location = Locations::where('name','Dump')->get();
                if($location->isNotEmpty()){
                    $new_loc = $location[0]->id;
                }else{
                    $loc_create = new Locations();
                    $loc_create->name = "Dump";
                    $loc_create->save();

                    if(isset($loc_create->id)){
                        $new_loc = $loc_create->id;
                    }
                }

                $stk = Stocks::where('pallet_id',$trash_pallet)->get();
                if($stk->isEmpty()){
                    $cs_id = Stocks::where('pallet_id',$p_id[0]->id)->pluck('customer_id');

                    $new_stk = new Stocks();
                    $new_stk->customer_id = $cs_id[0];
                    $new_stk->pallet_id = $trash_pallet;
                    $new_stk->location_id = $new_loc;
                    $new_stk->status = "Dump";
                    $new_stk->save();
                }
            }

            foreach($products as $product){
                $sc = ScanProducts::where('label',$product['label'])->get();
                $stks = Stocks::where('pallet_id',$p_id[0]->id)->get();

                if($stks->isNotEmpty()){
                    $cs = Customers::where('id',$stks[0]->customer_id)->get();
                }

                if($sc->isNotEmpty()){
                    $ph_id = ProductHistory::where('scanned_id',$sc[0]->id)->pluck('id');
                    if($ph_id->isNotEmpty()){
                        $new_ph = ProductHistory::find($ph_id[0]);
                        $new_ph->new_pallet_id = $p_id[0]->id;
                        $new_ph->actions = "In";
                        $new_ph->save();
                    }
                }else{
                    $new_sc = new ScanProducts();
                    $new_sc->label = $product['label'];
                    $new_sc->save();
                    if(isset($new_sc->id)){
                        $new_ph = new ProductHistory();
                        $new_ph->scanned_id = $new_sc->id;
                        $new_ph->new_pallet_id = $p_id[0]->id;
                        $new_ph->actions = "In";
                        $new_ph->save();
                    }
                }


            }
            $status = 1;
            $message = "Stock Updated";
        }else{
            $status = 0;
            $message = "Unable to Save Products - Try Again";
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    // stocks
    public function viewStocks(){
        $customers = Customers::orderBy('name')->get();
        $now = Carbon::now()->format('Y-m-d');

        $stocks = Stocks::where('status','In')->where('customer_id',2)->where('created_at','LIKE',"%{$now}%")->get();
        if($stocks->isNotEmpty()){
            foreach($stocks as $stock){
                $pr_qty = collect([]);
                $pallet = Pallets::where('id',$stock->pallet_id)->get();
                $location = Locations::where('id',$stock->location_id)->get();
                $stored = $stock->created_at;
                $stored = $stored->format('d-m-Y');

                $ph = ProductHistory::where('new_pallet_id',$stock->pallet_id)->where('actions','In')->get();
                if($ph->isNotEmpty()){
                    foreach($ph as $p){
                        $sp = ScanProducts::where('id',$p->scanned_id)->get();
                        if($sp->isNotEmpty()){
                            $codes = $this->barcodeChecker(2,$sp[0]->label);
                            if($codes != ""){
                                $prod_dtls = Products::where('gtin',$codes['gtin'])->get();
                                if($prod_dtls->isNotEmpty()){
                                    $pr_qty->push(['plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name,'gtin'=>$prod_dtls[0]->gtin]);
                                }else{
                                    $pr_qty->push(['plu'=>'0000','name'=>'','gtin'=>'']);
                                }
                            }else{
                                $pr_qty->push(['plu'=>'0000','name'=>'','gtin'=>'']);
                            }
                        }
                    }
                    $pr = $pr_qty->groupBy(['plu']);
                    $or_lines = $pr->map(function ($prs) {
                        return ['plu'=>$prs[0]['plu'],'name'=>$prs[0]['name'],'gtin'=>$prs[0]['gtin'],'count'=>$prs->count()];
                    });

                    $items[] = ['pallet'=>$pallet[0]['name'],'location'=>$location[0]->name,'stored'=>$stored,'stockid'=>$stock->id,'palletid'=>$stock->pallet_id,'sc_line'=>$or_lines];
                }
            }
        }else{
            $items = [];
        }
        return view('stocks.stocksView')->with(['customers'=>$customers,'stocks'=>$items]);
    }

    public function getPlu(Request $request){
        $cx = $request->cx;
        $prod = Products::where('company_id',$cx)->get();

        if($prod->isNotEmpty()){
            $plu_collection = collect([]);
            foreach($prod as $p){
                $plu_collection->push(['plu'=>$p->product_code]);
            }
            $status = 1;
            $plu = $plu_collection->groupBy(['plu']);
        }else{
            $status = 0;
            $plu = "No Product Code";
        }
        return response()->json(['status'=>$status,'plu'=>$plu]);
    }

    public function searchStocks(Request $request){
        $cx = $request->cx;
        $date1 = $request->date1;
        $date2 = $request->date2;

        if($date1 != ""){
            $date1 = Carbon::createFromFormat('d/m/Y', $date1)->format('Y-m-d');
        }else{
            $date1 = "";
        }
        if($date2 != ""){
            $date2 = Carbon::createFromFormat('d/m/Y', $date2);
            $date2 = $date2->addDay()->format('Y-m-d');
        }else{
            $date1 = "";
        }

        $plu = $request->plu;

        if($date1 != "" && $date2 !="" && $plu == ""){
            if($date1 == $date2){
                $stocks = Stocks::where('customer_id',$cx)->where('created_at','LIKE',"%{$date1}%")->get();
            }else{
                // $stocks = Stocks::where('customer_id',$cx)->wherebetween('created_at',[$date1,$date2])->get();
                $stocks = Stocks::where('customer_id',$cx)->where('created_at','>=',$date1)->where('created_at','<=',$date2)->get();
            }

            if($stocks->isNotEmpty()){
                foreach($stocks as $stock){
                    $pr_qty = collect([]);
                    $pallet = Pallets::where('id',$stock->pallet_id)->get();
                    $location = Locations::where('id',$stock->location_id)->get();
                    $stored = $stock->created_at;
                    $stored = $stored->format('d-m-Y');

                    $ph = ProductHistory::where('new_pallet_id',$stock->pallet_id)->where('actions','In')->get();
                    if($ph->isNotEmpty()){
                        foreach($ph as $p){
                            $sp = ScanProducts::where('id',$p->scanned_id)->get();
                            if($sp->isNotEmpty()){
                                $codes = $this->barcodeChecker($cx,$sp[0]->label);
                                if($codes != ""){
                                    $prod_dtls = Products::where('gtin',$codes['gtin'])->get();
                                    if($prod_dtls->isNotEmpty()){
                                        $pr_qty->push(['plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name,'gtin'=>$prod_dtls[0]->gtin]);
                                    }else{
                                        $pr_qty->push(['plu'=>'0000','name'=>'','gtin'=>'']);
                                    }
                                }else{
                                    $pr_qty->push(['plu'=>'0000','name'=>'','gtin'=>'']);
                                }
                            }
                        }
                        $pr = $pr_qty->groupBy(['plu']);
                        $or_lines = $pr->map(function ($prs) {
                            return ['plu'=>$prs[0]['plu'],'name'=>$prs[0]['name'],'gtin'=>$prs[0]['gtin'],'count'=>$prs->count()];
                        });

                        $stk_lines[] = ['pallet'=>$pallet[0]['name'],'location'=>$location[0]->name,'stored'=>$stored,'stockid'=>$stock->id,'palletid'=>$stock->pallet_id,'sc_line'=>$or_lines];
                    }
                }
                $status = 1;
            }else{
                $status = 0;
                $stk_lines = "No Stocks Found";
            }
        }elseif($plu != "" && $date1 == "" && $date2 ==""){
            $stocks = Stocks::where('customer_id',$cx)->where('status','In')->get();
            if($stocks->isNotEmpty()){
                foreach($stocks as $stock){
                    $gtin_collection = collect([]);
                    $ph = ProductHistory::where('new_pallet_id',$stock->pallet_id)->where('actions','In')->get();
                    if($ph->isNotEmpty()){
                        foreach($ph as $p){
                            $sc = ScanProducts::where('id',$p->scanned_id)->get();
                            if($sc->isNotEmpty()){
                                $codes = $this->barcodeChecker($cx,$sc[0]->label);
                                if($codes != ""){
                                    $gtin_collection->push(['gtin'=>$codes['gtin']]);
                                }else{
                                    $gtin_collection->push(['gtin'=>'0']);
                                }
                            }else{
                                $status = 0;
                                $stk_lines = "Missing Product";
                            }
                        }
                    }else{
                        $status = 0;
                        $stk_lines = "No Products Found";
                    }
                }
                $gtin = $gtin_collection->groupBy(['gtin']);
            }else{
                $status = 0;
                $stk_lines = "No Stocks Found";
            }
            // $prods = Products::where('product_code',$plu)->get();
            // if($prods->isNotEmpty()){
            //     $ph = ProductHistory::where()
            //     $scn_id = ScanProducts::where('gtin',$prods[0]->gtin)->get();
            // }
        }
        // return $gtin;

        //
        // }elseif($plu != "" && $date == ""){
        //     $prods = Products::where('product_code',$plu)->get();
        //     $sc_collect = collect([]);
        //     if($prods->isNotEmpty()){
        //         $scn_id = ScanProducts::where('gtin',$prods[0]->gtin)->get();
        //         foreach($scn_id as $scn){
        //             $ph = ProductHistory::where('scanned_id',$scn['id'])->where('actions','In')->get();
        //             if($ph->isNotEmpty()){
        //                 $pallet = Pallets::where('id',$ph[0]->new_pallet_id)->get();
        //                 $l_id = Stocks::where('pallet_id',$pallet[0]->id)->get();
        //                 $loc = Locations::where('id',$l_id[0]->location_id)->get();
        //                 $bb = Carbon::createFromFormat('Y-m-d', $l_id[0]->best_before)->format('d-m-Y');
        //                 $rb = $l_id[0]->created_at->format('d-m-Y');
        //                 $sc_collect->push(['best_before'=>$bb,'pallet'=>$pallet[0]->name,'palletid'=>$pallet[0]->id,'rcvd'=>$rb,'location'=>$loc[0]->name,'plu'=>$plu,'p_name'=>$prods[0]->product_name]);
        //             }
        //         }
        //     }else{

        //     }

        //     $gp = $sc_collect->groupBy('pallet');
        //     $stk_lines[] = $gp->map(function ($prs) {
        //         return ['pallet'=>$prs[0]['pallet'],'palletid'=>$prs[0]['palletid'],'plu'=>$prs[0]['plu'],'name'=>$prs[0]['p_name'],'best_before'=>$prs[0]['best_before'],'received_date'=>$prs[0]['rcvd'],'location'=>$prs[0]['location'],'count'=>$prs->count()];
        //     });
        //     $status = 2;
        // }elseif($plu == "" && $date != ""){
        //     $date = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        //     $stocks = Stocks::where('customer_id',$cx)->where('created_at','LIKE',"%{$date}%")->where('status','In')->get();
        //     if($stocks->isNotEmpty()){

        //         foreach($stocks as $stock){
        //             $pr_qty = collect([]);
        //             $pallet = Pallets::where('id',$stock->pallet_id)->get();
        //             $location = Locations::where('id',$stock->location_id)->get();
        //             $ph = ProductHistory::where('new_pallet_id',$stock->pallet_id)->where('actions','!=','Out')->get();
        //             if($ph->isNotEmpty()){
        //                 foreach($ph as $p){
        //                     $sp = ScanProducts::where('id',$p->scanned_id)->get();
        //                     if($sp->isNotEmpty()){
        //                         $prod_dtls = Products::where('gtin',$sp[0]->gtin)->get();
        //                         if($prod_dtls->isNotEmpty()){
        //                             $pr_qty->push(['plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name,'gtin'=>$prod_dtls[0]->gtin]);
        //                         }else{
        //                             $pr_qty->push(['plu'=>'0000','name'=>'','gtin'=>'']);
        //                         }
        //                     }
        //                 }
        //             }
        //             $pr = $pr_qty->groupBy(['plu']);
        //             $or_lines = $pr->map(function ($prs) {
        //                 return ['plu'=>$prs[0]['plu'],'name'=>$prs[0]['name'],'gtin'=>$prs[0]['gtin'],'count'=>$prs->count()];
        //             });

        //             $stored = $stock->created_at;
        //             $stored = $stored->format('d-m-Y');

        //             $best_before = $stock->best_before;
        //             $best_before = Carbon::createFromFormat('Y-m-d', $best_before)->format('d-m-Y');
        //             $stk_lines[] = ['pallet'=>$pallet[0]['name'],'location'=>$location[0]->name,'qty'=>$stock->qty,'best_before'=>$best_before,'stored'=>$stored,'stockid'=>$stock->id,'palletid'=>$stock->pallet_id,'sc_line'=>$or_lines];
        //         }
        //         $status = 3;

        //     }else{
        //         $status = 0;
        //         $stk_lines = "No Stocks Found";
        //     }

        // }else{
        //     $status = 0;
        //     $stk_lines = "No Stocks Found";
        // }

        return response()->json(['status'=>$status,'stocks'=>$stk_lines]);
    }

    public function viewStockProducts($id){
        $palletid = $id;
        $pallet = Pallets::where('id',$palletid)->get();
        $products = $this->ProdfrmPallet($palletid);

        $stk_pallet = Stocks::where('status','In')->orderBy('pallet_id','desc')->pluck('pallet_id');
        if($stk_pallet->isNotEmpty()){
            $pallets = [];
            foreach($stk_pallet as $p_id){
                $p = Pallets::where('id',$p_id)->get();
                $pallets[] = $p[0];
            }
        }

        return view('stocks.stockPallet')->with(['products'=>$products,'pallet'=>$pallet,'pallets'=>$pallets]);
    }

    public function viewProductby($id){
        $palletid = $id;
        $products = $this->ProdfrmPallet($palletid);

        return response()->json(['products'=>$products,]);
    }

    public function ProdfrmPallet($id){
        $prods = ProductHistory::where('new_pallet_id',$id)->where('actions','In')->get();
            foreach($prods as $prop){
                $scnItem = ScanProducts::where('id',$prop->scanned_id)->get();
                if($scnItem->isNotEmpty()){
                    $stks = Stocks::where(['pallet_id'=>$id,'status'=>'In'])->get();
                    if($stks->isNotEmpty()){
                        $codes = $this->barcodeChecker($stks[0]->customer_id,$scnItem[0]->label);
                        if($codes != ""){
                            $prod_dtls = Products::where('gtin',$codes['gtin'])->get();
                            if($prod_dtls->isNotEmpty()){
                                $plu = $prod_dtls[0]->product_code;
                                $name = $prod_dtls[0]->product_name;
                                $gtin = $prod_dtls[0]->gtin;
                                $rcvd = $scnItem[0]->created_at;
                                $weight = $codes['weight'];
                                $date = $codes['date'];
                            }else{
                                $plu = "";
                                $name = "";
                                $gtin = $codes['gtin'];
                                $rcvd = $scnItem[0]->created_at;
                                $weight = $codes['weight'];
                                $date = $codes['date'];
                            }
                        }else{
                            $plu = "";
                            $name = "";
                            $gtin = "";
                            $rcvd = "";
                            $weight = "";
                            $date = "";
                        }
                    }
                }
                $products[] = ['label'=>$scnItem[0]->label,'plu'=>$plu,'date'=>$date,'name'=>$name,'rcvd'=>$rcvd,'gtin'=>$gtin,'weight'=>$weight];
            }


        return $products;
    }

    public function printStock(Request $request){
        $stock_id = $request->stock_id;

        $stocks = Stocks::where('id',$stock_id)->get();

        if($stocks->isNotEmpty()){
            $cx = Customers::where('id',$stocks[0]->customer_id)->get();
            $pallet = Pallets::where('id',$stocks[0]->pallet_id)->get();
            $location = Locations::where('id',$stocks[0]->location_id)->get();
            if($location->isNotEmpty()){
                $loc_name = $location[0]->name;
            }else{
                $loc_name = "Not Found";
            }
            if($pallet->isNotEmpty()){
                $ph = ProductHistory::where('new_pallet_id',$pallet[0]->id)->where('actions','In')->get();
            }
            $count = count($ph);
            $stored = $stocks[0]->created_at;
            $stored = $stored->format('d-m-Y');
        }

        return view('print.printLabel')->with(['cust'=>$cx,'label'=>$pallet[0]->name,'storedate'=>$stored,'location'=>$loc_name,'count'=>$count]);
    }

    public function printDocket(){
        return view('print.printDocket');
    }


}
