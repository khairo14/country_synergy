<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Customers;
use App\Models\Products;
use App\Imports\ProductsImport;

class ProductsController extends Controller
{
    //
    public function viewProducts(){
        $customers = Customers::orderBy('name','asc')->get();
        $prod_count = Products::count();
        $products = Products::all();
        return view('products.productView', ['customers'=>$customers,'products'=>$products,'counter'=>$prod_count]);
    }

    public function productImport(Request $request){
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

    public function addProduct(Request $request){
        $p_code = $request->p_code;
        $p_name = $request->p_name;
        $p_gtin = $request->p_gtin;
        $p_brand = $request->p_brand;
        $p_desc = $request->p_desc;
        $p_comp = $request->p_comp;
        $p_size = $request->p_size;

        $addProd = new Products();
        $addProd->product_code = $p_code;
        $addProd->product_name = $p_name;
        $addProd->gtin = $p_gtin;
        $addProd->brand = $p_brand;
        $addProd->description = $p_desc;
        $addProd->company_id = $p_comp;
        $addProd->size = $p_size;
        $addProd->save();

        if(isset($addProd->id)){
            return response()->json(['status'=>1,'message'=>'Product Successfully added']);
        }else{
            return response()->json(['status'=>0,'message'=>'Product unable to add - try again!']);
        }

    }

    public function getProduct(Request $request){
        $prod_id = $request->id;
        $product = Products::where('id',$prod_id)->get();

        return response()->json(['product'=>$product]);
    }

    public function editProduct(Request $request){
        $p_id = $request->p_id;
        $p_code = $request->p_code;
        $p_name = $request->p_name;
        $p_gtin = $request->p_gtin;
        $p_brand = $request->p_brand;
        $p_desc = $request->p_desc;
        $p_size = $request->p_size;

        $editProd = Products::find($p_id);
        $editProd->product_code = $p_code;
        $editProd->product_name = $p_name;
        $editProd->gtin = $p_gtin;
        $editProd->brand = $p_brand;
        $editProd->description = $p_desc;
        $editProd->size = $p_size;
        $editProd->save();

        if(isset($editProd->id)){
            return response()->json(['status'=>1,'message'=>'Product Successfully Updated']);
        }else{
            return response()->json(['status'=>0,'message'=>'Product unable to udpate - try again!']);
        }
    }

}
