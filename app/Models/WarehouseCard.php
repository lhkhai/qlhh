<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseCard extends Model
{
    use HasFactory;
    protected $fillable =['ngaythang','noinhan','product_id','maphieuxuat','maphieunhap','slnhap','slxuat','toncuoi'];
    protected $table ='warehousecards';
}
