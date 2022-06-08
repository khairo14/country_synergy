<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\LocationsController;
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

Route::post('/sign-in',[UsersController::class,'signIn']);
Route::get('/sign-out',[UsersController::class,'signOut']);
Route::view('/','login')->name('login')->middleware('guest');
Route::view('/home','dashboard')->name('home')->middleware('auth')->name('home');

// dashboard
Route::view('/home/scan','/scan/scanIn')->middleware('auth');
Route::view('/home/scan-out','/scan/scanOut')->middleware('auth');
// scanIn products
Route::get('/home/scan/products',[StocksController::class,'scanProducts'])->middleware('auth');
Route::post('/home/scan/check-product',[StocksController::class,'checkProduct'])->middleware('auth');
Route::post('/home/scan/scan-products',[StocksController::class,'addProducts'])->middleware('auth');
// scanIn pallets
Route::get('/home/scan/pallets',[StocksController::class,'scanPallets'])->middleware('auth');
Route::post('/home/scan/check-pallet',[StocksController::class,'checkPallet'])->middleware('auth');
Route::post('/home/scan/add-pallet',[StocksController::class,'addPallet'])->middleware('auth');
Route::post('/home/scan/check-location',[StocksController::class,'checkLocation'])->middleware('auth');
// scanIn AddtoPallet
Route::get('/home/scan/addtopallet',[StocksController::class,'viewAdd2pallet'])->middleware('auth');
Route::post('/home/scan/checkStockPallet',[StocksController::class,'getPallet'])->middleware('auth');
Route::post('/home/scan/prodtopallet',[StocksController::class,'prodToPallet'])->middleware('auth');
// scanOut
Route::get('/home/scan-out/pallets',[StocksController::class,'viewPalletOut'])->middleware('auth');
Route::get('/home/scan-out/products',[StocksController::class,'viewProductOut'])->middleware('auth');
Route::get('/home/scan-out/orders',[StocksController::class,'viewOrderOut'])->middleware('auth');

// scanOut Pallet
Route::post('/home/scan-out/getPallet',[StocksController::class,'getPallet'])->middleware('auth');
Route::post('/home/scan-out/palletOut',[StocksController::class,'palletOut'])->middleware('auth');
// Route::post('/home/scan-out/print',[StocksController::class,'printDocket'])->middleware('auth');

// scanOut Product
Route::post('/home/scan-out/checkStock',[StocksController::class,'checkStockProduct'])->middleware('auth');
Route::post('/home/scan-out/checkOutProduct',[StocksController::class,'orderProductOut'])->middleware('auth');
// Route::view('/printDocket','./print/printDocket');

// scanOut Order
Route::get('/home/scan-out/getOrder/{id}',[StocksController::class,'getOrder'])->middleware('auth');
Route::post('/home/scan-out/orderProd',[StocksController::class,'addProdToOrder'])->middleware('auth');

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

// stocks
Route::get('/stocks',[StocksController::class,'viewStocks']);
Route::post('/stocks/search-stocks',[StocksController::class,'searchStocks'])->middleware('auth');
Route::post('/stocks/print-stock',[StocksController::class,'printStock'])->middleware('auth');
Route::post('/stocks/products-from-pallet',[StocksController::class,'viewStockProducts'])->middleware('auth');
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
Route::get('/palletlabels', [PDFController::class,'palletlabels'])->middleware('auth');
Route::get('/printlabels', [PDFController::class,'printlabels'])->middleware('auth');

// import products
// Route::get('/file-import-export',[ProductsController::class,'fileImportExport']);
// Route::post('/file-import',[ProductsController::class,'fileImport'])->name('file-import');

// customers
Route::resource('/customers', CustomersController::class);

// orders
Route::get('/view-orders',[OrdersController::class,'viewOrders']);
Route::get('/create-order',[OrdersController::class,'viewCreate'])->middleware('auth');
Route::get('/orders/get-order/{id}',[OrdersController::class,'getOrderStock'])->middleware('auth');
Route::get('/orders/get-product/{id}',[OrdersController::class,'getProduct'])->middleware('auth');
Route::post('/orders/add-order',[OrdersController::class,'addOrder'])->middleware('auth');
// Route::post('/get-productList',[OrdersController::class,'productList'])->middleware('auth');
// Route::post('/get-product',[OrdersController::class,'getProduct'])->middleware('auth');
// Route::post('/save-order',[OrdersController::class,'addOrderIn'])->middleware('auth');
// Route::post('/get-company-order',[OrdersController::class,'viewCompOrder']);
// stocks
