<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaleInvoice;
use App\Models\Customer;
use App\models\Promotion;
use App\models\Promotion_Invoice;
use App\models\Saleinvoicedetail;
use App\Models\Product;
use App\Models\WarehouseCard;
use App\Models\Staff;

class ApiSaleInvoiceController extends Controller
{
    public function payments(Request $request)
    {
        $idcustomer = $request->idcustomer; 
        $makh = $request->makh;
        $tenkh = $request->tenkh;
        $diachi =  $request->diachi;
        $email = $request->email;
        $sdt = $request->sdt;
        $order_id = $request->order_id;
        $staff_id = $request->staff_id;
        $listproduct = $request->listproduct;
        $tongthanhtien =$request->tongthanhtien;
        //Thêm khách hàng nếu là khách hàng mới
        $diemtichluy = floor($tongthanhtien/100000);        
        if($idcustomer =='')
        {
           $datacustomer = [
                "makh"=> $makh,
                "tenkh"=> $tenkh,
                "diachi"=> $diachi,
                "sdt"=> $sdt,
                "email"=> $email,
                "diemtichluy"=>$diemtichluy
            ];
            $CreateCustomer = Customer::create($datacustomer);
            $idcustomer = $CreateCustomer->id;
        }
        else {
            $customer = Customer::find($idcustomer);
            $current_score = $customer->diemtichluy;
            $new_score = $current_score + $diemtichluy;
            $customer->diemtichluy = $new_score;
            $customer->save();
        }        
        //Tạo mã phiếu xuất
        $saleinvoie = SaleInvoice::all();
            //Tạo mã phiếu xuất
            $sodon = $saleinvoie->count() + 1;
            $fmsodon = sprintf('%04d',$sodon);
            $ngaythang = date("ymd");
        $mapx = 'PX'.$ngaythang.$fmsodon;
        $ngayxuat = date('Y-m-d H:i:s');
        $data = ['maphieuxuat'=> $mapx,
                'ngayxuat'=>$ngayxuat,
                'tongthanhtien'=>$tongthanhtien,
                'order_id'=>$order_id,                
                'staff_id'=>$staff_id];  
       
        $SInvoice = Saleinvoice::create($data);
        $khuyenmai = $this->CheckPromo_invoice($tongthanhtien); //Kiểm tra khuyến mãi trên giá trị hóa đơn
        if($khuyenmai!=null)
        {
           $idpromo= $khuyenmai['idpromotion'];
           $SInvoice->Promotion()->associate(Promotion::find($idpromo));           
        }
        
        $SInvoice->Customer()->associate(Customer::find($idcustomer));
        $SInvoice->Staff()->associate(Staff::find($staff_id));        
        $SInvoice->save();  
        //Tạo chi tiết phiếu xuất
        $invoice_id =  $SInvoice->id;
        $currentday = date('y-m-d H:i:s');
        for($i=0;$i<count($listproduct);$i++)
        {   $soluong = $listproduct[$i][1];
            $dongia = $listproduct[$i][2];
            $idproduct = $listproduct[$i][0];
            $saleinvoiedetail = new Saleinvoicedetail(['soluong'=>$soluong,'dongia'=>$dongia]);
            $saleinvoiedetail->Product()->associate(Product::find($idproduct));
            $saleinvoiedetail->Saleinvoice()->associate(Saleinvoice::find($invoice_id));
            $saleinvoiedetail->save();
            //trừ tồn kho
            $product = Product::find($idproduct);
            $product->soluong -= $soluong;
            $product->save();
            $toncuoi = $product->soluong;
            //Ghi thẻ kho
            $data = ['ngaythang'=>$currentday,
                    'noinhan'=>$idcustomer,
                    'product_id'=>$idproduct,
                    'maphieuxuat'=>$invoice_id,
                    'slxuat'=>$soluong,
                    'toncuoi'=>$toncuoi];
            WarehouseCard::create($data);
                       
        }
        $saleinvoiedetail = Saleinvoicedetail::join('products','saleinvoicedetails.product_id','products.id')
                                    ->select('saleinvoicedetails.*','products.tensp as tensp')
                                    ->where('saleinvoicedetails.saleinvoice_id',$invoice_id)
                                    ->get();
        $customer = Customer::find($idcustomer);
        $saleinvoice = Saleinvoice::find($invoice_id);                          
        return response()->JSON(['message'=>'Thành công',
                                'saleinvoiedetail'=>$saleinvoiedetail,
                                'customer'=>$customer,
                                'saleinvoice'=>$saleinvoice]);
        
       
    }
    public function CheckPromo_invoice($sotien)
    {
        $currentday = date('Y-m-d H:i:s');
        $check = Promotion::join('promotion_invoices','promotions.promotion_invoice_id','promotion_invoices.id')->where('trangthai',1)->where('ngaybd','<=',$currentday)
                            ->where('ngaykt','>=',$currentday)
                            ->where('hanmuc','<=',$sotien)->first();
        
        if($check){
            $sotiengiam = $check->sotiengiam;
            $idpromotion = Promotion::find($check->id);
            return ['idpromotion'=>$idpromotion->id,'sotiengiam'=>$sotiengiam];
        }
        else {
            return null;
        }
        
    }
    public function checkpromotion()
    {
        $currentday = date('Y-m-d H:i:s');
        $check = Promotion::where('trangthai',1)->where('ngaybd','<=',$currentday)
                            ->where('ngaykt','>=',$currentday)->first();
        if($check){
            $idkm=$check->promotion_invoice_id;
            $pro_inv=Promotion_Invoice::find($idkm);
            $hanmuc=$pro_inv->hanmuc;
            $sotiengiam=$pro_inv->sotiengiam;     
            return response()->json(['hanmuc'=>$hanmuc,'sotiengiam'=>$sotiengiam]);           
            
        }

        else {
            return response()->json(['hanmuc'=>0,'sotiengiam'=>0]);  
        }
        
    }

    public function printsaleinvoice($idcustomer,$idsaleinvoice)
    {
        $customer = Customer::find($idcustomer);
        
        $saleinvoice = Saleinvoice::find($idsaleinvoice);
        
        $saleinvoiedetail = Saleinvoicedetail::join('saleinvoices','saleinvoicedetails.saleinvoice_id','saleinvoices.id')
                                                ->join('products','saleinvoicedetails.product_id','products.id')
                                                ->select('saleinvoicedetails.*','saleinvoicedetails.soluong as soluongban','products.*')
                                                ->where('saleinvoicedetails.saleinvoice_id',$idsaleinvoice)
                                                 ->get();
        $check_id_promotion = $saleinvoice->promotion_id;
        if($check_id_promotion==null)
        {
            $khuyenmai=0;
        }
        else {
            $promotion = Promotion::find($saleinvoice->promotion_id); //tim id promotion thông qua idsaleinvoie
            $promo_invoice = Promotion_Invoice::find($promotion->promotion_invoice_id);
            if($promo_invoice)
            {
                $khuyenmai = $promo_invoice->sotiengiam;
            } 
        }
        
        return response()->json(['message_code'=>200,
                                'customer'=>$customer,
                                'saleinvoicedetail'=>$saleinvoiedetail,
                                'saleinvoice'=> $saleinvoice,
                                'khuyenmai'=>$khuyenmai
                                ]);
    }
}

