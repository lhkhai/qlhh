
@extends('manage')
@section('title','Bán hàng')
@section('content')
<script type="text/javascript" src="{{asset('/js/jssaleinvoice.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/css/csssaleinvoice.css')}}">
<div class='sub_content'> 
    <div>
        <form action="#" method='POST'>
                @csrf()
            <div class='formproduct' >
                <div class='form-group'>
                    <!-- <div class="form-row">  -->               
                        <table id='TableProduct'>                    
                            <thead style="background-color: #6c757d;color:white">
                                <tr dataid=''><th>STT</th><th>Mã Sản phẩm</th><th>Tên Sản phẩm</th><th>Chất liệu</th><th>ĐV tính</th><th id='th_soluong'>Số lượng</th><th>Đơn giá</th><th>Thành tiền</th></tr>
                            </thead>
                            <tbody style="background-color: #FFFFFF" >
                                <tr>
                                    <td class='STT_SP'>1</td><td class='tdmasp'><input class='input_masp' onblur="InfoProduct(this);" list='listproduct' placeholder='nhập mã sp' /></td>
                                    <td class='tensp'></td><td></td><td></td>
                                    <td class='tdsoluong'><input type='number' class='input_soluong' onkeyup="str_to_currency(this);"  onkeypress="return NumberKey(event)" value=0 oninput='SumInvoice($(this))' /></td>
                                    <td class='tddongia'><input class='input_dongia' onkeyup="str_to_currency(this);" oninput='SumInvoice($(this))'  onkeypress="return NumberKey(event)" value=0 disabled /></td>
                                    <td class='tdthanhtien'><input name='input_thanhtien' class='inputcurrency' value=0 disabled /><img class='btnDelRow-hide' src='/icons/iconBtnDelete.png' onclick="DeleteRow($(this))" ></td>
                                </tr>                                
                            </tbody>
                        </table>  
                    <!-- </div> -->
                </div> 
            </div> 
            <div class='formcustomer' >
                <div>                
                    <h6>THÔNG TIN KHÁCH HÀNG</h6>
                    <div class='form-group'>
                        <div class='divinfocustomer'>                           
                            <table>
                                <tr class='idcustomer' dataid=''><td><label>Mã KH:</label></td><td><input id='input_makh' onblur='getInfoCustomer()' /></td></tr>
                                <tr><td><label>Họ tên: </label></td><td><input id='input_tenkh' /></td></tr>
                                <tr><td><label>Địa chỉ:</label></td><td><input id='input_diachi' /></td></tr>
                                <tr><td><label>Số điện thoại:</label></td><td><input id='input_sdt' onblur='getInfoCustomer()'/></td></tr>
                                <tr><td><label>Email:</label></td><td><input id='input_email' /></td></tr>
                                <tr><td><label>Điểm tích lũy:</label></td><td><span id='diem'></span></td></tr>
                                <tr><td><label></label></td><td></td></tr>
                                <tr><td><label>Tiền hàng:</label></td><td><label id='lbl_tienhang'></label> <label> VND</label></td></tr>
                                <tr><td><label>Thuế GTGT(10%):</label></td><td><label id='lbl_vat'> 0 </label> <label> VND</label></td></tr>
                                <tr style='color:red'><td ><label>Giảm giá:</label></td>
                                                     <td><label id='lbl_giamgia'>0</label> <label> VND</label></td></tr>
                                <tr style='color:blue'><td><label>Tổng thanh toán:</label></td><td><label id='lbl_total'> 0 </label> <label> VND</label></td></tr>
                            </table>
                            <input type='text' value="{{session('IdUser')}}" id='staff_id' hidden />
                            <input type='button' onclick='payments(event)' name='btnThanhtoan' class='btn btn-primary'  id='btnThanhtoan' value='Thanh Toán'/>
                            <input type='button' onclick='window.location.reload()' name='btnTaomoi' class='btn btn-primary' id='btnTaomoi' value='Tạo mới'/>
                        </div>
                    </div>
                </div>
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
                <option value='{{$value->masp}}'>{{$value->tensp."-SL:".$value->soluong}}</option>
                @endforeach
            @endif
        </datalist> 
    </div>
</div>

<div class="modal fade" id="modalprint" role="dialog">
    <div class='container'>
        <div class='modal-dialog modal-lg' style="background-color:white;" id='viewpurchaseorder'>
            <button style="color: black;font-weight:bold;" onclick="window.location.reload()" type="button" class="close" data-dismiss="modal">&times;</button>
            <button onclick='printPage()' id='btnprintddh'  style="position: fixed;top:20px;right:10px;height: 30px;width:150px;">in phiếu</button>
            <div id='printpage'>  
                <style>
                    #saleinvoicedetail td:nth-child(1),
                    #saleinvoicedetail td:nth-child(3)
                    {
                        text-align: center;
                    }
                    #saleinvoicedetail td:nth-child(4),
                    #saleinvoicedetail td:nth-child(5),
                    #saleinvoicedetail td:nth-child(6)
                    {
                        text-align: right;
                    }
                    #logo {
                        height: 100px;
                        width:100px;
                    }
                    .titleshop h4, .titleshop h6 {
                        font-weight: bold;
                        text-align:center;
                    }
                    .titleshop {
                        margin-top: 40px;
                    }
                    #saleinvoicedetail .endline td {
                        font-weight: bold;
                        text-align: right;
                    }
                    #printfooter {
                        margin-top:40px;
                        font-size:24px;
                        text-align: center;
                        font-family: "Brush Script MT";
                        margin-bottom: 20px;
                    }
                    #saleinvoicedetail tr:nth-last-child(2)
                    {
                        color:red;
                    }
                </style>              
                <div class="titleshop">
                    <table id='tabletitle'>
                        <tr>
                            <td><img id='logo' src='{{asset("/icons/logoshop.png")}}' ></td>
                            <td style='padding-left: 10px;'>
                                <b>JAMIN COMPANY</b><br>
                                <b style='font-size: 12px;'>Addr:</b> 123 Hùng Vương, An Lạc,                                  
                                <br>&nbsp &nbsp &nbsp &nbsp &nbsp Bình Tân, TP. Hồ Chí Minh<br>
                                <b>Tel:</b> &nbsp &nbsp 0939123123
                            </td>                            
                        </tr>
                    </table>                
                    <p>                       
                        <h4>HÓA ĐÓN BÁN HÀNG</h4>
                        <h6 >Mã phiếu: <span id='maphieuxuat'></span>
                        <br>Ngày bán: <span id='ngayban'></span> </h6>
                    </p>
                    <b>Khách hàng: </b> <span id='lblcustomer'> Nguyễn Văn A</span> <br>
                    <b>Địa chỉ: </b> <span id='lbladdr'>Hòa An, Phụng Hiệp Hậu Giang </span> <br>
                    <b>Số điện thoại: </b><span id='lbltel'> 0939123456</span> <br>
                    <b>Điểm tích lũy: </b> <span id='lblscore'>10 </span> <br>
                </div>
                <table id='saleinvoicedetail' class='table table-bordered' style='margin-right:20px;'>
                    <thead><tr><th style='width:5%;'>STT</th><th>Tên sản phẩm</th><th style='width:10%;text-align:center;'>ĐVT</th><th style='width:10%;'>SL</th><th style='width:10%;text-align:right;'>Đơn giá</th><th style='width:15%;text-align:right;'>Thành tiền</th></tr></thead>
                    <tbody class='bodyprint'>
                      
                    </tbody>                    
                </table> 
                 <div id='printfooter'>Cảm ơn Quí khách.<br>Hẹn gặp lại!!!</div>             
            </div>
        </div>
    </div>    
</div>

<script>
    $(document).ready(function(){          
        let today = currentDay();
        $("#input_ngaylap_hd, #input_ngaynhap").val(today);   
        
    }); 
    function printPage()
        {
            let PrintContent = document.getElementById('printpage');
            let originalcontent = document.body.innerHTML;
            document.body.innerHTML = PrintContent.innerHTML;
            window.print();
            document.body.innerHTML=originalcontent;
            location.reload();

        }
</script>






@endsection