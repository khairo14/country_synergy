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
    public function scanProducts(){
        $customers = Customers::orderBy('name')->get();

        return view('scan.scanProduct')->with(['customers'=>$customers]);
    }

    public function checkProduct(Request $request){
        $label = $request->label;
        $cust = $request->cust;

        $customer = Customers::where('id',$cust)->get();

        if($customer->isNotEmpty()){
            $gtin = substr($label,$customer[0]->gtin_start,$customer[0]->gtin_end);
        }

        $existInStock = ScanProducts::where('label',$label)->get();

        if($existInStock->isNotEmpty()){
            $status = 0;
            $message = 'Product Already Stored - Use Product Tracking';
        }else{
            $exist = Products::where('gtin',$gtin)->get();
            if($exist->isEmpty()){
                $status = 2;
                $message = 'Product not registered - please add later';
            }else{
                $status = 1;
                $message = $exist;
            }
        }
        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function addProducts(Request $request){
        $cx_id = $request->cx;
        $products = $request->products;
        $label = $request->label;
        $qty = $request->qty;
        $loc = $request->loc;
        $bst_before = $request->best_date;
        $new_bst_before = Carbon::createFromFormat('d/m/Y', $bst_before)->format('Y-m-d');
        $cust = Customers::where('id',$cx_id)->get();


        if($cx_id != "" || $label != "" || $qty != ""){
            $addPallet = new Pallets();
            $addPallet->name = $label;
            $addPallet->save();

            if(isset($addPallet->id)){
                $chckLoc = Locations::where('name',$loc)->get();
                if($chckLoc->isNotEmpty()){
                    $loc_id = $chckLoc[0]->id;
                }else{
                    $newLoc = new Locations();
                    $newLoc->name = $loc;
                    $newLoc->save();

                    if(isset($newLoc->id)){
                        $loc_id = $newLoc->id;
                    }
                }

                $addStock = new Stocks();
                $addStock->customer_id = $cx_id;
                $addStock->pallet_id = $addPallet->id;
                $addStock->location_id = $loc_id;
                $addStock->qty = $qty;
                $addStock->best_before = $new_bst_before;
                $addStock->status = "In";
                $addStock->save();

                if($products != ""){
                    foreach($products as $product){
                        $plabel = $product['label'];
                        if($product['gtin'] == " " || $product['gtin'] == ""){
                            $gtin = $product['gtin'];
                            $prod_bst_before = null;
                        }else{
                            $gtin_start = $cust[0]->gtin_start;
                            $gtin_end = $cust[0]->gtin_end;
                            $gtin = substr($plabel,$gtin_start,$gtin_end);

                            $prod_bstdate = substr($plabel,18,6);
                            $year = '20'.substr($prod_bstdate,0,2);
                            $month = substr($prod_bstdate,2,2);
                            $day = substr($prod_bstdate,4,2);
                            $prod_bst_before = $year.'-'.$month.'-'.$day;
                        }

                        $scanProd = new ScanProducts();
                        $scanProd->label = $plabel;
                        $scanProd->gtin = $gtin;
                        $scanProd->best_before = $prod_bst_before;
                        $scanProd->save();

                        if(isset($scanProd->id)){
                            $prod_history = new ProductHistory();
                            $prod_history->scanned_id = $scanProd->id;
                            $prod_history->new_pallet_id = $addPallet->id;
                            $prod_history->actions = "In";
                            $prod_history->save();
                        }

                    }
                }
            }
            if(isset($addStock->id)){
                $date = $addStock->created_at;
                $date = $date->format('d/m/Y');
            }
        }else{

        }
        return view('print.printLabel')->with(['cust'=>$cust,'label'=>$label,'qty'=>$qty,'bestbefore'=>$bst_before,'storedate'=>$date]);
    }

    public function scanPallets(){
        $customers = Customers::orderBy('name')->get();

        return view('scan.scanPallet')->with(['customers'=>$customers]);
    }

    public function checkPallet(Request $request){
        $p_label = $request->p_label;

        if($p_label == ""){
            $status = 0;
            $message = "Scan Pallet";
        }else{
            $pallet = Pallets::where('name',$p_label)->get();

            if($pallet->isNotEmpty()){
                $status = 0;
                $message = "Pallet already Stored - Use Product Tracking";
            }else{
                $status = 1;
                $message = "";
            }
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function checkLocation(Request $request){
        $loc = $request->loc;

        $location = Locations::where('name',$loc)->get();
        if($location->isNotEmpty()){
            $status = 0;
            $message = $location;
        }else{
            $status = 1;
            $message = "Location not found - will be added if continue";
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function addPallet(Request $request){
        $label = $request->plabel;
        $qty = $request->qty;
        $bst_before = $request->best_date;
        $new_bst_before = Carbon::createFromFormat('d/m/Y', $bst_before)->format('Y-m-d');

        $loc = $request->loc;
        $cx_id = $request->cx;

        if($cx_id != "" || $label != "" || $qty != ""){
            $addPallet = new Pallets();
            $addPallet->name = $label;
            $addPallet->save();

            if(isset($addPallet->id)){
                $chckLoc = Locations::where('name',$loc)->get();
                if($chckLoc->isNotEmpty()){
                    $loc_id = $chckLoc[0]->id;
                }else{
                    $newLoc = new Locations();
                    $newLoc->name = $loc;
                    $newLoc->save();

                    if(isset($newLoc->id)){
                        $loc_id = $newLoc->id;
                    }
                }
                $addStock = new Stocks();
                $addStock->customer_id = $cx_id;
                $addStock->pallet_id = $addPallet->id;
                $addStock->location_id = $loc_id;
                $addStock->qty = $qty;
                $addStock->best_before = $new_bst_before;
                $addStock->status = "In";
                $addStock->save();
            }

            if(isset($addStock->id)){
                $date = $addStock->created_at;
                $date = $date->format('d/m/Y');
            }
            $cust = Customers::where('id',$cx_id)->get();
        }else{

        }

        return view('print.printLabel')->with(['cust'=>$cust,'label'=>$label,'qty'=>$qty,'bestbefore'=>$bst_before,'storedate'=>$date]);
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

    public function getPallet(Request $request){
        $label = $request->label;

        if($label != ""){
            $p_id = Pallets::where('name',$label)->get();

            if($p_id->isNotEmpty()){
                $stock = Stocks::where(['pallet_id'=>$p_id[0]->id,'status'=>'In'])->get();
                if($stock->isNotEmpty()){
                    $loc = Locations::where('id',$stock[0]->location_id)->get();
                    $cx = Customers::where('id',$stock[0]->customer_id)->get();
                    $status = 1;
                    $message = ['customer'=>$cx,'location'=>$loc,'pallet'=>$p_id,'qty'=>$stock[0]->qty];
                }
            }else{
                $status = 0;
                $message = "Pallet not found - Please scan again.";
            }
        }else{
            $status = 0;
            $message = "Pallet not found - Please scan again.";
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function viewAdd2pallet(){
        return view('scan.scanAddToPallet');
    }

    public function prodToPallet(Request $request){
        $cx = $request->cx;
        $products = $request->products;
        $pallet_id= $request->pallet_id;

        $stcks = Stocks::where(['pallet_id'=>$pallet_id,'status'=>'In'])->get();

        if($stcks->isNotEmpty()){
            $cur_qty = $stcks[0]->qty;
            $stk_id = $stcks[0]->id;
            $qty = count($products);
            foreach($products as $product){
                if($product['gtin'] == " " || $product['gtin'] ==""){
                    $gtin = $product['gtin'];
                    $prod_bst_before = null;
                }else{
                    $cust = Customers::where('id',$cx)->get();
                    $gtin = substr($product['label'],$cust[0]->gtin_start,$cust[0]->gtin_end);

                    $prod_bstdate = substr($product['label'],18,6);
                    $year = '20'.substr($prod_bstdate,0,2);
                    $month = substr($prod_bstdate,2,2);
                    $day = substr($prod_bstdate,4,2);
                    $prod_bst_before = $year.'-'.$month.'-'.$day;
                }

                $scanProd = new ScanProducts();
                $scanProd->label = $product['label'];
                $scanProd->gtin = $gtin;
                $scanProd->best_before = $prod_bst_before;
                $scanProd->save();

                if(isset($scanProd->id)){
                    $prod_history = new ProductHistory();
                    $prod_history->scanned_id = $scanProd->id;
                    $prod_history->new_pallet_id = $pallet_id;
                    $prod_history->actions = "In";
                    $prod_history->save();
                }
            }
            $new_qty = $cur_qty + $qty;
            $upStock = Stocks::find($stk_id);
            $upStock->qty = $new_qty;
            $upStock->save();

            $status = 1;
            $message = "Products Successfully Added To Stocks";
        }else{
            $status = 0;
            $message = "Failed to Add Products";
        }
        return response()->json(['status'=>$status,'message'=>$message]);
    }

    // Stock out - Pallet out
    public function palletOut(Request $request){
        $label = $request->label;
        $pallet = Pallets::where(['name'=>$label])->get();
        $now = Carbon::now();


        if($pallet->isNotEmpty()){
            $order = new Orders();
            $order->status = "Incomplete";
            $order->save();
            if(isset($order->id)){
                $order_id = $order->id;
            }

            $pr_qty = collect([]);
            $ph = ProductHistory::where(['new_pallet_id'=>$pallet[0]->id,'actions'=>'In'])->get();
            if($ph->isNotEmpty()){
                foreach($ph as $prod_hist){
                    $sp = ScanProducts::where('id',$prod_hist->scanned_id)->get();
                    if($sp->isNotEmpty()){
                        if($sp[0]->gtin != ""){
                            $prod_dtls = Products::where('gtin',$sp[0]->gtin)->get();
                            $pr_qty->push(['plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name]);
                        }else{
                            $pr_qty->push(['plu'=>'','name'=>'']);
                        }

                        $change_ph = ProductHistory::find($prod_hist->id);
                        $change_ph->order_id = $order_id;
                        $change_ph->order_out_date = $now;
                        $change_ph->actions = 'Out';
                        $change_ph->save();
                    }

                    $stks = Stocks::where(['pallet_id'=>$pallet[0]->id,'status'=>'In'])->get();
                    if($stks->isNotEmpty()){
                        $qty = $stks[0]->qty - 1;
                        if($qty <= 0){
                            $new_stks = Stocks::find($stks[0]->id);
                            $new_stks->qty = $qty;
                            $new_stks->status = 'Out';
                            $new_stks->save();
                        }else{
                            $new_stks = Stocks::find($stks[0]->id);
                            $new_stks->qty = $qty;
                            $new_stks->save();
                        }
                    }
                }
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

                $status = 1;
                $message = "Order Created - Check Order Page - Order #".$order_id;
            }else{
                $stks = Stocks::where(['pallet_id'=>$pallet[0]->id,'status'=>'In'])->get();
                if($stks->isNotEmpty()){
                    $new_stks = Stocks::find($stks[0]->id);
                    $new_stks->qty = 0;
                    $new_stks->status = 'Out';
                    $new_stks->save();

                    $new_line = new OrderLines();
                    $new_line->order_id = $order_id;
                    $new_line->sc_plu = " ";
                    $new_line->sc_prod_name = " ";
                    $new_line->sc_qty = $stks[0]->qty;
                    $new_line->save();

                    if(isset($new_line->id)){
                        $status = 1;
                        $message = "Order Created - Check Order Page - Order #".$order_id;
                    }else{
                        $status = 0;
                        $message = "Unable to Create Order";
                    }
                }else{
                    $status = 0;
                    $message = "Unable to Create Order";
                }
            }

        }else{
            $status = 0;
            $message = "Please Scan Pallet";
        }
        return response()->json(['status'=>$status,'message'=>$message]);
    }

    // Stock out - product out
    public function checkStockProduct(Request $request){
        $label = $request->label;

        $exist = ScanProducts::where('label',$label)->get();

        if($exist->isNotEmpty()){
            $stock = ProductHistory::where('scanned_id',$exist[0]->id)->where('actions','In')->get();
            if($stock->isNotEmpty()){
                $prod_dtls = Products::where('gtin',$exist[0]->gtin)->get();
                if($prod_dtls->isNotEmpty()){
                    $status = 1;
                    $message = ['label'=>$label,'plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name];
                }else{
                    $status = 2;
                    $message = ['label'=>$label];
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
        $or_qty = count($prods);
        $now = Carbon::now();

        if($prods != ""){
            $order = new Orders();
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
                    if($sp[0]->gtin != ""){
                        $prod_dtls = Products::where('gtin',$sp[0]->gtin)->get();
                        $pr_qty->push(['plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name,'gtin'=>$prod_dtls[0]->gtin]);
                    }else{
                        $pr_qty->push(['plu'=>'','name'=>'']);
                    }
                }
                if($ph->isNotEmpty()){
                    $stks = Stocks::where('pallet_id',$ph[0]->new_pallet_id)->get();

                    $new_ph = ProductHistory::find($ph[0]->id);
                    $new_ph->order_id = $order_id;
                    $new_ph->order_out_date = $now;
                    $new_ph->actions = "Out";
                    $new_ph->save();
                }

                if($stks->isNotEmpty()){
                    $qty = $stks[0]->qty - 1;
                    if($qty <= 0){
                        $new_stks = Stocks::find($stks[0]->id);
                        $new_stks->qty = $qty;
                        $new_stks->status = 'Out';
                        $new_stks->save();
                    }else{
                        $new_stks = Stocks::find($stks[0]->id);
                        $new_stks->qty = $qty;
                        $new_stks->save();
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
                $new_line->sc_plu = $or_line['plu'];
                $new_line->sc_gtin = $or_line['gtin'];
                $new_line->sc_prod_name = $or_line['name'];
                $new_line->sc_qty = $or_line['count'];
                $new_line->save();
            }
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
    public function findProduct(){
        return view('scan.scanTransferProduct');
    }

    public function trnsfrProdChck(Request $request){
        $lbl = $request->lbl;

        if($lbl != ""){
            $scanChk = ScanProducts::where('label',$lbl)->get();
            if($scanChk->isNotEmpty()){
                $ph = ProductHistory::where('scanned_id',$scanChk[0]->id)->get();
                if($ph->isNotEmpty()){
                    $status = $ph[0]->actions;
                    if($status == 'Out'){
                        $status = 0;
                        $message = "Product Added On Order Out Please Check Order #".$ph[0]->order_id;
                    }else{
                        $prd_info = Products::where('gtin',$scanChk[0]->gtin)->get();
                        if($prd_info->isNotEmpty()){
                            $status = 1;
                            $message = ['label'=>$lbl,'plu'=>$prd_info[0]->product_code,'ph_id'=>$ph[0]->id];
                        }else{
                            $status = 1;
                            $message = ['label'=>$lbl,'plu'=>"0000"];
                        }
                    }
                }
            }else{
                $status = 0;
                $message = "Product Not Exist In Stock - Please Use Scan In";
            }
        }else{
            $status = 0;
            $message = "Error Scanning Products";
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function trnsfrProdNewPallet(Request $request){
        $bb_date = $request->bb_date;
        $bb_date = Carbon::createFromFormat('d/m/Y', $bb_date)->format('Y-m-d');
        $loc_name = $request->loc;
        $loc_id = $request->loc_id;
        $p_name = $request->pallet;
        $prod = $request->prod;

        if($p_name != ""){
            $chk_pallet = Pallets::where('name',$p_name)->get();
            if($chk_pallet->isNotEmpty()){
                $status = 0;
                $message = "Pallet Name Already Exist Try Again";
            }else{
                $new_pallet = new Pallets();
                $new_pallet->name = $p_name;
                $new_pallet->save();

                if($loc_id == 0){
                    $new_location = new Locations();
                    $new_location->name = $loc_name;
                    $new_location->save();
                    if(isset($new_location->id)){
                        $new_loc_id = $new_location->id;
                    }
                }else{
                    $new_loc_id = $loc_id;
                }

                if(isset($new_pallet->id)){
                    foreach($prod as $pr){
                        $old_pallet_id = ProductHistory::where('id',$pr['ph_id'])->pluck('new_pallet_id');

                        $new_ph = ProductHistory::find($pr['ph_id']);
                        $new_ph->old_pallet_id = $old_pallet_id[0];
                        $new_ph->new_pallet_id = $new_pallet->id;
                        $new_ph->save();

                        // remove from stocks
                        $stk = Stocks::where('pallet_id',$old_pallet_id[0])->get();
                        if($stk->isNotEmpty()){
                            $update_qty = $stk[0]->qty - 1;
                            if($update_qty == 0){
                                $status = "Out";
                            }else{
                                $status = $stk[0]->status;
                            }
                            $update_stk = Stocks::find($stk[0]->id);
                            $update_stk->qty = $update_qty;
                            $update_stk->status = $status;
                            $update_stk->save();
                        }
                        // add to stocks
                        $chk = Stocks::where('pallet_id',$new_pallet->id)->get();
                        if($chk->isNotEmpty()){
                            $up_qty = $chk[0]->qty +1;
                            $up_stk = Stocks::find($chk[0]->id);
                            $up_stk->qty = $up_qty;
                            $up_stk->save();
                        }else{
                            $up_stk = new Stocks();
                            $up_stk->customer_id = $stk[0]->customer_id;
                            $up_stk->pallet_id = $new_pallet->id;
                            $up_stk->location_id = $new_loc_id;
                            $up_stk->qty = 1;
                            $up_stk->best_before = $bb_date;
                            $up_stk->status = "In";
                            $up_stk->save();
                        }
                    }
                    $status = 1;
                    $message = ['pallet'=>$p_name];
                }else{
                    $status = 0;
                    $message = "Unable to Create New Pallet";
                }
            }
        }else{
            $status = 0;
            $message = "Pallet Name Missing";
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

                    // remove from stocks
                    $stk = Stocks::where('pallet_id',$old_pallet_id[0])->get();
                    if($stk->isNotEmpty()){
                        $update_qty = $stk[0]->qty - 1;
                        if($update_qty == 0){
                            $status = "Out";
                        }else{
                            $status = $stk[0]->status;
                        }
                        $update_stk = Stocks::find($stk[0]->id);
                        $update_stk->qty = $update_qty;
                        $update_stk->status = $status;
                        $update_stk->save();
                    }
                    // add to stocks
                    $chk = Stocks::where('pallet_id',$p_id)->get();
                    if($chk->isNotEmpty()){
                        $up_qty = $chk[0]->qty +1;
                        $up_stk = Stocks::find($chk[0]->id);
                        $up_stk->qty = $up_qty;
                        $up_stk->save();
                    }else{
                        $status = 0;
                        $message = "Pallet was Removed from stocks";
                    }
            }
            $status = 1;
            $message = "Transfer Succesfull";
        }else{
            $status = 0;
            $message = "Unable to locate Pallet";
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function findPallet(){
        return view('scan.scanTransferPallet');
    }

    public function trnsfrPalltChck(Request $request){
        $p_name = $request->pname;

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

    public function viewMerge(){
        return view('scan.scanMergePallet');
    }

    public function PalletCheck(Request $request){
        $p_name = $request->p_name;

        $pallet = Pallets::where('name',$p_name)->get();
        if($pallet->isNotEmpty()){
            // $stk = Stocks::where('pallet_id',$pallet[0]->id)->get();
            $ph = ProductHistory::where('new_pallet_id',$pallet[0]->id)->where('actions','!=','Out')->get();
            $pr_qty = collect([]);
            if($ph->isNotEmpty()){
                foreach($ph as $p){
                    $sp = ScanProducts::where('id',$p->scanned_id)->get();
                    if($sp->isNotEmpty()){
                        $prod_dtls = Products::where('gtin',$sp[0]->gtin)->get();
                        if($prod_dtls->isNotEmpty()){
                            $pr_qty->push(['plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name,'gtin'=>$prod_dtls[0]->gtin]);
                        }else{
                            $pr_qty->push(['plu'=>'0000','name'=>'','gtin'=>'']);
                        }
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
                $new_stk_qty = $c1[0]->qty + $c2[0]->qty;

                $update_stk1 = Stocks::find($c2[0]->id);
                $update_stk1->qty = $new_stk_qty;
                $update_stk1->save();

                $update_stk2 = Stocks::find($c1[0]->id);
                $update_stk2->qty = 0;
                $update_stk2->status = "Out";
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
    public function viewStockTake(){
        return view('scan.scanStockTake');
    }

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
                                    $prod_dtls = Products::where('gtin',$sp[0]->gtin)->get();
                                    if($prod_dtls->isNotEmpty()){
                                        $pr_qty->push(['plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name]);
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
                $gtin = $sc_id[0]->gtin;
                $pallet = Pallets::where('name',$p_name)->get();
                if($pallet->isNotEmpty()){
                    $ph = ProductHistory::where('scanned_id',$sc_id[0]->id)->get();
                    $cur_pallet = $ph[0]->new_pallet_id;
                    $sc_pallet = $pallet[0]->id;

                    if($gtin != ""){
                        $prd = Products::where('gtin',$gtin)->get();
                        if($prd->isNotEmpty()){
                            $prod_details = ['plu'=>$prd[0]->product_code,'name'=>$prd[0]->product_name];
                        }else{
                            $prod_details = ['plu'=>'0000','name'=>''];
                        }
                    }else{
                        $prod_details = ['plu'=>'0000','name'=>''];
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
                $old_qty = Stocks::where('pallet_id',$p_id[0]->id)->pluck('qty');
                if($stk->isNotEmpty()){
                    $stk_qty = $stk[0]->qty;
                    $new_qty = ($old_qty[0] - $cur_qty) + $stk_qty;
                    $now = Carbon::now();

                    $new_stk = Stocks::find($stk[0]->id);
                    $new_stk->customer_id = $stk[0]->customer_id;
                    $new_stk->pallet_id = $trash_pallet;
                    $new_stk->location_id = $new_loc;
                    $new_stk->qty = $new_qty;
                    $new_stk->best_before = $now;
                    $new_stk->status = "Dump";
                    $new_stk->save();
                }else{
                    $cs_id = Stocks::where('pallet_id',$p_id[0]->id)->pluck('customer_id');
                    $new_qty = $old_qty[0] - $cur_qty;
                    $now = Carbon::now();

                    $new_stk = new Stocks();
                    $new_stk->customer_id = $cs_id[0];
                    $new_stk->pallet_id = $trash_pallet;
                    $new_stk->location_id = $new_loc;
                    $new_stk->qty = $new_qty;
                    $new_stk->best_before = $now;
                    $new_stk->status = "Dump";
                    $new_stk->save();
                }
            }

            foreach($products as $product){
                $sc = ScanProducts::where('label',$product['label'])->get();
                $stks = Stocks::where('pallet_id',$p_id[0]->id)->get();
                $cs = Customers::where('id',$stks[0]->customer_id)->get();

                if($stks->isNotEmpty()){
                    $new_stks = Stocks::find($stks[0]->id);
                    $new_stks->qty = $cur_qty;
                    $new_stks->save();
                }

                if($cs->isNotEmpty()){
                    $gtin_start = $cs[0]->gtin_start;
                    $gtin_end = $cs[0]->gtin_end;
                    $gtin = substr($product['label'],$gtin_start,$gtin_end);
                }else{
                    $gtin = null;
                }


                if($sc->isNotEmpty()){
                    $sc_id = $sc[0]->id;
                    $ph_id = ProductHistory::where('scanned_id',$sc_id)->pluck('id');
                    if($ph_id->isNotEmpty()){
                        $new_ph = ProductHistory::find($ph_id[0]);
                        $new_ph->new_pallet_id = $p_id[0]->id;
                        $new_ph->actions = "In";
                        $new_ph->save();
                    }
                }else{
                    $new_sc = new ScanProducts();
                    $new_sc->label = $product['label'];
                    $new_sc->gtin = $gtin;
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
        $stocks = Stocks::where('status','In')->orderBy('best_before','asc')->get();

        foreach($stocks as $stock){
            $pr_qty = collect([]);
            $pallet = Pallets::where('id',$stock->pallet_id)->get();
            $location = Locations::where('id',$stock->location_id)->get();
            $ph = ProductHistory::where('new_pallet_id',$stock->pallet_id)->where('actions','!=','Out')->get();
            if($ph->isNotEmpty()){
                foreach($ph as $p){
                    $sp = ScanProducts::where('id',$p->scanned_id)->get();
                    if($sp->isNotEmpty()){
                        $prod_dtls = Products::where('gtin',$sp[0]->gtin)->get();
                        if($prod_dtls->isNotEmpty()){
                            $pr_qty->push(['plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name,'gtin'=>$prod_dtls[0]->gtin]);
                        }else{
                            $pr_qty->push(['plu'=>'0000','name'=>'','gtin'=>'']);
                        }
                    }
                }
            }
            $pr = $pr_qty->groupBy(['plu']);
            $or_lines = $pr->map(function ($prs) {
                return ['plu'=>$prs[0]['plu'],'name'=>$prs[0]['name'],'gtin'=>$prs[0]['gtin'],'count'=>$prs->count()];
            });

            $stored = $stock->created_at;
            $stored = $stored->format('d-m-Y');

            $best_before = $stock->best_before;
            $best_before = Carbon::createFromFormat('Y-m-d', $best_before)->format('d-m-Y');
            $items[] = ['pallet'=>$pallet[0]['name'],'location'=>$location[0]->name,'qty'=>$stock->qty,'best_before'=>$best_before,'stored'=>$stored,'stockid'=>$stock->id,'palletid'=>$stock->pallet_id,'sc_line'=>$or_lines];
        }


            $ph0 = ProductHistory::where('actions','In')->get();
            if($ph0->isNotEmpty()){
                $sc_collection = collect([]);
                foreach($ph0 as $i){
                    $scn_prdds = ScanProducts::where('id',$i->scanned_id)->get();
                    if($scn_prdds->isNotEmpty()){
                        $sc_collection->push(['gtin'=>$scn_prdds[0]->gtin]);
                    }
                }
                $g1 = $sc_collection->groupBy(['gtin']);
                foreach($g1 as $gtin){
                    $pc = Products::where('gtin',$gtin[0]['gtin'])->pluck('product_code');
                    if($pc->isNotEmpty()){
                        $plu[] = $pc[0];
                    }else{
                        $plu[] = "0000";
                    }
                }
                $plu = Arr::sort($plu);
            }
        return view('stocks.stocksView')->with(['customers'=>$customers,'stocks'=>$items,'plu'=>$plu]);
    }

    public function searchStocks(Request $request){
        $cx = $request->cx;
        $date = $request->date;
        $plu = $request->plu;

        if($plu == "" && $date ==""){
            $stocks = Stocks::where('customer_id',$cx)->where('status','In')->orderBy('best_before','asc')->get();
            foreach($stocks as $stock){
                $pr_qty = collect([]);
                $pallet = Pallets::where('id',$stock->pallet_id)->get();
                $location = Locations::where('id',$stock->location_id)->get();
                $ph = ProductHistory::where('new_pallet_id',$stock->pallet_id)->where('actions','!=','Out')->get();
                if($ph->isNotEmpty()){
                    foreach($ph as $p){
                        $sp = ScanProducts::where('id',$p->scanned_id)->get();
                        if($sp->isNotEmpty()){
                            $prod_dtls = Products::where('gtin',$sp[0]->gtin)->get();
                            if($prod_dtls->isNotEmpty()){
                                $pr_qty->push(['plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name,'gtin'=>$prod_dtls[0]->gtin]);
                            }else{
                                $pr_qty->push(['plu'=>'0000','name'=>'','gtin'=>'']);
                            }
                        }
                    }
                }
                $pr = $pr_qty->groupBy(['plu']);
                $or_lines = $pr->map(function ($prs) {
                    return ['plu'=>$prs[0]['plu'],'name'=>$prs[0]['name'],'gtin'=>$prs[0]['gtin'],'count'=>$prs->count()];
                });

                $stored = $stock->created_at;
                $stored = $stored->format('d-m-Y');

                $best_before = $stock->best_before;
                $best_before = Carbon::createFromFormat('Y-m-d', $best_before)->format('d-m-Y');
                $stk_lines[] = ['pallet'=>$pallet[0]['name'],'location'=>$location[0]->name,'qty'=>$stock->qty,'best_before'=>$best_before,'stored'=>$stored,'stockid'=>$stock->id,'palletid'=>$stock->pallet_id,'sc_line'=>$or_lines];
            }
            $status = 1;
        }elseif($plu != "" && $date == ""){
            $prods = Products::where('product_code',$plu)->get();
            $sc_collect = collect([]);
            if($prods->isNotEmpty()){
                $scn_id = ScanProducts::where('gtin',$prods[0]->gtin)->get();
                foreach($scn_id as $scn){
                    $ph = ProductHistory::where('scanned_id',$scn['id'])->where('actions','In')->get();
                    if($ph->isNotEmpty()){
                        $pallet = Pallets::where('id',$ph[0]->new_pallet_id)->get();
                        $l_id = Stocks::where('pallet_id',$pallet[0]->id)->get();
                        $loc = Locations::where('id',$l_id[0]->location_id)->get();
                        $bb = Carbon::createFromFormat('Y-m-d', $l_id[0]->best_before)->format('d-m-Y');
                        $rb = $l_id[0]->created_at->format('d-m-Y');
                        $sc_collect->push(['best_before'=>$bb,'pallet'=>$pallet[0]->name,'palletid'=>$pallet[0]->id,'rcvd'=>$rb,'location'=>$loc[0]->name,'plu'=>$plu,'p_name'=>$prods[0]->product_name]);
                    }
                }
            }else{

            }

            $gp = $sc_collect->groupBy('pallet');
            $stk_lines[] = $gp->map(function ($prs) {
                return ['pallet'=>$prs[0]['pallet'],'palletid'=>$prs[0]['palletid'],'plu'=>$prs[0]['plu'],'name'=>$prs[0]['p_name'],'best_before'=>$prs[0]['best_before'],'received_date'=>$prs[0]['rcvd'],'location'=>$prs[0]['location'],'count'=>$prs->count()];
            });
            $status = 2;
        }elseif($plu == "" && $date != ""){
            $date = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
            $stocks = Stocks::where('customer_id',$cx)->where('created_at','LIKE',"%{$date}%")->where('status','In')->get();
            if($stocks->isNotEmpty()){

                foreach($stocks as $stock){
                    $pr_qty = collect([]);
                    $pallet = Pallets::where('id',$stock->pallet_id)->get();
                    $location = Locations::where('id',$stock->location_id)->get();
                    $ph = ProductHistory::where('new_pallet_id',$stock->pallet_id)->where('actions','!=','Out')->get();
                    if($ph->isNotEmpty()){
                        foreach($ph as $p){
                            $sp = ScanProducts::where('id',$p->scanned_id)->get();
                            if($sp->isNotEmpty()){
                                $prod_dtls = Products::where('gtin',$sp[0]->gtin)->get();
                                if($prod_dtls->isNotEmpty()){
                                    $pr_qty->push(['plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name,'gtin'=>$prod_dtls[0]->gtin]);
                                }else{
                                    $pr_qty->push(['plu'=>'0000','name'=>'','gtin'=>'']);
                                }
                            }
                        }
                    }
                    $pr = $pr_qty->groupBy(['plu']);
                    $or_lines = $pr->map(function ($prs) {
                        return ['plu'=>$prs[0]['plu'],'name'=>$prs[0]['name'],'gtin'=>$prs[0]['gtin'],'count'=>$prs->count()];
                    });

                    $stored = $stock->created_at;
                    $stored = $stored->format('d-m-Y');

                    $best_before = $stock->best_before;
                    $best_before = Carbon::createFromFormat('Y-m-d', $best_before)->format('d-m-Y');
                    $stk_lines[] = ['pallet'=>$pallet[0]['name'],'location'=>$location[0]->name,'qty'=>$stock->qty,'best_before'=>$best_before,'stored'=>$stored,'stockid'=>$stock->id,'palletid'=>$stock->pallet_id,'sc_line'=>$or_lines];
                }
                $status = 3;

            }else{
                $status = 0;
                $stk_lines = "No Stocks Found";
            }

        }else{
            $status = 0;
            $stk_lines = "No Stocks Found";
        }

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
        $prods = ProductHistory::where('new_pallet_id',$id)->where('actions','!=','Out')->get();

        foreach($prods as $prop){
            $scnItem = ScanProducts::where('id',$prop->scanned_id)->get();
            if($scnItem->isNotEmpty()){
                $gtin = $scnItem[0]->gtin;
                $rcvd = $scnItem[0]->created_at->format('d-m-Y');
                if($gtin != "" || $gtin != null){
                    $prodDtls = Products::where('gtin',$gtin)->get();
                    if($prodDtls->isNotEmpty()){
                        $plu = $prodDtls[0]->product_code;
                        $name = $prodDtls[0]->product_name;
                        $dsc = $prodDtls[0]->description;
                        $gtin = $prodDtls[0]->gtin;
                    }else{
                        $plu = '0000';
                        $name = '';
                        $dsc = '';
                        $gtin ='';
                    }
                }else{
                        $plu = '0000';
                        $name = '';
                        $dsc = '';
                        $gtin ='';
                }
                $w1 = 28;
                $w2 = 6;
                $w_val = substr($scnItem[0]->label,$w1,$w2);
                $weight = $w_val / 1000;
                $bb = Carbon::createFromFormat('Y-m-d', $scnItem[0]->best_before)->format('d-m-Y');
            }
            $products[] = ['label'=>$scnItem[0]->label,'best_before'=>$bb,'plu'=>$plu,'name'=>$name,'desc'=>$dsc,'rcvd'=>$rcvd,'gtin'=>$gtin,'weight'=>$weight];
        }
        return $products;
    }

    public function printStock(Request $request){
        $stock_id = $request->stock_id;

        $stocks = Stocks::where('id',$stock_id)->get();

        if($stocks->isNotEmpty()){
            $cx = Customers::where('id',$stocks[0]->customer_id)->get();
            $pallet = Pallets::where('id',$stocks[0]->pallet_id)->get();
            // $location = Locations::where('id',$stocks[0]->location_id)->get();
            $qty = $stocks[0]->qty;
            $stored = $stocks[0]->created_at;
            $stored = $stored->format('d-m-Y');

            $best_before = $stocks[0]->best_before;
            $best_before = Carbon::createFromFormat('Y-m-d', $best_before)->format('d-m-Y');
        }

        return view('print.printLabel')->with(['cust'=>$cx,'label'=>$pallet[0]->name,'qty'=>$qty,'bestbefore'=>$best_before,'storedate'=>$stored]);
    }

    public function printDocket(){
        return view('print.printDocket');
    }
}
