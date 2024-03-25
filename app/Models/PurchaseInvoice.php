<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;
    protected $table = 'purchaseinvoices';
    protected $fillable = ["maphieunhap","mahdnhap","kyhieuhdnhap","sohdnhap","ngayhdnhap","vat_hdnhap","ngaynhap",
    "ghichu_pn","maddh","staff_id","supplier_id","status"];
    
}
