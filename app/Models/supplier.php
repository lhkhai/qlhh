<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class supplier extends Model
{
    use HasFactory;
    Protected $fillable = ['mancc','tenncc','diachincc','sdtncc','emailncc','ttthanhtoan','ghichu'];
   
}
