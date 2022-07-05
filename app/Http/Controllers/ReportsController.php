<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\ProductHistory;
use App\Models\Products;
use App\Models\ScanProducts;
use App\Models\Stocks;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ReportsController extends Controller
{
    public function stockSummary(){
        $customers = Customers::all();
        $ph = ProductHistory::where('actions','In')->get();
        $sc_collect = collect([]);
        foreach($ph as $p){
            $scn = ScanProducts::where('id',$p->scanned_id)->get();
            if($scn->isNotEmpty()){
                $gtin = $scn[0]->gtin;
                if($gtin != ""){
                    $prd = Products::where('gtin',$gtin)->get();
                    if($prd->isNotEmpty()){
                        $sc_collect->push(['plu'=>$prd[0]->product_code,'name'=>$prd[0]->product_name]);
                    }
                }else{
                    $sc_collect->push(['plu'=>'0000','name'=>'no product listed']);
                }
            }
        }

        $pr = $sc_collect->groupBy(['plu']);
        $stk_lines = $pr->map(function ($prs) {
            return ['plu'=>$prs[0]['plu'],'name'=>$prs[0]['name'],'count'=>$prs->count()];

        });

        $stk_lines = Arr::sort($stk_lines);
        return view('reports.stockSummary')->with(['stocks'=>$stk_lines,'customers'=>$customers]);
    }
}
