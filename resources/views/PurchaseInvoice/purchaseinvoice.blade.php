
@extends('manage')
@section('title','Nhập hàng')
@section('content')
<script type="text/javascript" src="{{asset('/js/jspurchaseinvoice.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/css/csspurchaseinvoice.css')}}">
<div class='sub_content'>    
    <div>
        <ul class="nav nav-tabs">
        <li class="nav-item active"><a  href="{{asset('purchaseinvoice')}}">Nhập hàng</a></li>
        <li class="nav-item"><a  href="{{asset('listinvoice')}}">Danh sách</a></li>
        </ul>
    </div>
    <div class="container">
    <form action="#" method='POST'>
            @csrf()
            <div class='form-group'>
                <div class="form-row">
                    <div  class="form-group col-sm-2">
                        <label for="text">Kho nhập</label>
                        <select type="text" class="form-control " id="mancc" placeholder="Kho nhập">
                            <option value="1">Warehouse 1</option>
                            <option value="2">Warehouse 2</option>
                            <option value="3">Warehouse 3</option>
                        </select>
                    </div>
                   <!--  <input id='idsupplier' hidden='true'/> -->
                    <div  class="form-group col-sm-5">
                        <label for="text">Nhà cung cấp(*)</label>
                        <select class='form-control' name='input_supplier' id="input_supplier" required>
                            <option value="">Chọn nhà cung cấp</option>
                            @isset($supplier)
                                @foreach($supplier as $value)                            
                            <option value="{{$value->id}}">{{$value->mancc." - ".$value->tenncc}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>                    
                    <div class="form-group col-sm-2">
                        <label for="text">Ký hiệu HĐ(*)</label>
                        <input type="text" class="form-control " id="input_kyhieu_hd" required />
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="text">Số hóa đơn(*)</label>
                        <input type="text" class="form-control " id="input_sohd" required />
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="text">Ngày Hóa đơn</label>
                        <input type="date" class="form-control " id="input_ngaylap_hd" />
                    </div>
                    <div class="form-group col-sm-1">
                        <label for="text">% VAT</label>
                        <select class="form-control" name='input_vat' id='input_vat' onchange="Total()">
                            <option value="0"> 0</option>
                            <option value="5"> 5</option>
                            <option value="8"> 8</option>
                            <option value="10"> 10</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="text">Ngày nhập</label>
                        <input type="date" class="form-control " id="input_ngaynhap" >
                    </div>
                </div> 
                <div class="form-group col-sm-6" >
                    <label for="text">Ghi chú</label>
                    <input type="text" class="form-control" id="ghichu"/>
                </div> 
                <div class="form-group col-sm-2" id='nguoinhap' dataid = "{{session('IdUser')}}">
                    <label for="text">Người nhập</label>
                    <input type="text" class="form-control" id="staff_id" value="{{session('user')}}" readonly='true'/>
                </div >                 
                </div>
            </div> 
            <div>  <!-- Danh sách đơn đặt hàng -->
                <table class="table table-bordered" id='TableProduct'>                    
                    <thead style="background-color: #6c757d;color:white">
                        <tr dataid=''><th>STT</th><th>Mã Sản phẩm</th><th>Tên Sản phẩm</th><th>Chất liệu</th><th>ĐV tính</th><th id='th_soluong'>Số lượng</th><th>Đơn giá</th><th>Thành tiền</th></tr>
                    </thead>
                    <tbody style="background-color: #FFFFFF" >
                        <tr>
                            <td class='STT_SP'>1</td><td><input class='input_masp' onblur="InfoProduct(this);" id='masp' list='listproduct' placeholder='nhập mã sp' /></td>
                            <td class='tensp'></td><td></td><td></td>
                            <td><input class='input_soluong' onkeyup="str_to_currency(this);"  onkeypress="return NumberKey(event)" value=0 oninput='SumInvoice($(this))' /></td>
                            <td><input class='input_dongia' onkeyup="str_to_currency(this);" oninput='SumInvoice($(this))'  onkeypress="return NumberKey(event)" value=0 /></td>
                            <td class='thanhtien' style="padding-right: 2px;"><input class='inputcurrency' id='showthanhtien' value=0  disabled /><img src='/icons/iconBtnDelete.png' onclick="RemoveRow($(this))" class='btnDeleteRow-hide'></td>
                        </tr>
                    </tbody>
                </table>                 
            </div>
            <div style="position:absolute;margin-top:5px;width:100%;background-color:#fcfcfd">
                <ul >
                    <li ><label>Thành tiền: </label><span class='unit'>VND</span><span class='LabelTotal'>0</span></li>
                    <li ><label>TT sau thuế: </label><span class='unit'>VND</span><span class='LabelTotalVat'>0</span></li>
                    <li>
                        <span class='btnTotal'>
                            <button  class="btn btn-primary" id="btn_stockin" onclick='stockin(event)'  style="height:35px;width:100px;float:right;margin-bottom:20px;background-color: #007bff;"><ion-icon name="save-outline" style="width:20px;height:25px;margin-left:5px;vertical-align: middle;"></ion-icon><span style="vertical-align: middle"> Lưu</span> </button>
                            <a href="{{asset('/purchaseinvoice')}}" type='button'  class="btn btn-primary"  style="height:35px;width:100px;float:right;margin-right: 10px;margin-bottom:20px;background-color: #007bff;"><ion-icon style="width:20px;height:25px;margin-left:5px;vertical-align: middle;" name="add-circle-outline"></ion-icon><span style="vertical-align: middle"> Tạo mới</span> </a>
                        </span>
                    </li>
                </ul>
            </div>                
        </form>
    </div>
    <div>
        <datalist id="listsupplier">  
            @isset($supplier)
                @foreach($supplier as $value)
                <option value='{{$value->mancc}}'>{{$value->mancc."-". $value->tenncc}}</option>
                @endforeach
            @endif
        </datalist> 
        <datalist id="listproduct">  
            @isset($product)
                @foreach($product as $value)
                <option value='{{$value->masp}}'>{{$value->masp."-". $value->tensp}}</option>
                @endforeach
            @endif
        </datalist> 
    </div>
</div>

@isset($nhacungcap)
<script>
    $("#input_supplier").val("{{$nhacungcap}}");
</script>
@endif
@if(isset($listproduct) && $listproduct!='') 
<script> 
    let stt = 0;
    let html= "";
    let row='';
    $("#TableProduct tbody").empty();
    @foreach($listproduct as $key=>$value)
        html = "<tr dataid='{{$value->product_id}}'><td class='STT_SP'>{{$key + 1}}</td><td><input class='input_masp' onblur='InfoProduct(this);' id='masp' list='listproduct' placeholder='nhập mã sp' /></td>\
                    <td class='tensp'></td><td></td><td></td>\
                    <td><input class='input_soluong'oninput='str_to_currency(this)' onblur='SumInvoice($(this))' onkeypress='return NumberKey(event)' value={{$value->soluong}} /></td>\
                    <td><input class='input_dongia' oninput='str_to_currency(this);' onblur='SumInvoice($(this))' onkeypress='return NumberKey(event)' value={{$value->dongia}} /></td>\
                    <td class='thanhtien' style='padding-right: 2px;'><input class='inputcurrency' value={{$value->soluong*$value->dongia}} disabled /><img src='/icons/iconBtnDelete.png' onclick='RemoveRow($(this))' class='btnDeleteRow-show'></td>\
                </tr>"; 
        $("#TableProduct").append(html);
        row = $("#TableProduct tbody tr").eq({{$key}});
        row.find('.input_masp').val("{{$value->masp}}");
        row.find('.tensp').text("{{$value->tensp}}");
        row.find('td').eq(3).text("{{$value->chatlieu}}");
        row.find('td').eq(4).text('{{$value->donvi}}');            
    @endforeach
    htmlempty = "<tr dataid=''><td class='STT_SP'>{{count($listproduct)+1}}</td><td><input class='input_masp' onblur='InfoProduct(this);' id='masp' list='listproduct' placeholder='nhập mã sp' /></td>\
                <td class='tensp'></td><td></td><td></td>\
                <td><input class='input_soluong' oninput='str_to_currency(this)' onblur='SumInvoice($(this))' onkeypress='return NumberKey(event)' /></td>\
                <td><input class='input_dongia' oninput='str_to_currency(this);' onblur='SumInvoice($(this))' onkeypress='return NumberKey(event)'  /></td>\
                <td class='thanhtien' style='padding-right: 2px;'><input class='inputcurrency' value=0  disabled /><img src='/icons/iconBtnDelete.png' onclick='RemoveRow($(this))' class='btnDeleteRow-show'></td>\
                </tr>"; 
            
    $("#TableProduct").append(htmlempty);
    Total(); //Hiển thị tổng tiền khi load đơn đặt hàng
    </script>
@endif
<script>
    $(document).ready(function(){   
        let today = currentDay();
        $("#input_ngaylap_hd, #input_ngaynhap").val(today);   
        
    });  
</script>









@endsection