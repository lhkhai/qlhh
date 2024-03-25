<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseInvoice;
use App\Models\PInvoiceDetail;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\WarehouseCard;

class ApiPurchaseInvoiceController extends Controller
{
    //
    public function StockIn(Request $request)
    {
        $currentmonth = date('m');
        $invoice = PurchaseInvoice::whereMonth('ngaynhap','=',$currentmonth)->get();
        $countinvoice = $invoice->count() + 1;
        $maphieunhap = "PN".date('y').date('m').$countinvoice;
        $idsupplier = $request->idsupplier;
        $kyhieuhd = $request->kyhieuhd;
        $sohoadon = $request->sohoadon;
        $ngaylap = $request->ngaylap;
        $vat = $request->vat;
        $ngaynhapkho =  $request->ngaynhapkho;
        $ghichu = $request->ghichu;
        $staff_id= $request->staff_id;
        $listproduct = $request->listproduct;
        $poid = $request->poid;
        
        //Create purchase invoices
        $data = ["maphieunhap"=>$maphieunhap,"mahdnhap"=>$kyhieuhd.$sohoadon,"kyhieuhdnhap"=>$kyhieuhd,
                "sohdnhap"=>$sohoadon,"ngayhdnhap"=>$ngaylap,"vat_hdnhap"=>$vat,"ngaynhap"=>$ngaynhapkho,
                "ghichu_pn"=>$ghichu,'maddh'=>$poid,"staff_id"=>$staff_id,"supplier_id"=>$idsupplier,
                "status"=>1];
        $createinvoice = PurchaseInvoice::create($data);
        $id_invoice = $createinvoice->id;
        if($createinvoice)
        {
            $PinvoiceDetail=null;
            for($i=0;$i<count($listproduct);$i++)
            {
                $idproduct = $listproduct[$i][0];
                $soluong = $listproduct[$i][1];
                $dongia = $listproduct[$i][2];
                $PinvoiceDetail = new PInvoiceDetail(['dongia'=>$dongia,'soluong'=>$soluong]);
                $PinvoiceDetail->Product()->associate(Product::find($idproduct));
                $PinvoiceDetail->PurchaseInvoice()->associate(PurchaseInvoice::find($id_invoice));
                $PinvoiceDetail->save();
                
                //Lưu soluong vào số lượng tồn của sản phẩm tương ứng;
                $product = Product::find($idproduct);
                $current_qty = $product->soluong;
                $update_qty=  $current_qty + $soluong;
                $product->soluong = $update_qty;
                $product->save();
                //Thêm vào thẻ kho          
                $tag = ['ngaythang'=>$ngaynhapkho,'noinhan'=>'Kho hàng','product_id'=>$idproduct,'maphieunhap'=>$id_invoice,'maphieuxuat'=>'',
                'slnhap'=>$soluong,'toncuoi'=>$update_qty];
                WarehouseCard::create($tag);

            }
            if($PinvoiceDetail){
                $purchaseorder = PurchaseOrder::find($poid);
                if($purchaseorder)
                {
                    $purchaseorder->status = 2;
                    $purchaseorder->save();
                }
                return response()->JSON(['message'=>"Lưu thành công!"],200);
            }
            else {//If creating the list fails, delete the imported invoice
                $purchaseinvoice = Purchaseinvoice::find($id_invoice);
                $purchaseinvoice->delete();
                return response()->JSON(['message'=>"Fails, cannot create purchase invoice !"],200);
            }
            
        }
        else {
            return response()->JSON(['message_code'=>402,
                                    'message'=>"#402 - Cannot create invoice!"]);
        }
        
        
    } 
    public function find($IDinvoice)
    {
       $listproduct = PInvoiceDetail::join('products','pinvoicedetails.product_id','products.id')->select('product_id','tensp','products.donvi',
                                        \DB::raw('SUM(pinvoicedetails.soluong) as soluong'),'pinvoicedetails.dongia')
                                        ->where('pinvoicedetails.invoice_id',$IDinvoice)
                                        ->groupBy('product_id','tensp','donvi','dongia')
                                        ->get();
        $findvat = PurchaseInvoice::find($IDinvoice);
        $vat = $findvat->vat_hdnhap;
        if($listproduct)
        {
            return response()->JSON(['message_code'=>200,'data'=>$listproduct,'vat'=>$vat],200);
        }
        else {
            return response()->JSON(['message_code'=>202,'message'=>"Not found!"],200);
        }
    }
}
