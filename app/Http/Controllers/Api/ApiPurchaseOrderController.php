<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Product;
use Carbon\carbon;

class ApiPurchaseOrderController extends Controller
{
    public function getPurchaseOrderDetails(Request $request)
    {
        
    }
    public function order(Request $request)
    {
        $idsupplier = $request->idsupplier;
        $mancc = $request->mancc;
        $ngaydat = $request->ngaydat;
        $ngaygiao = $request->ngaygiao;
        $ghichu = $request->ghichu;
        $staff_id = $request->staff_id;
        $danhsach = $request->listproduct;        
        //Add order       
        $maddh = $mancc.Date('ymdHi');        
        $data = ['maddh'=>$maddh,
                'ngaydat'=>$ngaydat,
                'ngaygiao'=>$ngaygiao,
                'status'=>1,
                'staff_id'=>$staff_id,
                'supplier_id'=>$idsupplier,
                'ghichu'=>$ghichu];
        $AddOrder = PurchaseOrder::create($data);
        $idorder = $AddOrder->id;
        
       if($AddOrder){
           for ($i=0; $i<count($danhsach) ; $i++) { 
                $idproduct = $danhsach[$i][0];
                $dongia = $danhsach[$i][2];
                $soluong = $danhsach[$i][1];
                $orderdetails = new PurchaseOrderDetail(['dongia'=>$dongia,'soluong'=>$soluong]);
                $orderdetails->Product()->associate(Product::find($idproduct));
                $orderdetails->PurchaseOrder()->associate(PurchaseOrder::find($idorder));
                $orderdetails->save();          
            }
           return response()->json(['message_code'=>200,
                                    'message'=>"Đã thêm đơn hàng!"]);
        }/*
        else {
            return response()->json(['message_code'=>402,
                                    'message'=>'Lỗi không tạo được đơn hàng. Vui lòng liên hệ Admin!'],200);
        }*/
       
    }
}
