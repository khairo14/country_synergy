<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Locations;
use App\Models\Pallets;
use App\Models\ProductHistory;
use App\Models\Products;
use App\Models\ScanProducts;
use App\Models\Stocks;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
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

    public function paginate($items, $perPage = 5, $page = null){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage ;
        $itemstoshow = array_slice($items , $offset , $perPage);
        return new LengthAwarePaginator($itemstoshow ,$total   ,$perPage);
    }

    public function detailedReport(){
        $stocks = Stocks::where('customer_id',2)->where('status','In')->get();

        if($stocks->isNotEmpty()){
            foreach($stocks as $stock){
                $ph = ProductHistory::where('new_pallet_id',$stock->pallet_id)->where('actions','In')->get();
                $p = Pallets::where('id',$stock->pallet_id)->get();
                $pr_count = ProductHistory::where('new_pallet_id',$stock->pallet_id)->where('actions','In')->count();
                if($p->isNotEmpty()){
                    $pallet = $p;
                }else{
                    $pallet = "";
                }
                $l = Locations::where('id',$stock->location_id)->get();
                if($l->isNotEmpty()){
                    $locations = $l;
                }else{
                    $locations = "";
                }
                $stored = $stock->created_at;
                $stored = $stored->format('d-m-Y');
                if($ph->isNotEmpty()){
                    foreach($ph as $p){
                        $sc = ScanProducts::where('id',$p->scanned_id)->get();
                        if($sc->isNotEmpty()){
                            $codes = $this->barcodeChecker('2',$sc[0]->label);
                            if($codes != ""){
                                $prod_dtls = Products::where('gtin',$codes['gtin'])->get();
                                if($prod_dtls->isNotEmpty()){
                                    $name = $prod_dtls[0]->product_name;
                                    $weight = $codes['weight'];
                                    $date = $codes['date'];
                                }else{
                                    $name = "";
                                    $weight = "";
                                    $date = "";
                                }
                            }else{
                                $name = "";
                                $weight = "";
                                $date = "";
                            }
                        }
                        $product[] = ['barcode'=>$sc[0]->label,'name'=>$name,'weight'=>$weight,'date'=>$date];
                    }
                    $items[] = ['pallet_name'=>$pallet[0]->name,'products'=>$product,'pallet_count'=>$pr_count];
                }
            }
            $products = $this->paginate($items,100);
            $products->withPath('/reports/stock-detailed/');
        }

        return view('reports.stockDetail', compact('products'));
    }
}
