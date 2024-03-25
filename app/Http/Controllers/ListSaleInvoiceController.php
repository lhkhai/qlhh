<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Saleinvoice;
use App\Models\Staff;

class ListSaleInvoiceController extends Controller
{
    //
    public function index(Request $request)
    {
        $perPage = $request->input('perpage',10);
        $search = $request->input('search');
        $staffs= Staff::All();
        if(!empty($search))
        {
            $data = explode(',',$search[0]);
            $search = $data;                        //gán dữ liệu lại cho biến search trả về
            $query = $this->search($data);          //gọi hàm tìm kiếm
            $dataview = $query->join('staff','saleinvoices.staff_id','staff.id')
                                ->join('customers','saleinvoices.customer_id','customers.id')
                                ->select('saleinvoices.id','saleinvoices.maphieuxuat',
                                        'saleinvoices.tongthanhtien','saleinvoices.ngayxuat',
                                        'customers.id as idcustomer','customers.makh','customers.tenkh',
                                        'staff.hoten as nhanvien')
                                ->orderBy('saleinvoices.ngayxuat','DESC')
                                ->paginate($perPage);
                                return view('sales.listsaleinvoice')->with(['dataview'=>$dataview,'perPage'=>$perPage,
                                                                            'search'=>$search,'current_url'=>'listsaleinvoice',
                                                                            'staffs'=>$staffs]); 
        }
        else
        {
           
            $dataview = Saleinvoice::join('customers','saleinvoices.customer_id','customers.id')
                                        ->join('staff','saleinvoices.staff_id','staff.id')
                                        ->select('saleinvoices.id','saleinvoices.maphieuxuat',
                                            'saleinvoices.tongthanhtien','saleinvoices.ngayxuat','customers.id as idcustomer','customers.makh','customers.tenkh','staff.hoten as nhanvien')
                                        ->orderBy('saleinvoices.ngayxuat','DESC')
                                        ->paginate($perPage);
        return view('sales.listsaleinvoice',with(['dataview'=>$dataview,'perPage'=>$perPage,'staffs'=>$staffs]));
        }
        
    }

    public function searchSaleInvoice(Request $request)
    {
        $staffs= Staff::All();
        $perPage = $request->input('perpage',10);
        $mahd = $request->input('input_search_mahd');
        $tenkh = $request->input('input_search_tenkh');
        $idnhanvien = $request->input('input_search_idnhanvien');
        $tungay = $request->input('input_search_tungay');
        $denngay = $request->input('input_search_denngay');
        if(empty($mahd) && empty($tenkh) && empty($idnhanvien) && empty($tungay) && empty($denngay))
        {
            return redirect('listsaleinvoice');
        }
        $data = array($mahd,$tenkh,$idnhanvien,$tungay,$denngay);
        $query = $this->search($data);
        $dataview = $query->join('staff','saleinvoices.staff_id','staff.id')
                            ->join('customers','saleinvoices.customer_id','customers.id')                    
                                ->select('saleinvoices.id','saleinvoices.maphieuxuat',
                                        'saleinvoices.tongthanhtien','saleinvoices.ngayxuat',
                                        'customers.id as idcustomer','customers.makh','customers.tenkh',
                                        'staff.hoten as nhanvien')
                                ->orderBy('saleinvoices.ngayxuat','DESC')
                                ->paginate($perPage);
        $search = $data;
        return view('sales.listsaleinvoice')->with(['dataview'=>$dataview,'perPage'=>$perPage,'search'=>$search,'current_url'=>'listsaleinvoice','staffs'=>$staffs]);
       
    }
    public function search($data)
    {
        $mahd = $data[0];
        $tenkh = $data[1];
        $idnhanvien = $data[2];
        $tungay = date('Y-m-d H:i:s',strtotime($data[3]));
        $denngay = date('Y-m-d H:i:s',strtotime($data[4]." 23:59:59"));
        $query = Saleinvoice::query();

        if(!empty($mahd))
        {
            $query->where('maphieuxuat','LIKE','%'.$mahd.'%');
        }
        if(!empty($tenkh))
        {
            $query->where(function ($q) use ($tenkh){   //join('customers','saleinvoices.customer_id','customers.id')
                    
                return $q->where('tenkh','LIKE','%'.$tenkh.'%');
            });
        }
        if(!empty($idnhanvien))
        {
            $query->where(function ($q) use ($idnhanvien){
                return $q->where('customer_id',$idnhanvien);
            });
        }
       
            if(empty($tungay))
            {
                $query->where(function ($q) use ($denngay){
                    return $q->where('ngayxuat','<=',$denngay);
                });  
            }
            if(empty($denngay))
            {
                $query->where(function ($q) use ($tungay){
                    return $q->where('ngayxuat','>=',$tungay);
                });  
            }
            if(!empty($tungay) && !empty($denngay)){
            $query->where(function ($q) use ($tungay,$denngay){
                return $q->where('ngayxuat','>=',$tungay)
                            ->where('ngayxuat','<=',$denngay);
                        });
             }
            if(!empty($tungay) && !empty($denngay) && $tungay==$denngay){
                $query->where(function ($q) use ($tungay){
                    return $q->where('ngayxuat','=',$tungay);
                });
                }
      
        return $query;
    }
}
