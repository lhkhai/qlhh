<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;

class ApiCategoriesController extends Controller
{
    
    public function create(Request $request)
    {
        $data = $request->all();
        $check_id = categories::where('manhom',$request->manhom)->get();
        if($check_id->count()>0)
        {
            return response()->json(['code'=>202,'message'=>'Mã nhóm đã tồn tại!'],202);
        }
        else {
            $categories = categories::create($data);
            if($categories)
            {   
                return response()->json(['code'=>201,'message' => 'Đã thêm nhóm sản phẩm', 'categories' => $categories], 201);
            }
            else {
                return response()->json(['code'=>500,'message'=>'Lỗi. Vui lòng liên hệ admin!'],500);
            }
        }
        
    }
    public function update(Request $request,int $id)
    {
        $data = $request->all();
        $categories = categories::find($id);
        if($categories)
        {
            $categories->update($data);
            return response()->json(['message' => 'Cập nhật thành công', 'categories' => $categories], 201);
        }
        else {
           return response()->json(['message' => 'ID không tồn tại. Vui lòng kiểm tra lại.'], 202);
        }
    }
    public function delete(int $id)
    {
        $categories = categories::find($id);
        if($categories)
        {
            $categories->delete();
            return response()->json(['message' => 'Đã xóa thành công!'], 201);
        }
        else {
            return response()->json(['message' => 'ID không tồn tại. Vui lòng kiểm tra lại.'], 202);
         }
    }
    public function show(int $id)
    {
        $categories = categories::find($id);
        return response()->json(['categories' => $categories], 202);
    }
    
}
