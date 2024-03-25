<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable = ['masp','tensp','chatlieu','kichthuoc','soluong','giaban','hinhanh','mota','spmoi','spnoibat'];
    
    public function categories()
    {
       // return $this->belongsTo(categories::class);
    }
}
