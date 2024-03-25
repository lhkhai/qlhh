<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion_product extends Model
{
    use HasFactory;
    public $fillable = ['promotion_id','product_id','mucgiam','soluongapdung'];

    public function Promotion()
    {
        return $this->belongsTo(Promotion::class,'promotion_id');
    }

    public function Product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
