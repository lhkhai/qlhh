@extends('manage')
@section('title','Danh sách')
@section('content')
<script type="text/javascript" src="{{asset('/js/jslistsaleinvoice.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/jssaleinvoice.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/css/csssaleinvoice.css')}}">
<style>
    #title {
        width: 100%;
        height:35px;
        font-size: 24px;
        font-weight:bold;
        color:blue;
       
    }
</style>
<div class='sub_content'>
    <div id='title'>Danh sách hóa đơn bán hàng</div>
    <div class='divsearch'> 
        <form class='form_search' method='get' action='{{asset("listsaleinvoice/search")}}'> 
            <div class='form-group' >
                <div class='form-row'>
                    <div class="col-md-2" style="padding:0;" >                        
                        <label>Mã hóa đơn</label>                    
                        <input type='text' id='maddh' class="form-control" placeholder='Mã hóa đơn'  name='input_search_mahd' value="@isset($search) {{$search[0]}} @endif"  />

                    </div>
                    <div class='col-md-2'>
                        <label>Tên khách hàng </label>
                        <input type='text' id='mahd' class="form-control" placeholder='Tên khách hàng'  name='input_search_tenkh' value="@isset($search) {{$search[1]}} @endif"  />
                    </div>
                    <div class='col-sm-2'>
                        <label>Nhân viên </label>
                        <select type='text' id='nhanvien' class="form-control" name='input_search_idnhanvien'>
                            <option value='' >----Chọn nhân viên----</option>
                            
                            @foreach($staffs as $staff)
                            @if(isset($search) && $search!=null && $staff->id == $search[2])
                            <option value={{$staff->id}} selected>{{$staff->hoten}}</option>
                            @else
                            <option value={{$staff->id}}>{{$staff->hoten}}</option>
                             @endif
                            
                            @endforeach
                        </select>
                        <!-- <input type='text' id='tenncc'  class="form-control" placeholder='Nhan viên'  name='input_search_tenncc' value=""/> -->
                    </div> 
                    <div class='col-md-3'> 
                        <label>Ngày bán</label></br>                   
                        <div class='form-group col-sm-5' style="padding:0;"> 
                            <input type='date' id='from_date'  class="form-control"  name='input_search_tungay' value="@isset($search){{$search[3]}}@endif" />
                        </div>
                        <div class='form-group col-sm-5' style="margin-left: 10px; padding:0;"> 
                            <input style="display:inline-block;" type='date' id='to_date'  class="form-control"  name='input_search_denngay' value="@isset($search){{$search[4]}}@endif" />
                        </div>
                    </div>
                    <div class='col-sm-3'>
                        <button class='btn btn-primary' style='margin-top:25px;' id='btn_search'><i class='fa fa-search' style='color: white'> Tìm kiếm</i></button>
                        <button class='btn btn-primary' style='margin-top:25px;background-color:green;' onclick='inds()'>In Danh sách</button>
                    </div>
            </div>
        </form>    
    </div> 
    <div id='viewtable'>
        <table class="table table-bordered" id='view_listsaleinvoice'>
            <thead style='background-color:#6c757d;color:white;'>
                <tr><th>STT</th><th>Mã hóa đơn</th><th>Ngày bán</th><th>Mã KH</th><th>Tên Khách hàng</th><th>Trị Giá Hóa Đơn</th><th>Nhân viên</th><th>Trạng thái</th></tr>
            </thead>
            <tbody style="background-color:white;">               
                @isset($dataview)
                <?php $stt = ($dataview->currentpage()-1)*10 ?>
                    @foreach($dataview as $key=>$value) 
                                  
                        <tr><td>{{++$stt}}</td>
                        <td><a href='#' onclick='printSaleiIvoice("modalprint",{{$value->idcustomer}},{{$value->id}})'>{{$value->maphieuxuat}}</a></td>
                        <td>{{Date('d/m/Y',strtotime($value->ngayxuat))}}</td>
                        <td>{{$value->makh}}</td>
                        <td>{{$value->tenkh}}</td>
                        <td>{{number_format($value->tongthanhtien,0,',','.')}}</td>
                        <td>{{$value->nhanvien}}</td>
                       <td>Đã giao</td>
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

@include('./printsaleinvoice')



















@endsection
