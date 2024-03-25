<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $fillable = ['manhom','tennhom','diengiai'];

    public function product()
    {
       // return $this->hasMany(product::class,'categories_id');
    }
}
