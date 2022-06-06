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

    // Stock take - Pallet out
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
                    $new_line->plu = $or_line['plu'];
                    $new_line->product_name = $or_line['name'];
                    $new_line->qty = $or_line['count'];
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
                    $new_line->plu = " ";
                    $new_line->product_name = " ";
                    $new_line->qty = $stks[0]->qty;
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


    // Stock take - product out
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
                        $pr_qty->push(['plu'=>$prod_dtls[0]->product_code,'name'=>$prod_dtls[0]->product_name]);
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
                return ['plu'=>$prs[0]['plu'],'name'=>$prs[0]['name'],'count'=>$prs->count()];
            });

            foreach($or_lines as $or_line){
                $new_line = new OrderLines();
                $new_line->order_id = $order_id;
                $new_line->plu = $or_line['plu'];
                $new_line->product_name = $or_line['name'];
                $new_line->qty = $or_line['count'];
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

    // stocks
    public function viewStocks(){
        $customers = Customers::orderBy('name')->get();
        $stocks = Stocks::where('status','In')->orderBy('best_before','asc')->get();

        foreach($stocks as $stock){
            $pallet = Pallets::where('id',$stock->pallet_id)->get();
            $location = Locations::where('id',$stock->location_id)->get();

            $stored = $stock->created_at;
            $stored = $stored->format('d-m-Y');

            $best_before = $stock->best_before;
            $best_before = Carbon::createFromFormat('Y-m-d', $best_before)->format('d-m-Y');

            // $warn = new Carbon($best_before);
            // $warn = $warn->addDays(7,'days');
            // $warn = $warn->format('d-m-Y');
            // dd($pallet);
            $items[] = ['pallet'=>$pallet[0]['name'],'location'=>$location[0]->name,'qty'=>$stock->qty,'best_before'=>$best_before,'stored'=>$stored,'stockid'=>$stock->id,'palletid'=>$stock->pallet_id];
        }

        return view('stocks.stocksView')->with(['customers'=>$customers,'stocks'=>$items]);
    }

    public function searchStocks(Request $request){
        $cx = $request->cx;
        $date = $request->date;
        $date = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');

        $stocks = Stocks::where('customer_id',$cx)->where('created_at','LIKE',"%{$date}%")->where('status','In')->get();


        if($stocks->isNotEmpty()){
            foreach($stocks as $stock){
                $pallets = Pallets::where('id',$stock->pallet_id)->get();
                $locations = Locations::where('id',$stock->location_id)->get();

                $stck_item[] = ['pallet'=>$pallets[0]->name,'location'=>$locations[0]->name,'qty'=>$stock->qty,'date'=>$request->date,'palletid'=>$pallets[0]->id,'best_before'=>$stock->best_before,'stockid'=>$stock->id];
            }
            $status = 1;
        }else{
            $status = 0;
            $stck_item = "No Stocks Found";
        }
        return response()->json(['stocks'=>$stck_item,'status'=>$status]);
    }

    public function viewStockProducts(Request $request){
        $palletid = $request->palletid;
        $pallet = Pallets::where('id',$palletid)->get();
        $products = $this->ProdfrmPallet($palletid);

        return view('stocks.productTable')->with(['products'=>$products,'pallet'=>$pallet]);
    }

    public function ProdfrmPallet($id){
        $prods = ProductHistory::where('new_pallet_id',$id)->where('actions','!=','Out')->get();

        foreach($prods as $prop){
            $scnItem = ScanProducts::where('id',$prop->scanned_id)->get();
            if($scnItem->isNotEmpty()){
                $gtin = $scnItem[0]->gtin;
                if($gtin != "" || $gtin != null){
                    $prodDtls = Products::where('gtin',$gtin)->get();
                    if($prodDtls->isNotEmpty()){
                        $plu = $prodDtls[0]->product_code;
                        $name = $prodDtls[0]->product_name;
                        $dsc = $prodDtls[0]->description;
                    }
                }else{
                        $plu = '';
                        $name = '';
                        $dsc = '';
                }
            }
            $products[] = ['label'=>$scnItem[0]->label,'best_before'=>$scnItem[0]->best_before,'plu'=>$plu,'name'=>$name,'desc'=>$dsc,'rcvd'=>$scnItem[0]->created_at];
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

        // return view('stocks.stockPrint')->with(['cust'=>$cx[0]->name,'label'=>$pallet[0]->name,'qty'=>$qty,'bestbefore'=>$best_before,'storedate'=>$stored]);
    }

    public function printDocket(){
        return view('print.printDocket');
    }
}
