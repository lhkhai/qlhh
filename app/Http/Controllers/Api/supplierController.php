<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\supplier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; //sử dụng DB::
class SupplierController extends Controller
{
    
    public function index()
    {
      
    }
    public function loadbynumrow($numrow)
    {
       $suppliers = \DB::table('suppliers')->paginate($numrow);
       //if($suppliers->count()>0){    
        return view('/supplier.supplier')->with(['pag_supplier'=>$suppliers]);      
      // } 
    }
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $mancc = $request->mancc;
        $suppliers = \DB::table('suppliers')->where('mancc', $mancc)->get();
        $countrecord = $suppliers->count();
        if($countrecord>0)
        {
            return response()->json([
                'message_code'=> 111,
                'message'=> 'Mã nhà cung cấp đã tồn tại.'],200);
        }
        else {
            $validator = Validator::make($request->all(),[
                'mancc'=> 'required|string|max: 50',
                'tenncc'=> 'required|string|max: 200',
                'diachincc'=> 'required|string|max: 200',
                'sdtncc' => 'required|string|max: 11',
                'emailncc'=> 'required'
            ]);
            if($validator->fails()){
                return response()->json([
                    'message_code'=> 112,
                    'message' => 'Vui lòng nhập đầy đủ thông tin bắt buộc.'
                ],200);
            }
            else {
                $supplier = supplier::create([
                    'mancc' => $request->mancc,
                    'tenncc' => $request->tenncc,
                    'diachincc' => $request->diachincc,
                    'sdtncc' => $request->sdtncc,
                    'emailncc' => $request->emailncc,
                    'ttthanhtoan' => $request->ttthanhtoan,
                    'ghichu' => $request->ghichu
                ]);
                $len = supplier::all()->count();
                if($supplier){
                    return response()->json([
                    'message_code'=> 200,
                    'message'=>'Đã thêm nhà cung cấp!',
                    'mancc'=> $request->mancc,
                    'len' => $len
                    ],200);
                }
                else {
                    return response()->json([
                        'message_code'=> 500,
                        'message'=>'Lỗi. Vui lòng liên hệ Admin để được hỗ trợ!'
                    ],500);
                }
            }
         }
    }
    public function show($id)
    {
        $supplier = supplier::find($id);
        if($supplier)
        {
            return response()->JSON(['data'=>$supplier],200);
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
        $supplier = supplier::find($id);
        if($supplier)
        {
            $supplier->update([
                'tenncc' => $request->tenncc,
                'diachincc' => $request->diachincc,
                'sdtncc' => $request->sdtncc,
                'emailncc' => $request->emailncc,
                'ttthanhtoan' => $request->ttthanhtoan,
                'ghichu' => $request->ghichu
            ]);
          return response()->JSON([
                    'status'=>200,
                    'supplier' => $supplier,
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
        $supplier = supplier::find($id);
        if($supplier)
        {
            $supplier->delete();
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
        
        $supplier = supplier::where("mancc",$code)->first();
        if($supplier->count()>0)
        {
            return response()->JSON(['data'=>$supplier],200);
        } 
        else 
        {
            return response()->JSON(['message'=> "Not found!"]);
        }
    }
    
}
