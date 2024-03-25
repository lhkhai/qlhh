@extends('manage')
@section('title',"Products")
@section('content')
<script type="text/javascript" src="{{asset('/js/jsProduct.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/css/cssProduct.css')}}">  
<div class="title_top">     
    <img class="icon_title"  src="{{asset('/icons/icon_product_blue.png')}}"><span>DANH SÁCH SẢN PHẨM </span>
    <input id="btnOpenModal" onclick="OpenModal('#myModal')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" value="+ Thêm" />
</div>
<div class='div_search'> 
    <form class='form_search' method='get' action='{{asset("product/search")}}'> 
        <span>Mã SP: </span><input type='text'  class="form-control" placeholder='Nhập mã SP'  name='input_search_masp' value="@isset($search) {{$search[0]}} @endif"  />
        <span>Tên SP: </span><input type='text' class="form-control" placeholder='Nhập tên SP'  name='input_search_tensp' value="@isset($search) {{$search[1]}} @endif"/>
        <span>Nhóm SP: </span><input type='text' class="form-control" placeholder='Nhóm sản phẩm' name='input_search_nhomsp' value="@isset($search) {{$search[2]}} @endif" />
        <span>Chất liệu: </span><input type='text' class="form-control" placeholder='Chất liệu' name='input_search_chatlieu'value="@isset($search) {{$search[3] }} @endif" />
        <input class="btn btn-primary" type='submit' id='btn_search' value='Tìm kiếm'/>
        <!-- <input style="margin-left:10px;" class="btn btn-success" type="submit" id='btn_export' value='Xuất file Excel'/> -->
       <a href="{{ isset($search) ? route('product.export',['KeyExport'=>$search[0].'-'.$search[1].'-'.$search[2].'-'.$search[3]]) : route('product.export',['KeyExport'=>''])}}" style="margin-left:10px;" class="btn btn-success" type="submit" id='btn_export'>Xuất file Excel</a>
         
    </form>    
</div>
<div class='view_table'>
  <table class="table table-bordered" id="title_table">
        <thead>
          <tr class='title_table'><th>STT</th><th>Mã SP</th><th >Tên Sản phẩm</th>
          <th >Nhóm SP</th><th>Chất liệu</th><th>ĐV Tính</th><th>Size</th>
          <th>SL Tồn</th><th>Giá bán</th><th>Hinh ảnh</th><th>Mô tả</th><th>SP mới</th><th stle="width: 40px;" colspan=2>Thao tác</th>
          </tr>
        </thead>
        <tbody id = 'content_table'> 
            @if(isset($error_id))
            <script>
                alert("{{$error_id}}");
            </script>
            @endif
           @if(isset($dataview)) 
           <?php $stt=($dataview->currentPage()-1)* $dataview->perPage();  ?>
            @foreach($dataview as $key=>$value)
            <tr><td class="no-sort">{{++$stt}}</td><td>{{$value->masp}}</td><td>{{$value->tensp}}</td><td>{{$value->tennhom}}</td>
            <td>{{$value->chatlieu}}</td><td>{{$value->donvi}}</td><td style="text-align:center;">{{$value->kichthuoc}}</td><td style='text-align: right;'>{{$value->soluong}}</td><td style='text-align: right;'>{{$value->giaban}}</td>
            <td style='text-align:center;'>
                @if($value->hinhanh)
                   <?php  $img = json_decode($value->hinhanh);?>
                   <img style="height:20px;width:20px;" src='{{asset("imgUpload/imgProduct/". $img[0])}}' alt='Images Product' class='imgProduct' data-large='{{asset("imgUpload/imgProduct/". $img[0])}}'>                    
                @endif
                </td>
            <td>{{$value->mota}}</td><td value="{{$value->spmoi}}" style='text-align: center;'>@if($value->spmoi==1)<img  class='status_new' src='{{asset("icons/icon_status_new1.png")}}'>@endif</td>
            <td class="tdEditDel">
              <a  class="btnEdit" href="#" onclick="update({{$value->id}})" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalUpdate" ><img class="icon_edit"  src="{{asset('icons/icon_edit.png')}}" /></a>    
            </td>
            <td class="tdEditDel">            
              <a onclick="destroy({{$value->id}})" class="btnDelete" href="#" ><img   class="icon_delete" src="{{asset('icons/icon_delete.png')}}" /></a>                 
            </td>
            @endforeach
          @endif         
        </tbody>
  </table>
</div>
<div>
   @include('./divPagination')
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
          <button style="color: white" type="button" class="close" data-dismiss="modal">&times;</button>
          <img class="icon_title"  src="{{asset('/icons/icon_add_white.png')}}"><h4 class="modal-title"> THÊM SẢN PHẨM</h4>
        </div>
    <div class="modal-body">
        <form id= "formAdd" class="form-horizontal" action="{{asset('product')}}" enctype="multipart/form-data" method="POST"> 
            @csrf
            <div class="form-group">
            <label class="control-label col-sm-3" for="text">Mã SP:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="text"  name="masp" required />
            </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="text">Tên SP:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="text" name="tensp" required />
                </div>
            </div>            
            <div class="form-group">
                <label class="control-label col-sm-3" for="text">Nhóm SP:</label>
                <div class="col-sm-9">                    
                    <select class="form-control" id="text" name='categories_id' >
                        @isset($categories)
                            @foreach($categories as $key=>$value)
                        <option value="{{$value->id}}">{{$value->tennhom}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="text">Chất liệu:</label>
                <div class="col-sm-9">
                   <!--  <input type="text" class="form-control" id="text" name="chatlieu"  /> -->
                   <select class='form-control' name="chatlieu">
                        <option value="Vải Jeans">Vải Jeans</option>
                        <option value="Vải Silk">Silk (lụa)</option>
                        <option value="Vải Cotton">Vải Cotton</option>
                        <option value="Vải Kaki">Vải Kaki</option>
                        <option value="Vải Len">Vải Len</option>
                        <option value="Vải Đũi">Vải Đũi</option>
                        <option value="Vải Thun">Vải Thun</option>
                   </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="text">ĐV Tính:</label>
                <div class="col-sm-9">
                   <!--  <input type="text" class="form-control" id="text" name="donvi" required /> -->
                   <select class="form-control" id="text" name="donvi">
                        <option value="Cái">Cái</option>
                        <option value="Bộ">Bộ</option>
                   </select>
                </div>
            </div>
            <div class="form-group">
            <label class="control-label col-sm-3" for="text">Size:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="sdt"  name="kichthuoc" />
            </div>
            </div>
           <div class="form-group">
            <label class="control-label col-sm-3" for="text">Số lượng:</label>
            <div class="col-sm-9">
                <input type="text" onkeypress = "return NumberKey(event)" class="form-control" id="text" name="soluong" />
            </div>
            </div>
            <div class="form-group">
            <label class="control-label col-sm-3" for="text">Giá bán</label>
            <div class="col-sm-9">
                <input type="text" onkeypress="return NumberKey(event)" class="form-control" id="text" name="giaban" />
            </div>
            </div>
            <div class="form-group">
            <label class="control-label col-sm-3" for="text">Hình ảnh:</label>
            <div class="col-sm-9">
                <input type="file" class="form-control" id="text" name="hinhanh[]" id='hinhanh' multiple />
            </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="text">Mô tả:</label>
                <div class="col-sm-9">
                    <!-- <input type="textarea" class="form-control" id="text" name="mota" /> -->
                    <textarea class="form-control" id="mota" name="mota"></textarea>
                </div>
            </div>
            <div class="form-group">
            <label class="control-label col-sm-3" for="text">SP Nổi bật:</label>
                <div class="col-sm-9">                
                    <select class="form-control" id="text" name="spnoibat">
                        <option value=0>Bình thường</option>
                        <option value=1>Sản phẩm nổi bật</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="text">Sản phẩm mới:</label>
                <div class="col-sm-9">
                    <select class="form-control" id="text" name="spmoi">
                        <option value=0>Bình thường</option>
                        <option value=1>Sản phẩm mới</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <input id='btnAdd' type="submit" class="btn btn-primary" value="Thêm" />
                <input id='btnDismiss' type="button" class="btn btn-primary" data-dismiss="modal" value="Thoát" />
            </div>
        </form>
  </div>
  <div class="modal fade" id="myModalUpdate" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button style="color: white" type="button" class="close" data-dismiss="modal">&times;</button>
                <img class="icon_title"  src="{{asset('/icons/icon_update_white.png')}}"><h4 class="modal-title">Cập Nhật Thông Tin Sản phẩm</h4>
            </div>
            <div class="modal-body">
            <form id= "formEdit" class="form-horizontal" action="#"  enctype="multipart/form-data" method="POST"> 
                @csrf
                
                <div class="form-group">
                <label class="control-label col-sm-3" for="text">Mã SP:</label>
                <div class="col-sm-9">
                    <input type="text" readonly='true' class="form-control" id="text"  name="masp_edit" required />
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-sm-3" for="text">Tên SP:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="text" name="tensp_edit" required />
                </div>
                </div>                
                <div class="form-group">
                    <label class="control-label col-sm-3" for="text">Nhóm SP:</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="categories_id_edit" name='categories_id_edit' >
                            @isset($categories)
                                @foreach($categories as $key=>$value)
                            <option value="{{$value->id}}">{{$value->tennhom}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="text">Chất liệu:</label>
                    <div class="col-sm-9">
                        <select class='form-control' id="chatlieu_edit" name="chatlieu_edit">
                            <option value="Vải Jeans">Vải Jeans</option>
                            <option value="Vải Silk">Silk (lụa)</option>
                            <option value="Vải Cotton">Vải Cotton</option>
                            <option value="Vải Kaki">Vải Kaki</option>
                            <option value="Vải Len">Vải Len</option>
                            <option value="Vải Đũi">Vải Đũi</option>
                            <option value="Vải Thun">Vải Thun</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="text">ĐV Tính:</label>
                    <div class="col-sm-9">
                    <!--  <input type="text" class="form-control" id="text" name="donvi" required /> -->
                    <select class="form-control" id="text" name="donvi_edit">
                            <option value="Cái">Cái</option>
                            <option value="Bộ">Bộ</option>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                <label class="control-label col-sm-3" for="text">Size:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="sdt"  name="kichthuoc_edit" />
                </div>
                </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="text">Số lượng:</label>
                <div class="col-sm-9">
                    <input type="text" onkeypress="return NumberKey(event)" class="form-control" id="text" name="soluong_edit" />
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-sm-3" for="text">Giá bán</label>
                <div class="col-sm-9">
                    <input type="text" onkeypress="return NumberKey(event)" class="form-control" id="text" name="giaban_edit" />
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-sm-3" for="text">Hình ảnh:</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control" id="text" name="hinhanh_edit[]" id='hinhanh_edit' multiple />
                </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="text">Mô tả:</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="mota_edit" name="mota_edit"></textarea>
                    </div>
                </div>
                <div class="form-group">
                <label class="control-label col-sm-3" for="text">SP Nổi bật:</label>
                    <div class="col-sm-9">                
                        <select class="form-control" id="spnoibat_edit" name="spnoibat_edit">
                            <option value=0>Bình thường</option>
                            <option value=1>Sản phẩm nổi bật</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="text">Sản phẩm mới:</label>
                    <div class="col-sm-9">                   
                        <select class="form-control" id="spmoi_edit" name="spmoi_edit">
                            <option value=0>Bình thường</option>
                            <option value=1>Sản phẩm mới</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input id='btnSaveUpdate' type="submit" class="btn btn-primary" value="Lưu" />
                    <input id='btnDismiss' type="button" class="btn btn-primary" data-dismiss="modal" value="Thoát" />
                </div>
            </form>            
        </div>
    </div>
  </div> 
<div class="large-image"> <!-- Div hiển thị ảnh lớn hình ảnh sản phẩm ---->
    <img src="" alt="Image Product">
</div>
@endsection
