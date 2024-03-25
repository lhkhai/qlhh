<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\supplier;
use App\models\PurchaseInvoice;
use App\models\product;
use App\Models\PurchaseOrderDetail;
use App\Models\PurchaseOrder;
class PurchaseInvoiceController extends Controller
{
    //
    public function index($idpo=null)
    {
        $supplier = supplier::all();
        $product = product::all();
        if(!empty($idpo))
        {
            $idpo = $idpo;
            $donhang = PurchaseOrder::find($idpo);   
            $nhacungcap = $donhang->supplier_id;
            $status = $donhang->status;
            if($status == 1)
            {
                $listproduct = PurchaseOrderDetail::join('products','purchaseorderdetails.product_id','products.id')
                                                    ->select('product_id','masp','tensp','products.donvi','chatlieu',
                                                    \DB::raw('SUM(purchaseorderdetails.soluong) as soluong'),'purchaseorderdetails.dongia')
                ->where('purchaseorderdetails.order_id',$idpo)
                ->groupBy('product_id','masp','tensp','chatlieu','donvi','dongia')
                ->get();
            }
            else
            { $listproduct = null;}
        
        }
        else {$idpo = "";
            $listproduct='';
            $nhacungcap='';
        }
        return view('/PurchaseInvoice/purchaseinvoice')->with(['supplier'=>$supplier,'product'=>$product,'listproduct'=>$listproduct,'nhacungcap'=>$nhacungcap,'idpo'=>$idpo]);
    }
    
}
