<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
class ProductController extends Controller
{
    public function index(){
        return Product::all();
    }

    public function show(Product $id){
        return $id;
    }

    public function create(ProductRequest $request){

        return Product::create(["name"=>$request->name,"SKU"=>$request->SKU]) ? ['message'=>"Deleted Succsessfuly"] : ['message'=>"Ops invalid Input"];
    }

    public function update(Product $id,ProductRequest $request){
        return $id->update([
        "name"=>$request->name,
        "SKU"=>$request->SKU,
        ]) == true ? ['message'=>"updated Succsessfuly"] : ['message'=>"Ops invalid Input"];
    }

    public function destroy(Product $id){
        return $id->delete() == true ? ['message'=>"Deleted Succsessfuly"] : ['message'=>"Ops invalid Input"];
    }

}
