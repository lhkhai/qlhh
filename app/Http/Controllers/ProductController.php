<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\categories;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\YourExport;
use App\Exports\ProductsExport;

class ProductController extends Controller
{
    //
    public function index(Request $request)
    {
        $perPage = $request->input('perpage',10);
        $search = $request->input('search');
        if(!empty($search))
        {
            $split_arr = explode(',',$search[0]);
            $masp =$split_arr[0];
            $tensp =$split_arr[1];
            $nhomsp = $split_arr[2];
            $chatlieu = $split_arr[3];
            $query = product::query();
            if($masp!="")
            {
                $query->where('masp','LIKE','%'.$masp.'%');
            }
            if($tensp!="")
            {
                $query->where(function ($q) use ($tensp){
                    return $q->where('tensp','LIKE','%'.$tensp.'%');
                });
            }
            if($nhomsp!="")
            {
                $query->where(function ($q) use ($nhomsp){
                    return $q->where('categories_id',$nhomsp);
                });
            }
            if($chatlieu!="")
            {
                $query->where(function ($q) use ($chatlieu){
                    return $q->where('chatlieu','LIKE','%'.$chatlieu.'%');
                });
            }
            $dataview = $query->join('categories','categories.id','=','products.categories_id')
            ->select('categories.tennhom as tennhom','products.*')
            ->orderBy('masp','asc')->paginate($perPage);
            $search = array($masp,$tensp,$nhomsp,$chatlieu);
            $categories = categories::all();
            return view("product.product")->with(['dataview'=>$dataview,'categories'=>$categories,'perPage'=>$perPage,'search'=>$search,'current_url'=>'product']);

        }
        else {        
        $categories = categories::all();     
        $product = \DB::table('products')->join('categories','categories.id','=','products.categories_id')
                    ->select('categories.tennhom as tennhom','products.*')
                    ->orderBy('masp','asc')->paginate($perPage);
         return view('product.product')->with(['dataview'=>$product,'categories'=>$categories,'perPage'=>$perPage,'search'=>$search,'current_url'=>'product']);
        }   
    }

    public function search(Request $request)
    {
        $masp = $request->input_search_masp;
        $tensp = $request->input_search_tensp;
        $nhomsp = $request->input_search_nhomsp;
        $chatlieu = $request->input_search_chatlieu;

        if(empty($masp) && empty($tensp) && empty($nhomsp) & empty($chatlieu))
        {
             return redirect('product');
        }
        else{
        if($request->has('input_search_masp'))
         {  
            $query = \DB::table('products')->join('categories','categories.id','=','products.categories_id')
                    ->select('categories.tennhom as tennhom','products.*');
          
           $query->where('masp','LIKE',"%".$request->input('input_search_masp')."%");
            
         }
        if($request->has("input_search_tensp"))
        {
            $query->where(function ($q) use ($request){
            return $q->where('tensp','LIKE','%'.$request->input('input_search_tensp').'%');
            });
        }
         if ($request->has('input_search_nhomsp'))
        {
            $query->where(function ($q) use ($request)
            {
                return $q->where('tennhom', 'LIKE','%'.$request->input_search_nhomsp . '%');
            });
        } 
        if($request->has('input_search_chatlieu'))
        {
            $query->where(function ($q) use ($request){
               return $q->where('chatlieu','LIKE','%'.$request->input('input_search_chatlieu').'%');
            });
        }
        $perPage = $request->input('perpage',10);
        $dataview = $query->paginate($perPage); 
        $search = array($masp,$tensp,$nhomsp,$chatlieu);
        $categories = categories::all();
        return view('/product.product')->with(['dataview'=>$dataview,'perPage'=>$perPage,'search'=>$search,'current_url'=>'product','categories'=>$categories]); 
        }

    }
    public function export($KeyExport = null)
    {
        $filter= $KeyExport;
        if(empty($filter))
        {
            $data = \DB::table('products')->join('categories','categories.id','=','products.categories_id')
                    ->select('categories.tennhom as tennhom','products.*')->get();
            //$data = product::all();
        }
        else {
            $data = $this->filter($filter);
        }
       return Excel::download(new ProductsExport($data), 'DS_Sanpham.xlsx');
    }
    public function filter($search)
    {
        if(!empty($search))
        {
            $split_arr = explode('-',$search);
            $masp =$split_arr[0];
            $tensp =$split_arr[1];
            $nhomsp = $split_arr[2];
            $chatlieu = $split_arr[3];
           
            $query = product::query();
            if($masp!="")
            {
                $query->where('masp','LIKE','%'.$masp.'%');
            }
            if($tensp!="")
            {
                $query->where(function ($q) use ($tensp){
                    return $q->where('tensp','LIKE','%'.$tensp.'%');
                });
            }
            if($nhomsp!="")
            {
                $query->where(function ($q) use ($nhomsp){
                    return $q->where('categories_id',$nhomsp);
                });
            }
            if($chatlieu!="")
            {
                $query->where(function ($q) use ($chatlieu){
                    return $q->where('chatlieu','LIKE','%'.$chatlieu.'%');
                });
            }
            $data = $query->join('categories','categories.id','=','products.categories_id')
            ->select('categories.tennhom as tennhom','products.*')->get();
            
        }
       return $data;
    }
    
}
