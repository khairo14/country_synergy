<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PDFController;

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

Route::view('/scan', 'scan');
Route::post('/checkStocks',[StocksController::class,'checkStocks']);
Route::post('/scan/order',[StocksController::class,'checkOrders']);
Route::post('/checkBin',[StocksController::class,'checkBins']);
// Route::post('/check/pallete',[StocksController::class,'checkStocksPallete']);
// Route::post('/store/products',[StocksController::class,'storeProducts']);
Route::get('/getStocks/{id}',[StocksController::class,'getStocks']);
Route::get('/getBin/{id}',[StocksController::class,'getBin']);
Route::get('/orderType/{id}',[StocksController::class,'getOrderType']);

Route::post('/sign-in',[UsersController::class,'signIn']);
Route::post('/sign-out',[UsersController::class,'signOut']);

Route::view('/','login')->name('login')->middleware('guest');
Route::view('/home','dashboard')->name('home')->middleware('auth');

Route::get('/products',[ProductsController::class,'viewProducts'])->middleware('auth');

//Printing labels
Route::get('/palletlabels', [PDFController::class,'palletlabels'])->middleware('auth');
Route::get('/printlabels', [PDFController::class,'printlabels'])->middleware('auth');

// import products
Route::get('/file-import-export',[ProductsController::class,'fileImportExport']);
Route::post('/file-import',[ProductsController::class,'fileImport'])->name('file-import');
// customers
Route::resource('customers', CustomerController::class);

// orders
Route::get('/orders',[OrdersController::class,'viewOrders']);
Route::get('/createOrder',[OrdersController::class,'getCustomer'])->middleware('auth');
Route::post('/get-productList',[OrdersController::class,'productList'])->middleware('auth');
Route::post('/get-product',[OrdersController::class,'getProduct'])->middleware('auth');
Route::post('/save-order',[OrdersController::class,'addOrderIn'])->middleware('auth');
Route::post('/get-company-order',[OrdersController::class,'viewCompOrder']);
