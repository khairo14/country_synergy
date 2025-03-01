<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PDFController;
use App\Models\Locations;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/sign-in',[UsersController::class,'signIn']);
Route::get('/sign-out',[UsersController::class,'signOut']);
Route::view('/','login')->name('login')->middleware('guest');
Route::view('/home','dashboard')->name('home')->middleware('auth')->name('home');

// dashboard
Route::view('/home/scan','/scan/scanIn')->middleware('auth');
Route::get('/home/scan/products',[StocksController::class,'scanProducts'])->middleware('auth');
Route::post('/home/scan/check-product',[StocksController::class,'checkProduct'])->middleware('auth');
Route::post('/home/scan/scan-products',[StocksController::class,'addProducts'])->middleware('auth');
Route::post('/home/scan/assign-location',[StocksController::class,'assignLocation'])->middleware('auth');


// freezer locations
Route::get('/location',[LocationsController::class,'fLocation'])->name('location');
Route::post('/location/add',[LocationsController::class,'addLocation'])->middleware('auth');
Route::post('/location/edit',[LocationsController::class,'editLocation'])->middleware('auth');
Route::post('/location/import',[LocationsController::class,'locationImport'])->middleware('auth');


// products
Route::get('/products',[ProductsController::class,'viewProducts'])->middleware('auth')->name('products');
Route::post('/product-import',[ProductsController::class,'productImport'])->name('product-import');
Route::post('/products/add',[ProductsController::class,'addProduct'])->middleware('auth');
Route::post('/products/get',[ProductsController::class,'getProduct'])->middleware('auth');
Route::post('/products/edit',[ProductsController::class,'editProduct'])->middleware('auth');



// Route::view('/scan', 'scan');
// Route::post('/checkStocks',[StocksController::class,'checkStocks']);
// Route::post('/scan/order',[StocksController::class,'checkOrders']);
// Route::post('/checkBin',[StocksController::class,'checkBins']);
// Route::post('/check/pallete',[StocksController::class,'checkStocksPallete']);
// Route::post('/store/products',[StocksController::class,'storeProducts']);
// Route::get('/getStocks/{id}',[StocksController::class,'getStocks']);
// Route::get('/getBin/{id}',[StocksController::class,'getBin']);
// Route::get('/orderType/{id}',[StocksController::class,'getOrderType']);



//Printing labels
// Route::get('/palletlabels', [PDFController::class,'palletlabels'])->middleware('auth');
// Route::get('/printlabels', [PDFController::class,'printlabels'])->middleware('auth');

// import products
// Route::get('/file-import-export',[ProductsController::class,'fileImportExport']);
// Route::post('/file-import',[ProductsController::class,'fileImport'])->name('file-import');

// customers
Route::resource('/customers', CustomersController::class);

// orders
// Route::get('/orders',[OrdersController::class,'viewOrders']);
// Route::get('/createOrder',[OrdersController::class,'getCustomer'])->middleware('auth');
// Route::post('/get-productList',[OrdersController::class,'productList'])->middleware('auth');
// Route::post('/get-product',[OrdersController::class,'getProduct'])->middleware('auth');
// Route::post('/save-order',[OrdersController::class,'addOrderIn'])->middleware('auth');
// Route::post('/get-company-order',[OrdersController::class,'viewCompOrder']);
// stocks
// Route::get('/stocks',[StocksController::class,'stocksView']);
