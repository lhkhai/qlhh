<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\supplier;

class supplierController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perpage',10);
        $supplier = supplier::paginate($perPage);    
        return view('supplier.supplier')->with(['dataview'=>$supplier,'perPage'=>$perPage]);
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = \Validator::make($input, ['mancc'=>$request,
                        'tenncc'=> 'required',
                        'diachincc'=> 'required',
                        'sdtncc'=> 'required',
                        'ttthanhtoan'=> 'required',
                        'ghichu'=> 'required',
                        'created_at'=>date('Y-m-d H:i:s')]);
        if($validator->fails()){
                            $arr = [
                              'success' => false,
                              'message' => 'Lỗi kiểm tra dữ liệu',
                              'data' => $validator->errors()
                            ];
                            return response()->json($arr, 200);
                        }
        $supplier = \App\Models\supplier::create($input);
        $arr = ['status' => true,
                'message'=>"Thêm thành công",
                'data'=> new \App\Http\Resources\supplier($supplier)
         ];
        return response()->json($arr, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
