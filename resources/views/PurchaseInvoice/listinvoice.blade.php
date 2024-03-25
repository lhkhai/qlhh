@extends('manage')
@section('title','Danh sách')
@section('content')
<script type="text/javascript" src="{{asset('/js/jspurchaseinvoice.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/css/csslistorder.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/css/csspurchaseinvoice.css')}}">

<div class='sub_content'>    
<div>
        <ul class="nav nav-tabs">
        <li class="nav-item"><a  href="{{asset('purchaseinvoice')}}">Nhập hàng</a></li>
        <li class="nav-item active"><a  href="{{asset('listinvoice')}}">Danh sách</a></li>
        </ul>
    </div>   
    <div class='divsearch'> 
        <form class='form_search' method='get' action='{{asset("listinvoice/search")}}'> 
            <div class='form-group' >
                <div class='form-row'>
                    <div class="col-md-2" style="padding:0;" >                        
                        <label>Mã phiếu nhập </label>                    
                        <input type='text' id='maddh' class="form-control" placeholder='Mã phiếu nhập'  name='input_search_mapn' value="@isset($search) {{$search[0]}} @endif"  />

                    </div>
                    <div class='col-md-2'>
                        <label>Số hóa đơn </label>
                        <input type='text' id='maddh' class="form-control" placeholder='Số hóa đơn'  name='input_search_sohd' value="@isset($search) {{$search[1]}} @endif"  />
                    </div>
                    <div class='col-sm-2'>
                        <label>Nhà cung cấp </label>
                        <input type='text' id='tenncc'  class="form-control" placeholder='Tên nhà cung cấp'  name='input_search_tenncc' value="@isset($search) {{$search[2]}} @endif"/>
                    </div> 
                    <div class='col-md-3'> 
                        <label>Ngày nhập</label></br>                   
                        <div class='form-group col-sm-5' style="padding:0;"> 
                            <input type='date' id='from_date'  class="form-control"  name='input_search_ngaynhap1' value="@isset($search){{$search[3]}}@endif" />
                        </div>
                        <div class='form-group col-sm-5' style="margin-left: 10px; padding:0;"> 
                            <input style="display:inline-block;" type='date' id='to_date'  class="form-control"  name='input_search_ngaynhap2' value="@isset($search){{$search[4]}}@endif" />
                        </div>
                    </div>
                    <div class='col-sm-2'>
                        <button class='btn btn-primary' style='margin-top:25px;' id='btn_search'><i class='fa fa-search' style='color: white'> Tìm kiếm</i></button>
                    </div>
            </div>
        </form>    
    </div>
    <div class='viewtable'>
        <table class="table table-bordered" id='view-listorder'>
            <thead style='background-color:#6c757d;color:white;'>
                <tr><th>STT</th><th>Nhà cung cấp</th><th>Số hóa đơn</th><th>Ngày hóa đơn</th><th>Mã phiếu nhập</th><th>Ngày nhập</th><th>% VAT</th><th>Người nhập</th><th style='width:100px;'>Thao tác</th></tr>
            </thead>
            <tbody style="background-color:white;">
                @isset($dataview)
                    @foreach($dataview as $key=>$value)
                    
                        <tr dataid='{{$value->IDinvoice}}'><td>{{$key+1}}</td><td>{{$value->tenncc}}</td><td>{{$value->sohdnhap}}</td><td>{{Date('d/m/Y',strtotime($value->ngaynhap))}}</td>
                        <td>{{$value->maphieunhap}}</td><td>{{Date('d/m/Y',strtotime($value->ngayhdnhap))}}</td>
                        <td>{{$value->vat_hdnhap}}</td>
                            <td> {{session('user')}}</td>
                            <td>
                                <div class='tdthaotac'><button class='btn btn-primary'>Thao tác<ion-icon name="chevron-down-outline"></ion-icon></button>
                                    <div class='contentDropdown'>
                                        <ul> 
                                            <a onclick='openmodalprint("{{$value->IDinvoice}}","{{$value->sohdnhap}}","{{$value->ngayhdnhap}}","{{$value->maphieunhap}}","{{$value->ngaynhap}}", "{{$value->idsupplier}}")' data-toggle="modal" data-target="#modalprint" href='#'><ion-icon name="eye-outline"></ion-icon> Xem</a>                                          
                                            <a href='#'><ion-icon name="create-outline"></ion-icon> Cập nhật</a>
                                            <a href='#'><ion-icon name="close-circle-outline"></ion-icon> Xóa</a>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>   
    <div>
   @include('./divPagination')
</div> 
</div>

<!-- Tạo view xem và in bằng modal -->
<div class="modal fade" id="modalprint" role="dialog">
    <div class='container'>
        <div  class='modal-dialog modal-lg' style="background-color:white;" id='viewpurchaseorder'>
            <button style="color: black;font-weight:bold;" type="button" class="close" data-dismiss="modal">&times;</button>
            <button onclick='printPage()' id='btnprintddh'  style="position: fixed;top:20px;right:10px;height: 30px;width:150px;">in phiếu</button>
            <div id='printpage'>                
                <div class="titleshop">
                    <table id='tabletitle'>
                        <tr><td><img id='logo' src='{{asset("/icons/logoshop.png")}}' ></td>
                            <td style='padding-left: 10px;'>
                                <b>JAMIN COMPANY</b><br>
                                 <b style='font-size: 12px;'>Addr:</b> 123 Hùng Vương, An Lạc,                                  
                                 <br>&nbsp &nbsp &nbsp &nbsp &nbsp Bình Tân, TP. Hồ Chí Minh<br>
                                 <b>Tel:</b> &nbsp &nbsp 0939123123
                            </td>
                            <td style='text-align:center;'>
                            <b style='position:absolute;right: 20px;top: 50px;'> Số HĐ: <span id='sohdnhap'></span><br>
                            <u><i>Ngày HĐ: <span id='ngayhd'></span></i></u></b>                 
                            </td>
                        </tr>
                    </table>
                    <p>                       
                    <h4 style='font-weight:bold;text-align:center;'>PHIẾU NHẬP HÀNG TỪ NHÀ CUNG CẤP</h4>
                    <h6 style='font-weight:bold;text-align:center;'>Mã phiếu: <span id='maphieunhap'></span></h6>
                    <h6 style='font-weight:bold;text-align:center;'>Ngày lập: <span id='ngaynhap'></span></h6>
                    </p>
                </div>
                <b>Nhà cung cấp: </b> <span id='lbtenncc'> </span> <br>
                <b>Địa chỉ: </b> <span id='diachi'> </span> <br>
                <b>Số điện thoại: </b><span id='sdt'> </span> <br>
                <b>Mã số thuế: </b> <span id='mst'> </span> <br>
                <table id='PODetail' class='table table-bordered' style='margin-right:20px;'>
                    <thead><tr><th style='width:5%;'>STT</th><th>Tên sản phẩm</th><th style='width:10%;text-align:center;'>ĐVT</th><th style='width:10%;'>SL</th><th style='width:10%;text-align:right;'>Đơn giá</th><th style='width:15%;text-align:right;'>Thành tiền</th></tr></thead>
                    <tbody class='bodyprint'>
                        
                    </tbody>                    
                </table>               

                <p style="padding: 0px;width: 100%;margin:0px;margin-top: 20px;text-align:right;font-weight:bold;">                                                                                
                 Cần Thơ, ngày <span id='ngay'></span> tháng <span id='thang'></span> năm <span id='nam'></span></p>
                 <table style="height:40px;" class='endline'><tr style='height:40px;padding:0px;'><td>Người giao</td><td>Người nhận</td><td>Người lập</td></tr>
                    <tr><td colspan=2 ></td><td >{{session('user')}}</td></tr>
                 <table>                
            </div>
        </div>
    </div>    
</div>
<style>
.endline {width: 100%;
    }
.endline td {text-align: center; padding: 20px; font-weight: bold;}
.endline td ul {
    list-style: none;padding: 20px;
}
#logo {height: 100px;
width: 100px;}

    </style>
<script>
    function printPage() {

        var printContent = document.getElementById("printpage");
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = printContent.innerHTML;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
    }
    
</script>
<style>


















@endsection
