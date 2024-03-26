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
        $dataview = Promotion::join('promotiontypes','promotions.promotiontype_id','promotiontypes.id')
                                ->join('staff','promotions.created_by','staff.id')->get();        
        return view('promotion.promotion', compact('dataview', 'promotiontype', 'products'));
        
    }
    public function addpromotion(Request $request)
    {
       $loaikm = $request->txtloaikm;
       $mactkm = $request->txtmactkm;
       $tenctkm = $request->txttenctkm;
       $ngaybd = $request->txtngaybd;
       $ngaykt = $request->txtngaykt;
       $trangthai = $request->txttrangthai;
       if($request->exists('inputmasp'))
       {
        $masp = $request->inputmasp;
       }
       
       $total_invoice = $request->inputtongtienhd;
       $discount = $request->inputsotiengiam;
       
      var_dump($trangthai);
       //return redirect('promotion')->with(['message'=>$var1]);
    
    }
}
