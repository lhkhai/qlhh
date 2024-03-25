<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\customer;

class CustomerController extends Controller
{
    //
    public function index(Request $request)
    {
        $perPage = $request->input("perpage",10);
        $search = $request->input('search');        
        if(!empty($search[0]))
        {        
            $search = explode(',',$search[0]);           
            $makh = $search[0]; 
            $tenkh = $search[1];
            $sdt = $search[2]; 
          
               $query = customer::query(); // Initialize the query variable

                if ($makh != "") {
                    $query->where('makh', 'LIKE', "%" . $makh . "%");
                }

                if ($tenkh != "") {
                    $query->where(function ($q) use ($tenkh) {
                        return $q->where('tenkh', 'LIKE', '%' . $tenkh . '%');
                    });
                }

                if ($sdt != "") {
                    $query->where(function ($q) use ($sdt) {
                        return $q->where('sdt', 'LIKE', '%' . $sdt . '%');
                    });
                }
               $dataview = $query->paginate($request->perpage);                
               $search = array($makh,$tenkh,$sdt);
               return view('/customer.customer')->with(['dataview'=>$dataview,'perPage'=>$perPage,'search'=>$search,'current_url'=>'customer']);
             
        }
        else 
        {
            $dataview = customer::paginate($perPage);            
            return view('/customer.customer')->with(['dataview'=>$dataview,'perPage'=>$perPage,'search'=>$search]);
        }
    }
    
    public function search(Request $request)
    {
        
        if(empty($request->input('input_search_makh')) && empty($request->input('input_search_tenkh')) && empty($request->input('input_search_sdt')))
        
        {        
         return redirect('customer');
        }
        else {
         if($request->has('input_search_makh'))
         {
            
            $query = customer::where('makh','LIKE',"%".$request->input('input_search_makh')."%");
         }
        if($request->has("input_search_tenkh"))
        {
            $query->where(function ($q) use ($request){
            return $q->where('tenkh','LIKE','%'.$request->input('input_search_tenkh').'%');
            });
        }
         if ($request->has('input_search_sdt'))
        {
            $query->where(function ($q) use ($request)
            {
                return $q->where('sdt', 'LIKE','%'.$request->input_search_sdt . '%');
            });
        } 
        $perPage=$request->input('perPage',10);
        $dataview = $query->paginate($perPage);         
        $search = array($request->input('input_search_makh'),$request->input('input_search_tenkh'),$request->input('input_search_sdt'));
        return view('/customer.customer')->with(['dataview'=>$dataview,'perPage'=>$perPage,'search'=>$search,'current_url'=>'customer']);
        } 
    }  
}  