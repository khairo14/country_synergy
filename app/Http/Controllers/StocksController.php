<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Locations;
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
                $status = 0;
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
                        if($product['gtin'] != " "){
                            $gtin = $product['gtin'];

                            $prod_bstdate = substr($plabel,18,6);
                            $year = '20'.substr($prod_bstdate,0,2);
                            $month = substr($prod_bstdate,2,2);
                            $day = substr($prod_bstdate,4,2);
                            $prod_bst_before = $year.'-'.$month.'-'.$day;
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
        return view('scan.printLabel')->with(['cust'=>$cust,'label'=>$label,'qty'=>$qty,'bestbefore'=>$bst_before,'storedate'=>$date]);
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

        return view('scan.printLabel')->with(['cust'=>$cust,'label'=>$label,'qty'=>$qty,'bestbefore'=>$bst_before,'storedate'=>$date]);
    }

    public function viewPalletOut(){
        $customers = Customers::orderBy('name')->get();

        return view('scan.scanPalletOut')->with(['customers'=>$customers]);
    }

    public function getPallet(Request $request){
        $label = $request->label;

        if($label != ""){
            $p_id = Pallets::where('name',$label)->get();

            if($p_id->isNotEmpty()){
                $stock = Stocks::where('pallet_id',$p_id[0]->id)->get();
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

            $items[] = ['pallet'=>$pallet[0]->name,'location'=>$location[0]->name,'qty'=>$stock->qty,'best_before'=>$best_before,'stored'=>$stored,'stockid'=>$stock->id,'palletid'=>$stock->pallet_id];
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

        // var_dump($products);
        return view('stocks.productTable')->with(['products'=>$products,'pallet'=>$pallet]);
    }

    public function ProdfrmPallet($id){
        $prods = ProductHistory::where('new_pallet_id',$id)->get();
        $pallet = Pallets::where('id',$id)->get();
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

        return view('scan.printLabel')->with(['cust'=>$cx,'label'=>$pallet[0]->name,'qty'=>$qty,'bestbefore'=>$best_before,'storedate'=>$stored]);

        // return view('stocks.stockPrint')->with(['cust'=>$cx[0]->name,'label'=>$pallet[0]->name,'qty'=>$qty,'bestbefore'=>$best_before,'storedate'=>$stored]);
    }
}
