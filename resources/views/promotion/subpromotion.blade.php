<div id='khuyenmaihd' >
    <div class='form-group row'>
        <label style='text-align:right;' class="col-md-2 form-control-label text-md-right" for="code">Tổng tiền HĐ<span class="text-danger">*</span></label>
        <div class='col-md-4'><input name='inputtongtienhd' class='form-control' onkeypress='return NumberKey(event)' onkeyup='str_to_currency(this)'></div>
        <label style='text-align:right;' class="col-md-2 form-control-label text-md-right" for="code">Số tiền giảm<span class="text-danger">*</span></label>
        <div class='col-md-4'><input name='inputsotiengiam' class='form-control' onkeypress='return NumberKey(event)' onkeyup='str_to_currency(this)'></div>        
    </div>                  
                
</div>
<div class='' id='modalKMSP' style='display:none;'>
    <table id='TableProduct'>                    
        <thead style="background-color: #6c757d;color:white">
            <tr><th>STT</th><th>Mã Sản phẩm</th><th>Tên Sản phẩm</th><th>ĐV tính</th><th>Mức giảm(%)</th><th id='th_soluong'>SL Áp dụng</th></tr>
        </thead>
        <tbody style="background-color: #FFFFFF" id='tbodypromotion'>                                                                 
            <tr>
                <td>1</td><td><input name='inputmasp[]' class='input_masp form-control' onblur="LoadProduct(this);" list='products' placeholder='nhập mã sp' /></td>
                <td></td><td>cái</td><td><input class='form-control' name='mucgiam' value=5></td>
                <td><input class='form-control' onkeyup="str_to_currency(this);"  onkeypress="return NumberKey(event)" value=0 />
                    <img class='btnDelRow-show' src='/icons/iconBtnDelete.png' onclick="xoadong(this)" >
                </td>
            </tr> 
        </tbody>
    </table> 
</div>
<div class='datalist'>
    <datalist id='products'>
        @isset($products)
            @foreach($products as $val)
                <option value="{{$val->masp}}">
                {{$val->tensp}}
                </option>
            @endforeach
        @endif
    </datalist>
</div>