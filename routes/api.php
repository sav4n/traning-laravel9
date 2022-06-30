<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return Auth()->user();
});
Route::get("/product",[ProductController::class,'index']);

Route::get("/product/{id}",[ProductController::class,'show']);

Route::middleware('auth:sanctum')->controller(ProductController::class)->group(function (){
    Route::post("/product",'create');
    Route::post("/product/{id}",'update');
    Route::delete("/product/{id}",'destroy');
});
