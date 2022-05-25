<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Locations;
use App\Models\PalletHistory;
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
        $products = $request->products;

        if($products != ""){
            foreach($products as $product){
                $label = $product['label'];
                $gtin = $product['gtin'];

                $scanProd = new ScanProducts();
                $scanProd->label = $label;
                $scanProd->gtin = $gtin;
                $scanProd->save();
            }

            $status = 1;
            $message = count($products);
        }else{
            $status = 0;
            $message="No Products Added";
        }

        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function assignLocation(Request $request){
        $location = $request->location;
        $old_pallet = $request->old_pallet;
        $new_pallet_id = $request->new_pallet_id;
        $gtin = $request->gtin;
        $qty = $request->qty;

        if($old_pallet != null){
            $old_pallet_id = Pallets::where('name',$old_pallet)->get();
        }else{
            $old_pallet_id = null;
        }

        if($location != ""){
            $exist_loc = Locations::where('name',$location)->get();
            if($exist_loc->isNotEmpty()){
                $loc_id = $exist_loc[0]->id;
            }else{
                $new_loc = new Locations();
                $new_loc->name = $location;
                $new_loc->save();

                if(isset($new_loc->id)){
                    $loc_id = $new_loc->id;
                }
            }

            $pallet_history = new PalletHistory();
            $pallet_history->old_pallet_id = $old_pallet_id;
            $pallet_history->new_pallet_id = $new_pallet_id;
            $pallet_history->item_quantity = $qty;
            $pallet_history->actions = 'Stock-In';
            $pallet_history->new_location_id = $loc_id;
            $pallet_history->save();

            if(isset($pallet_history->id)){
                $stocks = new Stocks();
                $stocks->gtin = $gtin;
                $stocks->qty = $qty;
                $stocks->location_id = $loc_id;
                $stocks->status = null;
                $stocks->save();
            }

            if(isset($stocks->id)){
                $status =1;
                $message ="Pallet Stored";
            }
        }else{
            $status =0;
            $message ="Please Scan Location";
        }

        return response()->json(['status'=>$status,'$message'=>$message]);
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
                $addStock->status = "In";
                $addStock->save();
            }

            if(isset($addStock->id)){
                $date = $addStock->created_at;
                $date = $date->format('d-m-Y');
            }
            $cust = Customers::where('id',$cx_id)->get();
        }else{

        }

        return view('scan.printLabel')->with(['cust'=>$cust,'label'=>$label,'qty'=>$qty,'date'=>$date]);
    }

    public function viewStocks(){
        $customers = Customers::orderBy('name')->get();

        return view('stocks.stocksView')->with(['customers'=>$customers]);
    }

    public function searchStocks(Request $request){
        $cx = $request->cx;
        $date = $request->date;
        $date = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');

        $stocks = Stocks::where('customer_id',$cx)->where('created_at','LIKE',"%{$date}%")->get();


        if($stocks->isNotEmpty()){
            foreach($stocks as $stock){
                $pallets = Pallets::where('id',$stock->pallet_id)->get();
                $locations = Locations::where('id',$stock->location_id)->get();

                $stck_item[] = ['pallet'=>$pallets[0]->name,'location'=>$locations[0]->name,'qty'=>$stock->qty,'date'=>$request->date];
            }
            $status = 1;
        }else{
            $status = 0;
            $stck_item = "No Stocks Found";
        }
        return response()->json(['stocks'=>$stck_item,'status'=>$status]);
    }
}
