<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Staff;
class SaleInvoice extends Model
{
    use HasFactory;
    protected $table = 'saleinvoices';
    protected $fillable = ['maphieuxuat','mahdxuat','ngayxuat','tongthanhtien','ghichu_px','order_id','staff_id ','customer_id ','promotion_id','status'];
    public function Customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function Staff()
    {
        return $this->belongsTo(Staff::class,'staff_id');
    }

    public function Promotion()
    {
        return $this->belongsTo(Promotion::class,'promotion_id');
    }
}
