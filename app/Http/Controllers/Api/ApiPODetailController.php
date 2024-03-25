<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseOrderDetail;
use App\Models\PurchaseOrder;

class ApiPODetailController extends Controller
{
    //
    public function find($idpo)
    {
        $listproduct = PurchaseOrderDetail::join('products','purchaseorderdetails.product_id','products.id')->select('product_id','tensp','products.donvi',
                                                \DB::raw('SUM(purchaseorderdetails.soluong) as soluong'),'purchaseorderdetails.dongia')
        ->where('purchaseorderdetails.order_id',$idpo)
        ->groupBy('product_id','tensp','donvi','dongia')
        ->get();
        $donhang = PurchaseOrder::where('id',$idpo)->get();        
        $nhacungcap = $donhang->first()->supplier_id;
        $sodon = PurchaseOrder::where('supplier_id', $nhacungcap)->count();
        return response()->json(['message_code'=>200,'listproduct'=>$listproduct,'sodon'=>$sodon]);
    }
}
