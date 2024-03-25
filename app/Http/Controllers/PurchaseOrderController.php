<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\supplier;
use App\Models\product;
class PurchaseOrderController extends Controller
{
    //
    public function index()
    {
        $supplier = supplier::all();
        $product = product::all();
        return view('purchaseorder/purchaseorder')->with(['supplier'=>$supplier,'product'=>$product]);
    }
}
