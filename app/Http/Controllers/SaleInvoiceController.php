<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class SaleInvoiceController extends Controller
{
    //
    public function index()
    {
        $product = Product::All();
        return view('sales.saleinvoice')->with(['product'=>$product]);
    }
}
