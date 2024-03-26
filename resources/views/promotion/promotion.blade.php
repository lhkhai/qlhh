@extends('manage')
@section('title','promotion management')
@section('content')

<script type="text/javascript" src="{{asset('/js/jspromotion.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/jsFunction.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/css/csspromotion.css')}}">

<div class='sub_content'>    
<div>
        <ul class="nav nav-tabs">
            <li class="nav-item active"><a  href="{{asset('listpromotion')}}">Quản lý chương trình khuyến mãi</a></li>
        </ul>
    </div>   
    <div class='divsearch'> 
        <form class='form_search' method='get' action='{{asset("listpromotion/search")}}'> 
            <div class='form-group' >
                <div class='form-row'>
                    <div class="col-md-2" style="padding:0;" >                        
                        <label>Mã Khuyến mãi </label>                    
                        <input type='text' id='maddh' class="form-control" placeholder='Mã khuyến mãi'  name='input_search_mapn' value="@isset($search) {{$search[0]}} @endif"  />

                    </div>
                    <div class='col-md-2'>
                        <label>Tên khuyến mãi </label>
                        <input type='text' id='maddh' class="form-control" placeholder='Số hóa đơn'  name='input_search_sohd' value="@isset($search) {{$search[1]}} @endif"  />
                    </div>
                    <div class='col-sm-2'>
                        <label>Loại khuyến mãi </label>
                       <select id='loaikm' class='form-control'>
                            <option value=1>Theo Giá trị hóa đơn</option>
                            <option value=1>Theo Giá trị sản phẩm</option>
                        </select>
                    </div> 
                    <div class='col-sm-2'>
                        <label>Trạng thái </label>
                        <select id='loaikm' class='form-control'>
                            <option value=1>Kích hoạt</option>
                            <option value=1>Đã đóng</option>
                        </select>
                    </div>
                    <div class='col-sm-2'>
                        <button class='btn btn-info' style='margin-top:25px;' id='btn_search'><i class='fa fa-search' style='color: white'> Tìm kiếm</i></button>
                    </div>
            </div>
        </form>  
        <div><button style="width: 80px;height:35px;margin-top:25px;float:right;" onclick="ShowModal('viewpromotion')" type="button" data-toggle="modal" data-target="#viewpromotion"  class="btn btn-primary" title="Thêm" ><i class='fa fa-plus' style='font-size:16px;color: white'> Thêm</i></button></div>  
    </div>
    <div class='viewtable'>
    @isset($message)
                    <script>alert('Loại khuyến mãi: ' + "{{$message}}")</script>
                    @endif
        <table class="table table-bordered" id='view_listpromotion'>
            <thead style='background-color:#6c757d;color:white;'>
                <tr><th>STT</th><th>Mã CTKM</th><th>Tên CTKM</th><th>Loại KM</th><th>Ngày Bắt đầu</th><th>Ngày Kết thúc</th><th>Người tạo</th><th>Thao tác</th></tr>
            </thead>
            <tbody style="background-color:white;">
                @isset($dataview)                  
                   
                    @foreach($dataview as $key=>$value)                    
                        <tr dataid='{{$value->id}}'><td>{{$key+1}}</td><td>{{$value->mactkm}}</td><td>{{$value->tenctkm}}</td><td>{{$value->tenloaikm}}</td>
                        <td>{{Date('d/m/Y',strtotime($value->ngaybd))}}</td><td>{{Date('d/m/Y',strtotime($value->ngaykt))}}</td>                        
                        <td> {{$value->hoten}}</td>
                        <td><button style="width: 60px;" onclick='viewpromotion({{$value->id}})' type="button" data-toggle="modal" data-target="#viewpromotion"  class="btn btn-primary btn-sm ng-scope" title="Xem" ><i class="fa fa-eye"></i> Xem</button>                            
                            @if($value->trangthai==1) <button onclick='clo_open_promotion("{{$value->id}}")' style="width: 80px;" type="button" class="btn btn-success btn-sm ng-scope" title="Lock" ><i class="fa fa-lock"></i> Khóa</button> 
                            @else <button onclick='clo_open_promotion("{{$value->id}}")' type="button" style="width: 80px;" class="btn btn-danger btn-sm ng-scope" title="Active" ><i class="fa fa-lock"></i> Mở khóa</button> 
                            @endif
                        </td>                          
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>   
    <div>
   <!-- include('./divPagination') -->
</div> 


</div>

<div class="modal fade" id="viewpromotion" role="dialog">
    <form id='eventpromotion' method='POST' action='{{asset("addpromotion")}}' enctype='multipart/form-data'>
        @csrf
    <div class="modal-dialog modal-lg" id='promotiondetail' style='height:90%;'>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">CHI TIẾT CHƯƠNG TRÌNH KHUYẾN MÃI</h4>
        </div>
        <div class="modal-body">
            <div class='form-group row'>
                <label style='text-align:right;' class="col-md-2 form-control-label text-md-right" for="code">Loại KM <span class="text-danger">*</span></label>
                <div class="col-md-4"  style=''>
                    <select name='txtloaikm' id='txtloaikm' required="" class='form-control' onchange='event_promotion()'>
                        <option value=''>Chọn loại khuyến mãi</option>
                        @foreach($promotiontype as $val)
                        <option value="{{$val->id}}">{{$val->tenloaikm}}</option>
                        @endforeach
                    </select>
                </div>
            </div> 
            <div class="form-group row">                               
                <label style='text-align:right;' class="col-md-2 form-control-label text-md-right" for="code">Mã CTKM <span class="text-danger">*</span></label>
                <div class="col-md-4"  style=''><input type="text" name='txtmactkm' id='txtmactkm' class="form-control" required="" placeholder="Mã dịch vụ" value='KMThang3' > 
                </div>
                <label style='text-align:right;' class="col-md-2 form-control-label text-md-right" for="code">Tên CTKM <span class="text-danger">*</span></label>
                <div class="col-md-4"  style=''><input name='txttenctkm' id='txttenctkm' type="text" class="form-control" required="" placeholder="Mã dịch vụ" value='Chương trình khuyến mãi tháng 3' > 
                </div> 
            </div>
            <div class='form-group row'>
                <label style='text-align:right;' class="col-md-2 form-control-label text-md-right" for="code">Ngày bắt đầu <span class="text-danger">*</span></label>
                <div class="col-md-4"  style=''><input type="date" name='txtngaybd' id='txtngaybd' class="form-control" required="" value='2024-03-26'> 
                </div>
                <label style='text-align:right;' class="col-md-2 form-control-label text-md-right" for="code">Ngày kết thúc <span class="text-danger">*</span></label>
                <div class="col-md-4"  style=''><input type= 'date' name='txtngaykt' id='txtngaykt' type="text" class="form-control" required="True" value='2024-03-26' > 
                </div>
            </div>
            <div class='form-group row'>
                <label class="col-md-2 form-control-label text-md-right" style='text-align:right;'>Trạng thái</label>
                <div class="col-md-4">
                    <label class='switch'>
                        <input name ='txttrangthai' type='checkbox' checked id='txttrangthai'>
                        <span class='slider'><span style='float:left;'>OFF</span><span style='float:right;margin-right:5px;'>ON</span></span>
                    </label>
                </div>
            </div>
            <div class='form-group row'>
                 <div class='col-md-12' id='dskhuyenmai'>

                 </div>                 
            </div>
        </div>        
        <div class="modal-footer">
           <button class='btn btn-default' style='color:white;background-color:#0077cc;' id='SavePromotion'>Lưu</button>
          <button type="button" id='btndong' class="btn btn-default" data-dismiss="modal">Đóng</button>
          
        </div>
      </div>
    </div>
  </div>
  </form>  
</div>
@include('promotion/subpromotion')

<!---------------------------------------------------------->

@endsection
