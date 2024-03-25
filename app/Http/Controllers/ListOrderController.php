<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrderDetail;
use App\Models\PurchaseOrder;

class ListOrderController extends Controller
{
    //
    public function index(Request $request)
    {
        $perPage = $request->input('perpage',10); //get $perPage form selection, divPagination.php
        $search = $request->input('search');
        if(!empty($search))
        {
            $data = explode(',',$search[0]);
            $search = $data;
            $query = $this->search($data);
            $dataview = $query->join('suppliers', 'purchaseorders.supplier_id', '=', 'suppliers.id')
                                ->where('purchaseorders.status', '=', 1) // Chú ý thêm dấu '=' để so sánh chính xác
                                ->select('maddh', 'purchaseorders.id as IdPO', 'purchaseorders.ghichu as noteorder', 'purchaseorders.*', 'tenncc')
                                ->paginate($perPage);
                                return view('/PurchaseOrder.listorder')->with(['dataview'=>$dataview,'perPage'=>$perPage,'search'=>$search,'current_url'=>'listorder']); 
        }
        else {             
            
        $listorder = \DB::table('PurchaseOrders')->join('Suppliers','PurchaseOrders.supplier_id','=','Suppliers.id')
                                            ->select(['PurchaseOrders.ghichu as noteorder','PurchaseOrders.id as IdPO','PurchaseOrders.*','Suppliers.*'])->paginate($perPage);        
        return view('PurchaseOrder.listorder')->with(['dataview'=>$listorder,'perPage'=>$perPage]);
        }
    }
    public function searchPO(Request $request)
    {
        $perPage = $request->input('perpage',10);
        $maddh = $request->input('input_search_maddh');
        $tenncc = $request->input('input_search_tenncc');
        $ngaydat = $request->input('input_search_ngaydat');
        $ngaygiao = $request->input('input_search_ngaygiao');
        $trangthai = $request->input('input_search_trangthai');
        if(empty($maddh) && empty($tenncc) && empty($ngaydat) && empty($ngaygiao) && empty($trangthai))
        {
            return redirect('listorder');
        }
        $data = array($maddh,$tenncc,$ngaydat,$ngaygiao,$trangthai);
        $query = $this->search($data);
        $dataview = $query->join('suppliers','purchaseorders.supplier_id','suppliers.id')
                                ->select('maddh','PurchaseOrders.id as IdPO','purchaseorders.ghichu as noteorder','purchaseorders.*','tenncc')
                                ->paginate($perPage);
        $search = $data;
        return view('/PurchaseOrder.listorder')->with(['dataview'=>$dataview,'perPage'=>$perPage,'search'=>$search,'current_url'=>'listorder']); 
       
    }
    public function search($data)
    {
        $maddh =$data[0];
        $tenncc =$data[1]; 
        $nvbh =$data[2];
        $ngaydat =$data[3];
        $ngaygiao = $data[4];
        $query = PurchaseOrder::query();
        if(!empty($maddh))
        {
            $query->where('maddh','LIKE',"%".$maddh."%");
        }
        if(!empty($tenncc))
        {
            $query->where(function ($q) use ($tenncc){
                    return $q->where('tenncc','LIKE','%'.$tenncc.'%');
            });
        }
        if(!empty($ngaydat))
        {
            $query->where(function ($q) use ($ngaydat){
                return $q->where('ngaydat','>=',$ngaydat);
            });
        }
        if(!empty($ngaygiao))
        {
            $query->where(function ($q) use ($ngaygiao){
                return $q->where('ngaydat','>=',$ngaygiao);
            });
        }
        if(!empty($trangthai))
        {
            $query->where(function ($q) use ($trangthai){
                return $q->where('status','=',$trangthai);
            });
        }
        return $query;      
        
    }

}
