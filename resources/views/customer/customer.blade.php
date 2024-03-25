@extends('manage')
@section('title')Customers @endsection
@section('content')
<script type="text/javascript" src="{{asset('/js/jsCustomer.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/css/cssCustomer.css')}}">  
<script>
  /* $(document).ready(function(){
    $("#perpage").onchange(function(){
      alert($("#perpage").val());
      $("#input_get_perpage").val($("#perpage").val());
    })
  }); */
</script>
<div class="title_top">     
  <img class="icon_title"  src="{{asset('/icons/icon_customer_blue.png')}}"><span>DANH SÁCH KHÁCH HÀNG </span>
  <input id="btnOpenModal" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" value="+ Thêm" />
</div>
<div class='div_search'> 
  <form class='form_search' method='get' action='{{asset("customer/search")}}'>    
    <input type='text'  class="form-control" placeholder='Nhập mã KH'  name='input_search_makh' value="@isset($search){{$search[0]}} @endif" id='input_search_makh' />
    <input type='text' class="form-control" placeholder='Nhập tên KH'  name='input_search_tenkh' value="@isset($search){{$search[1]}} @endif" id='input_search_tenkh' />
    <input type='text' class="form-control" placeholder='Nhập số điệnt thoại' name='input_search_sdt' value="@isset($search){{$search[2]}} @endif" id='input_search_sdt' />
    <input class="btn btn-success" type="submit" id='btn_search' value='Tìm kiếm'/>    
  </form>
</div>
<div class='sub_body'>
  <table class="table table-bordered" id="view_table_supplier">
      <thead>
       
          <tr class='title_table'><th class='stt'>STT</th><th class='mancc'>Mã KH</th><th class='tenncc'>Tên KH</th>
          <th class='diachincc'>Địa chỉ</th><th class='sdtncc'>Số điện thoại</th><th class='ttthanhtoan'>Email</th>
          <th class='ttthanhtoan'>Điểm tích lũy</th><th class='ghichu'>Ghi chú</th><th class="thaotac" stle="width: 40px;" colspan=2>Thao tác</th>
          </tr>
      </thead>
    <tbody id = 'list_ncc'> 
          @if(isset($dataview))   
         
           <?php $stt=($dataview->currentPage()-1)* $dataview->perPage();  ?>
            @foreach($dataview as $key=>$value)
            <tr><td>{{++$stt}}</td><td>{{$value->makh}}</td><td>{{$value->tenkh}}</td><td>{{$value->diachi}}</td>
            <td>{{$value->sdt}}</td><td>{{$value->email}}</td><td>{{$value->diemtichluy}}</td><td>{{$value->ghichu}}</td>
            <td class="tdEditDel">
              <a  class="btnEdit" href="#" value="{{$value->id}}" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalUpdate" ><img class="icon_edit"  src="{{asset('icons/icon_edit.png')}}" /></a>    
            </td>
            <td class="tdEditDel">            
              <a  value="{{$value->id}}" class="btnDelete" href="#" ><img   class="icon_delete" src="{{asset('icons/icon_delete.png')}}" /></a>                 
            </td>
            @endforeach
          @endif
         
    </tbody>
  </table>
</div>

<div >
   @include('./divPagination')  
</div>
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <button style="color: white" type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">THÊM KHÁCH HÀNG</h4>
      </div>
    <form id= "formAdd" class="form-horizontal" action="#" enctype="multipart/form-data" method="POST"> 
    @csrf
      <div class="modal-body">    
        <div class="form-group">
          <label class="control-label col-sm-3" for="text">Mã KH:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="text"  name="makh" required />
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3" for="text">Tên KH:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="text" name="tenkh" required />
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3" for="text">Địa chỉ:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="text" name="diachi" required />
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3" for="text">Số điện thoại:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="sdt" onblur="CheckNumberphone('sdt')" onkeypress="return NumberKey(event)" maxlenght="10" name="sdt" />
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3" for="email">Email:</label>
          <div class="col-sm-9">
            <input type="email" class="form-control" id="text" name="email" />
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3" for="text">Điểm tích lũy</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="text" name="diemtichluy" />
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-3" for="text">Ghi chú:</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="text" name="ghichu" />
          </div>
        </div>
      </div>
      <div class="modal-footer">
            <input id='btnAdd' onclick="addRecord()" type="button" class="btn btn-primary" value="Thêm" />
            <input id='btnDismiss' type="button" class="btn btn-primary" data-dismiss="modal" value="Thoát" />
      </div>
    </form>
  </div>
  </div>
</div>
<div class="modal fade" id="myModalUpdate" role="dialog"><!--                       Modal Update                                            -->
    <div class="modal-dialog">  
      <div class="modal-content">
        <div class="modal-header">
          <button style="color: white" type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cập Nhật Thông Tin Khách Hàng</h4>
        </div>
        <form id= "formEdit" class="form-horizontal" action="#" enctype="multipart/form-data" method="post"> 
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <input hidden="true" name="Edit_idkh" />
              <label class="control-label col-sm-3" for="text">Mã KH:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="text" readonly  name="Edit_makh" required />
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="text">Tên KH:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="text" name="Edit_tenkh" required />
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="text">Địa chỉ:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="text" name="Edit_diachi" required />
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="text">Số điện thoại:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" onblur="CheckNumberphone('Edit_sdt')" onkeypress="return NumberKey(event)" id="Edit_sdt" maxlenght="10" name="Edit_sdt" required />
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="email">Email:</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" id="text" name="Edit_email" />
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="text">Điểm tích lũy</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="text" name="Edit_diemtichluy" />
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-3" for="text">Ghi chú:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="text" name="Edit_ghichu" />
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <input id='btnSave_Update' type="button"  class="btn btn-primary" value="Cập nhật" />
              <input id='btnDismiss' type="button" class="btn btn-primary" data-dismiss="modal" value="Thoát" />
          </div>     
        </form>
      </div>
    </div>
  </div>  <!---------------------------End modal update------------------------------------------------> 

<script>      
$(document).ready(function(){
            $("#btnOpenModal").click(function(){
                $('#myModal').appendTo("body");
            });   
});
</script>  
  @if(isset($perPage))
  <script>$("#perpage").val('{{$perPage}}')
  </script> <!-- Set selectbox value -->  
  @endif
  
@endsection
