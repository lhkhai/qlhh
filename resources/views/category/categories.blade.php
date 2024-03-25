@extends('manage')
@section('title','Category')
@section('content')
<script type="text/javascript" src="{{asset('/js/jsCategories.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/css/cssCategories.css')}}">  

<div class="title_top">     
  <img class="icon_title"  src="{{asset('/icons/icon_category_blue.png')}}"><span>DANH SÁCH NHÓM SẢN PHẨM </span>
  <input id="btnOpenModal" onclick="OpenModal()" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" value="+ Thêm" />
</div>
<div class='view_table'>
  <table class="table table-bordered" id="title_table">
      <thead>       
          <tr class='title_table'><th class='stt'>STT</th><th>Mã Nhóm</th><th>Tên Nhóm</th>
          <th>Diễn Giải</th><th style="width: 20px;" colspan=2>Thao tác</th>
          </tr>
      </thead>
    <tbody id = 'content_table'> 
          @if(isset($dataview))           
           <?php $stt=($dataview->currentPage()-1)* $dataview->perPage();  ?>
            @foreach($dataview as $key=>$value)
            <tr><td>{{++$stt}}</td><td>{{$value->manhom}}</td><td>{{$value->tennhom}}</td><td>{{$value->diengiai}}</td>
            <td class="tdEditDel">
              <a  class="btnEdit" href="#" value="{{$value->id}}" onclick="update({{$value->id}})"  class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalUpdate" ><img class="icon_edit"  src="{{asset('icons/icon_edit.png')}}" /></a>    
            </td>
            <td class="tdEditDel">            
              <a  onclick="destroy({{$value->id}})" class="btnDelete" href="#" ><img   class="icon_delete" src="{{asset('icons/icon_delete.png')}}" /></a>                 
            </td></tr>
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
          <h4 class="modal-title">THÊM NHÓM SẢN PHẨM</h4>
        </div>
    <div class="modal-body">
    <form id= "formAdd" class="form-horizontal" action="#" enctype="multipart/form-data" method="POST"> 
    @csrf
    <div class="form-group">
      <label class="control-label col-sm-3" for="text">Mã Nhóm:</label>
      <div class="col-sm-9">
        <input type="text"  class="form-control" id="text"  name="manhom" required />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="text">Tên Nhóm:</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="text" name="tennhom" required />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="text">Diễn giải:</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="text" name="diengiai" required />
      </div>
    </div> 
    <div class="form-group">
        <div class="modal-footer">
            <input id='btnAdd' onclick="addRecord()" type="button" class="btn btn-primary" value="Thêm" />
            <input id='btnDismiss' type="button" class="btn btn-primary" data-dismiss="modal" value="Thoát" />
        </div>
    </div>
  </form>
  </div>
  <div class="modal fade" id="myModalUpdate" role="dialog"><!--                       Modal Update                                            -->
    <div class="modal-dialog">         
      
      <div class="modal-content">
       <div class="modal-header">
          <button style="color: white" type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">CẬP NHẬT NHÓM SẢN PHẨM</h4>
        </div>
        <div class="modal-body">
        <form id= "formUpdate" class="form-horizontal" action="#" enctype="multipart/form-data" method="POST"> 
    @csrf
    <div class="form-group">
      <input hidden='true' name='idnhom' />
      <label class="control-label col-sm-3" for="text">Mã Nhóm:</label>
      <div class="col-sm-9">
        <input type="text" readonly='true' class="form-control" id="text"  name="manhom_edit" required />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="text">Tên Nhóm:</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="text" name="tennhom_edit" required />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="text">Diễn giải:</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="text" name="diengiai_edit" required />
      </div>
    </div> 
    <div class="form-group">
        <div class="modal-footer">
            <input id='btnSave_Update' type="button" class="btn btn-primary" value="Lưu" />
            <input id='btnDismiss' type="button" class="btn btn-primary" data-dismiss="modal" value="Thoát" />
        </div>
    </div>
  </form>
  </div>  <!---------------------------End modal update------------------------------------------------> 


  






















@endsection