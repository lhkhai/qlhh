@extends('manage')
@section('title','ListOrder')
@section('content')
<script type="text/javascript" src="{{asset('/js/jslistorder.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/css/csslistorder.css')}}">

<div class='sub_content'>    
    <div class='div_menu'>
        <ul class="nav nav-tabs">
        <li class="nav-item"><a  href="{{asset('purchaseorder')}}">Đặt hàng</a></li>
        <li class="nav-item active"><a  href="{{asset('listorder')}}">DS Đơn hàng</a></li>
        </ul>
    </div>    
    <div class='divsearch'> 
        <form class='form_search' method='get' action='{{asset("listorder/search")}}'> 
            <div class='form-group'>
                <div class='form-row'>
                    <div class='form-group col-sm-2'>
                        <label>Mã đơn hàng: </label>
                        <input type='text' id='maddh' class="form-control" placeholder='Nhập mã DDH'  name='input_search_maddh' value="@isset($search) {{$search[0]}} @endif"  />
                    </div>
                    <div class='form-group col-sm-2'>
                        <label>Nhà cung cấp: </label>
                        <input type='text' id='tenncc'  class="form-control" placeholder='Nhập tên SP'  name='input_search_tenncc' value="@isset($search) {{$search[1]}} @endif"/>
                    </div> 
                    <div class='form-group col-sm-2'>
                        <label>Ngày đặt: </label> <br>                      
                        <input type='date' id='ngaydat'  class="form-control"  name='input_search_ngaydat' value="@isset($search){{$search[2]}}@endif"/>
                    </div>
                    <div class='form-group col-sm-2'>
                        <label>Ngày giao: </label> <br>                   
                        <input type='date' id='ngaygiao'  class="form-control"  name='input_search_ngaygiao' value="@isset($search){{$search[3]}}@endif"/>
                    </div>                   
                    <div class='form-group col-sm-2'>
                        <label>Trạng thái: </label>
                        <select id='status'  class="form-control" name='input_search_trangthai'>
                            <option value=''>Tất cả</option>
                            <option value='1'> Đang chờ</option>
                            <option value='2'> Đã nhập</option>
                        </select>
                    </div>
                </div>
                <div class='form-group col-sm-2'>
                    <button class='btn btn-primary' style='margin-top:20px;' id='btn_search'><i class='fa fa-search' style='color: white'> Tìm kiếm</i></button>
                </div>
            </div>
        </form>    
    </div>
    <div class='viewtable'>
        <table class="table table-bordered" id='view-listorder'>
            <thead style='background-color:#6c757d; color:white;'>
                <tr><th>STT</th><th>Mã DDH</th><th>Nhà cung cấp</th><th>Ngày đặt</th><th>Ngày giao</th><th>Trạng thái</th><th>Ghi chú</th><th style='width:100px;'>Thao tác</th></tr>
            </thead>
            <tbody style="background-color:white;">
                @isset($dataview)
                    @foreach($dataview as $key=>$value)
                        <tr dataid='{{$value->maddh}}'><td>{{$key+1}}</td><td>{{$value->maddh}}</td><td>{{$value->tenncc}}</td><td>{{Date('d/m/Y',strtotime($value->ngaydat))}}</td><td>{{Date('d/m/Y',strtotime($value->ngaydat))}}</td>
                            <td class='status_order'>{{$value->status==1?'Đang chờ':'Đã nhận'}}</td><td>{{$value->noteorder}}</td>
                            <td>
                                <div class='tdthaotac'><button class='btn btn-primary'>Thao tác<ion-icon name="chevron-down-outline"></ion-icon></button>
                                    <div class='contentDropdown'>
                                        <ul>
                                            @if($value->status==1)
                                            <a href="{{asset('/purchaseinvoice/'.$value->IdPO)}}" class='hidden_tag'><ion-icon name="log-in-outline"></ion-icon> Nhập hàng</a>
                                            @endif
                                            <a onclick='openmodalview("{{$value->maddh}}","{{$value->IdPO}}", "{{$value->tenncc}}","{{$value->ngaydat}}","{{$value->ngaygiao}}")' data-toggle="modal" data-target="#modalview" href='#'><ion-icon name="eye-outline"></ion-icon> Xem</a>
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
<div class="modal fade" id="modalview" role="dialog">
    <div class='container'>
        <div  class='modal-dialog modal-lg' style="background-color:white;" id='viewpurchaseorder'>
            <button style="color: black;font-weight:bold;" type="button" class="close" data-dismiss="modal">&times;</button>
            <button onclick='printPage()' id='btnprintddh'  style="position: fixed;top:20px;right:10px;height: 30px;width:150px;">in phiếu</button>
            <div id='printpage'>              
                
                    <table id='tabletitle'>
                    <tr>
                            <td><img id='logo' src='{{asset("/icons/logoshop.png")}}' ></td>
                            <td style='padding-left: 10px;'>
                                <b>JAMIN COMPANY</b><br>
                                 <b style='font-size: 12px;'>Addr:</b> 123 Hùng Vương, An Lạc,                                  
                                 <br>&nbsp &nbsp &nbsp &nbsp &nbsp Bình Tân, TP. Hồ Chí Minh<br>
                                 <b>Tel:</b> &nbsp &nbsp 0939123123
                            </td>                        
                            <td style='text-align:center;'>
                            <b style='position:absolute;right: 20px;top: 50px;'> Mã Đơn ĐH: <span id='madonhang'></span><br>
                            <u style='position:absolute;left:0;'><i>Đơn hàng số: <span id='sodon'></span></i></u></b>                 
                            </td>
                        </tr>
                    </table>
                    <p>                       
                    <h4 style='font-weight:bold;text-align:center;'>ĐƠN ĐẶT HÀNG</h4>
                    <h6 style='font-weight:bold;text-align:center;'></h6>
                    </p>
                <p>
                Kính gửi: <label id='name_supplier'>Tên công ty</label> <br>
                Cửa hàng chúng tôi có nhu cầu đặt hàng tại Quý công ty theo danh sách sau: 
                <table id='PODetail' class='table table-bordered' style='margin-right:20px;'>
                    <thead><tr><th style='width:5%;'>STT</th><th>Tên sản phẩm</th><th style='width:10%;text-align:center;'>ĐVT</th><th style='width:10%;'>SL</th><th style='width:10%;text-align:right;'>Đơn giá</th><th style='width:15%;text-align:right;'>Thành tiền</th></tr></thead>
                    <tbody class='bodyprint'>
                        
                    </tbody>                    
                </table>
                Thời gian giao hàng dự kiến: <span id='ngaygiao'></span><br>
                Địa điểm giao hàng:123 Hùng Vương, An Lạc, Bình Tân, Tp. Hồ Chí Minh <br>
                Người nhận: Nguyễn Văn A ....................................SĐT: 0939123132 <br>
                Phương thức thanh toán: <br>
                - Thanh toán bằng tiền mặt hoặc chuyển khoản<br>
                - Thanh toán trước 50% giá trị hợp đồng, 50% còn lại thanh toán sau khi giao hàng.<br>

                                                                                <p style="width: 300px;margin-left: 60%;margin-top: 20px;text-align:center;">
                                                                                
                                                                            Cần Thơ, ngày <span id='ngay'></span> tháng <span id='thang'></span> năm <span id='nam'></span><br>

                                                                                            NGƯỜI ĐẠI DIỆN<br><br><br>
                                                                                            Nguyễn Văn A
                                                                                                </p>
                </p>
            </div>
        </div>
    </div>    
</div>
@isset($search)
<script>
    $("#status").val({{$search[4]}});
</script>
@endif
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

















@endsection
