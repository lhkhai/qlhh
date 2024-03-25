<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PInvoiceDetail extends Model
{
    use HasFactory;
    protected $table = 'pinvoicedetails';
    protected $fillable = ['invoice_id','product_id','dongia','soluong'];
    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function PurchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class, 'invoice_id');
    }
}
