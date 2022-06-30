<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Jobs\test;
use App\Models\User;
use App\Events\played;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create  something great!
|
*/


Route::get('/job', function () {
        info("hit");
        App\Jobs\test::dispatch();
        return "work?";
});
Route::get('/', function () {
    // Mail::to(null)->send(new App\Mail\test());
    $user = User::find(2);
    // Auth::login($user);
    // dd($user);
    $token = $user->createToken("login");
 
    return ['token' => $token->plainTextToken];
    // return view("home");
});
Route::post('/played', function (Request $data) {
    event(new played($data->pos));
    return $data->pos;
})->name("playground");
Route::get('/p1', function () {
    // event(new played("test"));
    return view("p1");
});
Route::get('/p2', function () {
   return view("p2");
});

//select * from `products` where CONCAT(",", SKU , ",") REGEXP ",("+(select REPLACE(SKU,",""|") FROM products where id = 2)+")," and id <> 2;

    // $subQuery = \DB::table('products')->selectRaw('id,REPLACE(SKU,",","|") as reg_sku')->where('id',2)->first();
    // $Products = DB::table('products')->whereRaw('CONCAT(",", SKU , ",") REGEXP ",('.$subQuery->reg_sku.'),"')->whereNot("id",$subQuery->id)->get();
    
    // $subQuery = Product::find(2)->cats;
    // $Products = DB::table('products')->selectRaw('CONCAT(",", SKU , ",") REGEXP ",('.$subQuery->reg_sku.'),"')->whereNot("id",$subQuery->id)->get();

    // return ddd($Products);
    // return view('welcome');
// });
