<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Saleinvoice;

class Saleinvoicedetail extends Model
{
    use HasFactory;
    protected $fillable = ['saleinvoice_id','product_id','soluong','dongia'];
    public function Product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function Saleinvoice()
    {
        return $this->belongsTo(Saleinvoice::class,'saleinvoice_id');
    }
}
