<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $table ='purchaseorders';
    protected $fillable= ['maddh','ngaydat','ngaygiao','status','staff_id','supplier_id','ghichu'];
}
