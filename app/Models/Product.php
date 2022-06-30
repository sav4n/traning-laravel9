<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory;
    protected  $fillable = [
    "name",
    "SKU"];

    // public $attributes=
    // ["name"=>"name"];
    // public function cats(): Attribute{
    //  return new Attribute(
    //     get: function(){
    //         return explode(",",$this->SKU);
    //   });
    // }
    
}
