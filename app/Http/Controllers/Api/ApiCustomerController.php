<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; //sử dụng DB::
class ApiCustomerController extends Controller
{
    
    public function index()
    {
       $customers = \DB::table('customers')->paginate(2);
       if($customers->count()>0){    
        return response()->json(['data_return'=>$customers],200);  
       } 
       
    }
    public function load($numrow)
    {
       $customers = \DB::table('customers')->paginate($numrow);          
       return redirect('/customer')->with(['dataview'=>$customers,'rowperpage'=>$numrow]);
       
       
    }
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $makh = $request->makh;
        $customers = \DB::table('customers')->where('makh', $makh)->get();
        $countrecord = $customers->count();
        if($countrecord>0)
        {
            return response()->json([
                'message_code'=> 111,
                'message'=> 'Mã khách hàng đã tồn tại.'],200);
        }
        else {                       
                $customer = DB::table('customers')->insert([ 
                "makh"=>$request->makh,
                "tenkh"=> $request->tenkh,
                "diachi"=> $request->diachi,
                "sdt"=> $request->sdt,
                "email"=> $request->email,
                "diemtichluy"=> $request->diemtichluy,
                "ghichu"=> $request->ghichu  
                 ]);
                    $len = customer::all()->count();
               
                    return response()->json([
                    'message_code'=> 200,
                    'message'=>'Thêm khách hàng thành công!',
                    'mancc'=> $makh,
                    'len'=>$len
                    ],200);
                
            
         }
    }
    public function show($id)
    {
        $customer = customer::find($id);
        if($customer)
        {
            return response()->JSON(['data'=>$customer],200);
        }
        else {
            return response()->JSON([
                'status'=>404,
                'message'=> 'Không tìm thấy dữ liệu'
            ], 404);
        }
    }
    public function edit($id)
    {
        $supplier = supplier::find($id);
        if($supplier)
        {
            return response()->JSON([
                'status'=> 200,
                'supplier'=>$supplier
            ],200);
        } else {
            return response()->JSON([
                'status'=> 404,
                'message'=> 'Không tìm thấy dữ liệu.'
            ],404);
        }
    }
    public function update(Request $request,int $id)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $customer = customer::find($id);
        if($customer)
        {
            $customer->update([
                'tenkh' => $request->tenkh,
                'diachi' => $request->diachi,
                'sdt' => $request->sdt,
                'email' => $request->email,
                'diemtichluy' => $request->diemtichluy,
                'ghichu' => $request->ghichu
            ]);
          return response()->JSON([
                    'status'=>200,
                    'customer' => $customer,
                    'message'=> "Cập nhật thành công!"
                ],200);
        } else {
                return response()->JSON([
                    'status'=>404,
                    'message'=>'Có lỗi xãy ra. Vui lòng liên hệ Admin để được hỗ trợ'
                ],404);
            }
        
    }
    public function destroy($id)
    {
        $customer = customer::find($id);
        if($customer)
        {
            $customer->delete();
            return response()->JSON([
                'status'=>200,
                'message'=>'Đã xóa thành công!'
            ],200);
        }
        else {
            return response()->JSON([
                'status'=>404,
                'message'=>'Mẫu tin cần xóa không tồn tại.'
            ],404);
        }
    }
    public function findbycode($code)
    {       
        
        $customer = customer::where("makh",$code)->first();
        if($customer->count()>0)
        {
            return response()->JSON(['message_code'=>200,'data'=>$customer],200);
        } 
        else 
        {
            return response()->JSON(['message_code'=>202,'message'=> "Không tìm thấy thông tin!"]);
        }
    }
    public function getInfoCustomer($code)
    {       
        
        $customer = customer::where("makh","like","%".$code."%")
                            ->orWhere("sdt","=",$code)->first();
        if($customer)
        {
            return response()->JSON(['message_code'=>200,'data'=>$customer],200);
        }
        
    }
    
}
