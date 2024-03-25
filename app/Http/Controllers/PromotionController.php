<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Models\Promotiontype;
use App\Models\Product;
class PromotionController extends Controller
{
    //
    public function index()
    {
        $promotiontype = Promotiontype::all();
        $products = Product::all();
        $promotion = Promotion::join('promotiontypes','promotions.promotiontype_id','promotiontypes.id')
                                ->join('staff','promotions.created_by','staff.id')->get();
        return view('promotion.promotion',with(['dataview'=>$promotion,'promotiontype'=>$promotiontype,'products'=>$products]));
    }
}
