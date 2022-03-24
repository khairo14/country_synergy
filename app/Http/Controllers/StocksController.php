<?php

namespace App\Http\Controllers;

use App\Models\Stocks;
use Illuminate\Http\Request;


class StocksController extends Controller
{
    public function checkStocks(Request $request)
    {
        $stock = $request->pr_label;

        $check = Stocks::where('product_label', $stock)->pluck('product_label');

        if($check->isEmpty()){
            $item_exist = "true";
        }else{
            $item_exist = "false";
        }

        return response($item_exist);
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
