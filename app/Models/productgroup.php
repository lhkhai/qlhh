<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productgroup extends Model
{
    use HasFactory;
    protected $fillable = ['manhom','tennhom','diengiai'];
}
