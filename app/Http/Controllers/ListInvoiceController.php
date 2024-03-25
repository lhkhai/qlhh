<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseInvoice;
use App\Models\PInvoiceDetail;
class ListInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perpage',10); //get $perPage form selection, divPagination.php
        $search = $request->input('search');
        if(!empty($search))
        {
            $data = explode(',',$search[0]);
            $search = $data;
            $query = $this->search($data);
            $dataview = $query->join('Suppliers','PurchaseInvoices.supplier_id','=','Suppliers.id')
                                ->select(['PurchaseInvoices.*','PurchaseInvoices.id as IDinvoice','Suppliers.*','Suppliers.id as idsupplier'])->paginate($perPage); 
            return view('/PurchaseInvoice.listinvoice')->with(['dataview'=>$dataview,'perPage'=>$perPage,'search'=>$search,'current_url'=>'listinvoice']); 
        }
        else {             
            
        $listinvoice = \DB::table('PurchaseInvoices')->join('Suppliers','PurchaseInvoices.supplier_id','=','Suppliers.id')
                                            ->select(['PurchaseInvoices.*','PurchaseInvoices.id as IDinvoice','Suppliers.*','Suppliers.id as idsupplier'])->paginate($perPage);        
        return view('PurchaseInvoice.listinvoice')->with(['dataview'=>$listinvoice,'perPage'=>$perPage,]);
        }
    }
    public function searchPI(Request $request)
    {
        $perPage = $request->input('perpage',10);
        $mapn = $request->input('input_search_mapn');
        $sohd = $request->input('input_search_sohd');
        $tenncc = $request->input('input_search_tenncc');
        $ngaynhap1 = $request->input('input_search_ngaynhap1');
        $ngaynhap2 = $request->input('input_search_ngaynhap2');        
        if(empty($mapn) && empty($tenncc) && empty($ngaynhap1) && empty($ngaynhap2) && empty($sohd))
        {
            return redirect('listinvoice');
        }
        $data = array($mapn,$sohd,$tenncc,$ngaynhap1,$ngaynhap2);
        $query = $this->search($data);
        $dataview = $query->join('Suppliers','PurchaseInvoices.supplier_id','=','Suppliers.id')
                                ->select(['PurchaseInvoices.*','PurchaseInvoices.id as IDinvoice','Suppliers.*','Suppliers.id as idsupplier'])
                                ->paginate($perPage);
        $search = $data;
        return view('/PurchaseInvoice.listinvoice')->with(['dataview'=>$dataview,'perPage'=>$perPage,'search'=>$search,'current_url'=>'listinvoice']); 
        
    }
    public function search($data)
    {
        $mapn =$data[0];
        $sohd =$data[1]; 
        $tenncc =$data[2];
        $ngaynhap1 =$data[3];
        $ngaynhap2 = $data[4];
        $query = PurchaseInvoice::query();
        if(!empty($mapn))
        {
            $query->where('maphieunhap','LIKE',"%".$mapn."%");
        }
        if(!empty($sohd))
        {
            $query->where('sohdnhap','LIKE',"%".$sohd."%");
        }
        if(!empty($tenncc))
        {
            $query->where(function ($q) use ($tenncc){
                    return $q->where('tenncc','LIKE','%'.$tenncc.'%');
            });
        }
        if(!empty($ngaynhap1) && !empty($ngaynhap2))
        {
            $query->where(function ($q) use ($ngaynhap1,$ngaynhap2){
                return $q->whereBetween('ngaynhap',[$ngaynhap1,$ngaynhap2]);
            });
        }        
        return $query;  
        
    }

}
