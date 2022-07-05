<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ReportsController;

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
Route::view('/home/scan-in','/scan/scanIn')->middleware('auth');
Route::view('/home/scan-out','/scan/scanOut')->middleware('auth');
Route::view('/home/transfer', '/scan/scanTransfer')->middleware('auth');
// scanIn products
Route::get('/home/scan-in/products',[StocksController::class,'scanProducts'])->middleware('auth');
Route::post('/home/scan-in/check-product',[StocksController::class,'checkProduct'])->middleware('auth');
Route::post('/home/scan-in/scan-products',[StocksController::class,'addProducts'])->middleware('auth');
// scanIn pallets
Route::get('/home/scan-in/pallets',[StocksController::class,'scanPallets'])->middleware('auth');
Route::post('/home/scan-in/check-pallet',[StocksController::class,'checkPallet'])->middleware('auth');
Route::post('/home/scan-in/add-pallet',[StocksController::class,'addPallet'])->middleware('auth');
Route::post('/home/scan-in/check-location',[StocksController::class,'checkLocation'])->middleware('auth');
// scanIn AddtoPallet
Route::get('/home/scan-in/addtopallet',[StocksController::class,'viewAdd2pallet'])->middleware('auth');
Route::post('/home/scan-in/checkStockPallet',[StocksController::class,'getPallet'])->middleware('auth');
Route::post('/home/scan-in/prodtopallet',[StocksController::class,'prodToPallet'])->middleware('auth');
// scanOut
Route::get('/home/scan-out/pallets',[StocksController::class,'viewPalletOut'])->middleware('auth');
Route::get('/home/scan-out/products',[StocksController::class,'viewProductOut'])->middleware('auth');
Route::get('/home/scan-out/orders',[StocksController::class,'viewOrderOut'])->middleware('auth');
// scanOut Pallet
Route::post('/home/scan-out/getPallet',[StocksController::class,'getPallet'])->middleware('auth');
Route::post('/home/scan-out/palletOut',[StocksController::class,'palletOut'])->middleware('auth');
// scanOut Product
Route::post('/home/scan-out/checkStock',[StocksController::class,'checkStockProduct'])->middleware('auth');
Route::post('/home/scan-out/checkOutProduct',[StocksController::class,'orderProductOut'])->middleware('auth');
// scanOut Order
Route::get('/home/scan-out/getOrder/{id}',[StocksController::class,'getOrder'])->middleware('auth');
Route::post('/home/scan-out/orderProd',[StocksController::class,'addProdToOrder'])->middleware('auth');
// Transfer
Route::get('/home/transfer/products',[StocksController::class,'findProduct'])->middleware('auth');
Route::get('/home/transfer/pallets',[StocksController::class,'findPallet'])->middleware('auth');
Route::get('/home/transfer/merge',[StocksController::class,'viewMerge'])->middleware('auth');
Route::post('/home/transfer/product-check',[StocksController::class,'trnsfrProdChck'])->middleware('auth');
Route::post('/home/transfer/save-toNewPallet',[StocksController::class,'trnsfrProdNewPallet'])->middleware('auth');
Route::post('/home/transfer/save-toExistPallet',[StocksController::class,'trsnfrProdExistPallet'])->middleware('auth');
Route::post('/home/transfer/pallet-check',[StocksController::class,'trnsfrPalltChck'])->middleware('auth');
Route::post('/home/transfer/location-check',[StocksController::class,'trnsfrLocChck'])->middleware('auth');
Route::post('/home/transfer/save-transfer',[StocksController::class,'trnsfrSave'])->middleware('auth');
Route::post('/home/transfer/merge-check',[StocksController::class,'PalletCheck'])->middleware('auth');
Route::post('/home/transfer/merge-save',[StocksController::class,'saveMerge'])->middleware('auth');
// Stock Take
Route::get('/home/stock-take',[StocksController::class,'viewStockTake'])->middleware('auth');
Route::post('/home/stock-take/checkPallet',[StocksController::class,'stkPalletCheck'])->middleware('auth');
Route::post('/home/stock-take/checkProduct',[StocksController::class,'stkProductCheck'])->middleware('auth');
Route::post('/home/stock-take/saveProducts',[StocksController::class,'stkUpdatePallet'])->middleware('auth');
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
Route::get('/stocks',[StocksController::class,'viewStocks'])->middleware('auth');
Route::post('/stocks/search-stocks',[StocksController::class,'searchStocks'])->middleware('auth');
Route::post('/stocks/print-stock',[StocksController::class,'printStock'])->middleware('auth');
Route::get('/stocks/viewProduct/{id}',[StocksController::class,'viewStockProducts'])->middleware('auth');
Route::get('/stocks/viewProductby/{id}',[StocksController::class,'viewProductby'])->middleware('auth');

//Printing labels
Route::get('/palletlabels', [PDFController::class,'palletlabels'])->middleware('auth');
Route::get('/printlabels', [PDFController::class,'printlabels'])->middleware('auth');

// invoice
Route::get('/print-invoice',[PDFController::class,'printinvoice'])->middleware('auth');

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

// reports
Route::get('/reports/stock-summary',[ReportsController::class,'stockSummary'])->middleware('auth');
