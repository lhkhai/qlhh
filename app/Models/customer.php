<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
    Protected $fillable = ['makh','tenkh','diachi','sdt','email','diemtichluy','ghichu'];
}
