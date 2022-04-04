<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //
    public function viewProducts(){
        return view('products.productView');
    }
}
