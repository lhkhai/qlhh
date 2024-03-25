<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    use HasFactory;
    protected $table = 'purchaseorderdetails';
    protected $fillable = ['order_id','product_id','dongia','soluong'];

    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Quan hệ với bảng purchase_orders
    public function PurchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'order_id');
    }
}
