<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StocksController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::view('/scan', 'scan');
Route::post('/checkStocks',[StocksController::class,'checkStocks']);
Route::post('/check/pallete',[StocksController::class,'checkStocksPallete']);
Route::post('/store/products',[StocksController::class,'storeProducts']);
Route::view('/login','login');
