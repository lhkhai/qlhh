<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\supplierController;
use App\Models\supplier;
use App\Models\customer;
use App\Models\purchaseorder;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ListOrderController;
use App\Http\Controllers\PurchaseInvoiceController;
use App\Http\Controllers\ListInvoiceController;
use App\Http\Controllers\SaleInvoiceController;
use App\Http\Controllers\ListSaleInvoiceController;
use App\Http\Controllers\PromotionController;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('manage');
});
Route::get('/manage',function() {return view('manage');});  //page default
Route::get('/supplier',[SupplierController::class,'index']); //page supplier default


Route::get('/customer',[CustomerController::class,'index']);
Route::get('customer/search',[CustomerController::class,'search']);

Route::get('/categories',[CategoriesController::class,'index']); //Group product

Route::get('/product',[ProductController::class,'index']);
Route::get('product/search',[ProductController::class,'search']);
Route::get('product/export/{KeyExport?}',[ProductController::class,'export'])->name('product.export');

Route::get('/purchaseorder',[PurchaseOrderController::class,'index']);
Route::get('/listorder',[ListOrderController::class,'index']);
Route::get('listorder/search',[ListOrderController::class,'searchPO']);

Route::get('/purchaseinvoice/{maddh?}', [PurchaseInvoiceController::class, 'index']);
//Route::get('/purchaseinvoice/{maddh}',[PurchaseInvoiceController::class,'getorder'])->name('purchaseinvoice.getorder');

Route::get('/listinvoice',[ListInvoiceController::class,'index'])->name('listinvoice.index');
Route::get('/listinvoice/search',[ListInvoiceController::class,'SearchPI']);

Route::get('/sales',[SaleInvoiceController::class,'index']);
Route::get('/listsaleinvoice/search',[ListSaleInvoiceController::class,'searchSaleInvoice']);

Route::get('/promotion',[PromotionController::class,'index']);

Route::get('/viewcss',function(){

    return view('viewcss');
});
Route::get('/listsaleinvoice',[ListSaleInvoiceController::class,'index']);
Route::get('/report',function(){
    return view('baocaothongke.report');
});