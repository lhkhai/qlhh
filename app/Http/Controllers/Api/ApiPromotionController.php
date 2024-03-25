<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;
class ApiPromotionController extends Controller
{
    public function clopen($id)
    {
        $promotion = Promotion::find($id);
        if($promotion->trangthai ==1 )
        {
            $promotion->trangthai=0;
        }
        else {
            $promotion->trangthai=1;
        }
        $promotion->save();
        $promotion = Promotion::join('promotiontypes','promotions.promotiontype_id','promotiontypes.id')
        ->join('staff','promotions.created_by','staff.id')->get();
       
        return response()->json(["message"=>"successfull",'data'=>$promotion]);
    }
}
