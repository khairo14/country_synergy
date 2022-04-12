<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Customer;
use App\Models\Products;
use App\Imports\ProductsImport;
use SebastianBergmann\Environment\Console;

class ProductsController extends Controller
{
    //
    public function viewProducts(){
        $customers = Customer::all();
        $products = Products::all();
        return view('products.productView', ['customers'=>$customers,'products'=>$products]);
    }

    public function fileImport(Request $request){
        $file = $request->file;
        $cm_id = $request->cm_id;

        if($file){
            $extension = $file->getClientOriginalExtension();
            $filesize = $file->getSize();
            $valid_ext = array("csv","xlsx");
            $maxFileSize = 4194304;

            if(in_array(strtolower($extension), $valid_ext)){
                if($filesize <= $maxFileSize){
                    Excel::import(new ProductsImport($cm_id), $file);
                    return response()->json(['message' => "products records successfully uploaded","status"=>'1']);
                }else{
                    return response()->json(['message' => "No file was uploaded","status"=>'0']);
                }
            }else{
                return response()->json(['message' => "Invalid file extension","status"=>'0']);
            }
        }else{
            return response()->json(['message' => "No file was uploaded","status"=>'0']);
        }
    }

}
