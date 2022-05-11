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
                $status = 2;
                $message = 'Product not Exist Want To Add now?';
            }else{
                $status = 1;
                $message = $exist;
            }
        }
        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function addProducts(Request $request){
        $old_pallet = $request->old_pallet;
        $cust = $request->customer;
        $products = $request->products;

        $chkPallet = Pallets::where('name',$old_pallet)->get();
        if($chkPallet->isNotEmpty()){
            $old_pallet_id = $chkPallet->id;
        }else{
            $old_pallet_id = null;
        }

        if($products != ""){
            foreach($products as $product){
                $label = $product['label'];
                $gtin = $product['gtin'];

                $scanProd = new ScanProducts();
                $scanProd->label = $label;
                $scanProd->gtin = $gtin;
                $scanProd->save();
                if(isset($scanProd->id)){
                    $scnprod_id[] = $scanProd->id;
                }
            }

            $qty = count($products);
            // $prod_details = Products::where('gtin',$gtin)->get();
            $now = Carbon::now()->format('ymd');

            $newPallet = $gtin.$qty.$now;
            $createPallet = new Pallets();
            $createPallet->name = $newPallet;
            $createPallet->save();

            if(isset($createPallet->id)){
                foreach($scnprod_id as $scnId){
                    $prod_history = new ProductHistory();
                    $prod_history->scanned_id = $scnId;
                    $prod_history->gtin = $gtin;
                    $prod_history->old_pallet_id = $old_pallet_id;
                    $prod_history->new_pallet_id = $createPallet->id;
                    $prod_history->actions = 'Stock-In';
                    $prod_history->save();
                }
                $status = 1;
                $message = ['pallet_id'=>$createPallet->id,'pallet_name'=>$newPallet,'qty'=>$qty,'date'=>$now,'gtin'=>$gtin];
            }else{
                $status = 0;
                $message="Error Scanning Products";
            }
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

}
