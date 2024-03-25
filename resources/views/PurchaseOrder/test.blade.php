
@extends('manage')
@section('title','Đặt hàng')
@section('content')
<script type="text/javascript" src="{{asset('/js/jspurchaseorder.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/css/csspurchaseorder.css')}}">
<div class='sub_content'>    
    <div>
        <ul class="nav nav-tabs">
        <li class="nav-item active"><a  href="{{asset('purchaseorder')}}">Đặt hàng</a></li>
        <li class="nav-item"><a  href="{{asset('listorder')}}">DS Đơn hàng</a></li>
        </ul>
    </div>
    <div class="container">
        <form action='#' method='POST'>
            @csrf()
            <div class='form-group'>
                <div class="form-row">
                    <input id='idsupplier' hidden='true'/>
                    <div  class="form-group col-sm-3">
                        <label for="text">Mã Nhà cung cấp</label>
                        <input type="text" class="form-control " id="mancc" placeholder="Mã nhà cung cấp">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="text">Tên Nhà cung cấp</label>
                        <select class='form-control' name='tenncc' onchange="getInfoSupplier($(this))" id="tenncc" required>
                            <option value="">Chọn nhà cung cấp</option>
                            @isset($supplier)
                                @foreach($supplier as $value)                            
                            <option value="{{$value->mancc}}">{{$value->tenncc}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="text">Số điện thoại</label>
                        <input type="text" class="form-control " id="sdt" disabled>
                    </div>
                </div> 
                <div class="form-group col-sm-6">
                    <label for="text">Địa chỉ</label>
                    <input type="text" class="form-control " id="diachi" disabled />
                </div>           
                <div class="form-group col-sm-3">
                    <label for="text">Ngày đặt</label>
                    <input type="date" class="form-control " id="ngaydat" />
                </div>
                <div class="form-group col-sm-3">
                    <label for="text">Ngày giao</label>
                    <input type="date"  class="form-control" id="ngaygiao" />
                </div>            
                <div class="form-group col-sm-6" id='nguoilap' dataid = "{{session('IdUser')}}">
                    <label for="text">Người lập</label>
                    <input type="text" class="form-control" id="staff_id" value="{{session('user')}}" readonly='true' />
                </div>
                <div class="form-group col-sm-6" >
                    <label for="text">Ghi chú</label>
                    <input type="text" class="form-control" id="ghichu"/>
                </div>               
                <!--   <center>  <input type="button" class="form-control btn btn-primary" id="btn_dathang" value="Gửi"/></center>
                 --></div>
                <!-- </div> -->
            </div> 
            <div>  <!-- Danh sách đơn đặt hàng -->
                <table class="table table-bordered" id='TableProduct'>                    
                    <thead style="background-color:#6c757d;color: white;">
                        <tr dataid=''><th>STT</th><th>Mã Sản phẩm</th><th>Tên Sản phẩm</th><th>Chất liệu</th><th>ĐV tính</th><th id='th_soluong'>Số lượng</th><th>Đơn giá</th><th>Thành tiền</th></tr>
                    </thead>
                    <tbody style="background-color: #FFFFFF" >
                        <tr>
                            <td class='STT_SP'>1</td><td><input class='input_masp' onblur="getInfoProduct(this);" id='masp' list='listproduct' placeholder='nhập mã sp' /></td><td class='tensp'></td><td></td><td></td>
                            <td><input class='input_soluong' onblur="Thanhtien($(this))" onkeypress="return NumberKey(event)" value=0 /></td>
                            <td><input class='input_dongia' oninput="str_to_currency(this);" onblur="Thanhtien($(this))" onkeypress="return NumberKey(event)" value=0 /></td>
                            <td class='thanhtien' style="padding-right: 2px;"><input id='showthanhtien' value=0 disabled /><img src='/icons/iconBtnDelete.png' onclick="RemoveRow($(this))" class='btnDeleteRow-hide'></td>
                        </tr>
                    </tbody>
                 </table>
            </div> 
            <div style="position:absolute;margin-top:5px;width:100%;background-color:#fcfcfd">
                <ul >
                    <li>
                        <span class='btnTotal'>
                        <input type="button" style="height:35px;width:100px;float:right;margin-bottom:20px;background-color: #007bff;" class="form-control btn btn-primary" id="btn_dathang" value="Gửi"/>
                        </span>
                    </li>
                </ul>
            </div>                   
        </form>
    </div>
    <div>
        <datalist id="listproduct">  
        
        </datalist> 
    </div>
</div>
<script>
        $(document).ready(function(){
            
            $("#masp").on('keyup',function(){
                
                $keysearch = $("#masp").val();
                $.get('api/apitimsp/' + $keysearch,
                function(response){
                   
                        if(response.message_code==200)
                        {                            
                            $('#listproduct').empty();
                            $products = response.products;
                            $.each($products,function($key,$value)
                            {
                               
                                $('#listproduct').append("<option value=" + $value.masp + ">");
                            });
                            
                        }
                        
                });
            });
        });
 </script>
@endsection
