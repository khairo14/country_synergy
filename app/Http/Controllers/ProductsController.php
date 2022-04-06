<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class ProductsController extends Controller
{
    //
    public function viewProducts(){
        $customers = Customer::all();
// dd($customers);
        return view('products.productView', ['customers'=>$customers]);
    }
}
