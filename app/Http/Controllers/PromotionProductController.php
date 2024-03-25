<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Models\Promotiontype;
class PromotionProductController extends Controller
{
    //
    public function index()
    {
        $promotiontype = Promotiontype::all();
        $promotion = Promotion::join('promotiontypes','promotions.promotiontype_id','promotiontypes.id')
                                ->join('staff','promotions.created_by','staff.id')->get();
        return view('promotion.promotion',with(['dataview'=>$promotion,'promotiontype'=>$promotiontype]));
    }
}
