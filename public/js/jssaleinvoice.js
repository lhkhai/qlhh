
async function payments(event){
        event.preventDefault();
       
        if(confirm('Bạn có chắc muốn thanh toán?')==true){
        var currentUrl = window.location.href;
        var url = new URL(currentUrl);
        var pathname = url.pathname;
        var part = pathname.split("/");
        if(part.length==3) //Lấy mã đơn đặt hàng thông qua link
        {
            var order_id = part[2];
        }
        else {
            var order_id = ""; 
        }
        let staff_id = $("#staff_id").val();
        //lấy thông tin khách hàng
        let idcustomer = $(".divinfocustomer table tr:first").attr('dataid');        
        let  makh = $("#input_makh").val();
        let tenkh = $("#input_tenkh").val();
        let diachi = $("#input_diachi").val();
        let email = $("#input_email").val();
        let sdt = $("#input_sdt").val();
        let total = convert_to_number($("#lbl_tienhang").text());
        if(makh=='' || tenkh=='' || diachi == '' || sdt == '')
        {
            alert("Vui lòng nhập thông tin khách hàng!");
            return;
        }

        //lấy danh sách đơn hàng bán
        let lentable = $("#TableProduct tbody tr").length;
        var listproduct = [];
        for(let i = 1; i < lentable;i++)
        {
            let row = $("table tr").eq(i);//.find('td');
            let id = $("table tr").eq(i).attr('dataid');
            let soluong = row.find('input').eq(1).val();
            soluong = convert_to_number(soluong);
            if(soluong==0)
            {
               row.find('input').eq(1).addClass('soluong0');
               alert("Số lượng phải lớn hơn 0");
               return;
            }
            else {
               row.find('input').eq(1).removeClass('soluong0');
            }
            let soluongton = await CheckInventory(id);
            if(soluong>soluongton.soluong)
            {   row.find('input').eq(1).addClass('soluong0');
                alert('Chu ý: số lượng tồn kho không đủ.');
                return
            }
            else {
                row.find('input').eq(1).removeClass('soluong0');
            }
            let price = row.find('.input_dongia').val();
            let dongia = convert_to_number(price);
            listproduct.push([id,soluong,dongia]);
        }        
        $.post('api/sales/payments',
             {
                'idcustomer':idcustomer,
                'makh' : makh,
                'tenkh':tenkh,
                'diachi':diachi,
                'email': email,
                'sdt': sdt,                 
                "staff_id" : staff_id,
                "listproduct": listproduct,
                "order_id": order_id,
                'tongthanhtien': total
             },
             function(response){
                alert(response.message); 
                idcustomer = response.customer.id;
                idsaleinvoice = response.saleinvoice.id;
                printSaleiIvoice('modalprint',idcustomer,idsaleinvoice);
             });
            }
    }

function printSaleiIvoice(myModal,idcustomer,idsaleinvoice,) //In hóa đơn bán hàng
{   
    $('.bodyprint').empty();
    $('#' + myModal).appendTo("body");
    $('#' + myModal).modal('show');
    $.ajax({
        type: 'GET',
        url: 'api/printsaleinvoice/' + idcustomer +'/' + idsaleinvoice,
        success:function(response){
           
            let khachhang = response.customer;
            let saleinvoice = response.saleinvoice;
            $('#lblcustomer').text(khachhang.tenkh);
            $('#lbladdr').text(khachhang.diachi);
            $('#lbltel').text(khachhang.sdt);
            $('#lblscore').text(khachhang.diemtichluy);
            $('#maphieuxuat').text(saleinvoice.maphieuxuat);
            
            var dateObject = new Date(saleinvoice.ngayxuat);     
            var day = dateObject.getDate();
            var month = dateObject.getMonth() + 1; 
            var year = dateObject.getFullYear();
            var formattedDate = day + "/" + month + "/" + year;
            $('#ngayban').text(formattedDate);
            let products = response.saleinvoicedetail;
            let tongtienhang = 0;
            let tt;
            $.each(products, function(key,value){
                let stt=key+1;
                tt = products[key].dongia*products[key].soluongban;
                $('.bodyprint').append($("<tr>")
                .append($('<td>').append(stt))
                .append($('<td>').append(products[key].tensp))
                .append($('<td>').append(products[key].donvi))
                .append($('<td>').append(products[key].soluongban))
                .append($('<td>').append(products[key].dongia.toLocaleString()))
                .append($('<td>').append(tt.toLocaleString()))
                );
                tongtienhang += tt;
            });
            let giamgia = response.khuyenmai;
            let ttt = (tongtienhang-giamgia);
            $('.bodyprint').append($("<tr class='endline'>")
                .append($("<td colspan=5>").append('Tổng tiền hàng'))
                .append($("<td>").append(tongtienhang.toLocaleString())));
            $('.bodyprint').append($("<tr class='endline'>")
                .append($("<td colspan=5>").append('Khuyến mãi'))
                .append($("<td>").append(giamgia.toLocaleString())));
            $('.bodyprint').append($("<tr class='endline'>")
                .append($("<td colspan=5>").append('Tổng thanh toán'))
                .append($("<td>").append(ttt.toLocaleString())));
            

        }
    });
}

function formatCurrency(input) {     
      var value = parseFloat(input.value);       
      if (!isNaN(value)) {       
        var formattedValue = value.toLocaleString();
        input.value = formattedValue;
      }
    } 
/*$(document).ready(function(){ //Hiển thị dấu chấm phần ngàn khi load đơn hàng nhập   
    let dongia = $(".input_dongia");
    let soluong = $(".input_soluong");
    let thanhtien = $(".inputcurrency");
    dongia.each(function()
    {
        formatCurrency(this);
    });
    soluong.each(function()
    {
        formatCurrency(this);
    });
    thanhtien.each(function() {
        formatCurrency(this);
    });
        Total();
});*/
function CopyRow()
{ 
    let row = "<tr dataid=''><td class='STT_SP'></td><td class='tdmasp'><input class='input_masp' onblur='InfoProduct(this)' list='listproduct'\
                    placeholder='nhập mã sp' /></td><td class='tensp'></td><td></td><td></td><td class='tdsoluong'><input type='number' class='input_soluong' onkeyup='str_to_currency(this);' oninput='SumInvoice($(this))' value=0 onkeypress='return NumberKey(event)' /></td>\
                    <td class='tddongia'><input class='input_dongia' oninput='SumInvoice($(this))' onkeyup='str_to_currency(this);' onkeypress='return NumberKey(event)' value=0 disabled /></td> \
                    <td class='tdthanhtien'><input class='inputcurrency' id='showthanhtien' value=0 disabled /><img src='/icons/iconBtnDelete.png' onclick='DeleteRow($(this))' class='btnDelRow-hide' ></td></tr>" ;
                   
    
    let check = $('#TableProduct tbody tr:last').find('td').eq(2).text();
    
    if(check!=""){
    $('#TableProduct tbody').append(row);
    }
    Total();
}
function CheckInventory(id)
{
    return new Promise(function(resolve,reject){
        $.ajax({
            type: 'GET',
            url:'/api/product/' + id + '/show',
            success: function(response)
            {
                resolve(response.product);
            },
            error: function(xhr,status, error)
            {
                reject(error);
            }
        });
    });
}
function InfoProduct(index)
{ 
    
    let masp = $(index).val();
    let indextr = $(index).closest('tr').index();
    if(masp == '')
    {
        let currentRow = $('tbody tr').eq(indextr);
        currentRow.attr('dataid', "");
        currentRow.find('td').eq(2).text('');
        currentRow.find('td').eq(3).text('');
        currentRow.find('td').eq(4).text('');
        currentRow.find('input').val(0);
        currentRow.find('input:first').val('');            
              
    }   
    else {
        let list = document.getElementsByClassName('input_masp');  
        for(var i = 0; i<list.length - 1; i++)
        {
            if(i == indextr)
            {
                continue;
            }
            if(list[i].value == masp)
            {
                
                alert('Sản phẩm đã tồn tại, Bạn có thể cập nhật lại số lượng!');
                $('#TableProduct tbody').find('tr').eq(i).addClass('duplicateproduct'); 
                return;
            }
            else {
                $('#TableProduct tbody').find('tr').eq(i).removeClass('duplicateproduct'); 
            }
        }
        $.ajax({
            type: 'GET',
            url: '/api/product/pdinfo/' + masp,
            success: function (response) { 
                
                let product = response.product;
                let km = response.promotion;
                
                if (response.message_code == 200) {
                    $.each(product, function (key, value) {
                        let currentRow = $('tbody tr').eq(indextr);
                        currentRow.attr('dataid', value.id);
                        currentRow.find('td').eq(2).text(value.tensp);
                        currentRow.find('td').eq(3).text(value.chatlieu);
                        currentRow.find('td').eq(4).text(value.donvi);
                        currentRow.find('td').eq(5).find('input').val(1);
                        if(value.giamgia>0 && km==true){
                            var giagiam = ((100-value.giamgia)/100)*value.giaban;                            
                            currentRow.find('td').eq(6).find('input').val(giagiam.toLocaleString());
                        }
                        else {
                            currentRow.find('td').eq(6).find('input').val(value.giaban.toLocaleString());
                        }
                        
                        currentRow.find('img').removeClass('btnDelRow-hide');
                        currentRow.find('img').addClass('btnDelRow-show');
                    }); 
                    SumInvoice(index);       
                    CopyRow();                    
                    getIndex(); 
                                
                }
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 429) {
                    console.log('Quá nhiều yêu cầu, đang chờ và thử lại sau.');                 
                }            
            }
        });
    }
    
} 
function SumInvoice(index)
{    
     let soluong =convert_to_number($(index).parents('tr').find('.input_soluong').val());     
     let dongia = convert_to_number($(index).parents('tr').find('.input_dongia').val());       
     let thanhtien = soluong*dongia;     
     $(index).parents('tr').find('.inputcurrency').val(thanhtien.toLocaleString());
     Total();
}
function DeleteRow(link) 
{
    let rowindex = $(link).parents('tr').index();
    $('tr').eq(rowindex+1).remove();
    Total();
    getIndex();
}

async function Total() //async-await khai báo hàm bất đồng bộ
    {
        
        let total = 0; 
        var checkpromo = await getPromotion();
        var hanmuc = checkpromo.hanmuc;
        var sotiengiam = checkpromo.sotiengiam;                                                                                               
        let row = $("#TableProduct tbody tr");
        let len = $("#TableProduct tbody tr").length;
        for(i=0;i<len ;i++)
        {
           let tt = row.eq(i).find('.inputcurrency').val();  
           total = total + convert_to_number(tt);
        }
         if(total>=hanmuc)
         {
            $("#lbl_giamgia").text(sotiengiam.toLocaleString());
            giamgia= sotiengiam;
         }
         else {
            $("#lbl_giamgia").text(0);
            giamgia = 0;
         }
         let tongthanhtoan=total-giamgia; 
         $("#lbl_tienhang").text(total.toLocaleString());
         $("#lbl_total").text(tongthanhtoan.toLocaleString());    
         
         return total;
       
    }
function getPromotion()
{
    return new Promise(function(resolve, reject) {
        $.ajax({
            type: 'GET',
            url: '/api/getpromotion/',
            success: function(response) {
                resolve(response);
            },
            error: function(xhr, status, error) {
                reject(error);
            }
        });
    });
   
}
function convert_to_number(input)
    {
      if(typeof input !== 'string')
      {
         return input;
      }      
      return parseFloat(input.replace(/\./g,""));
     }

function openmodalprint(IDinvoice,sohd,ngayhd,maphieunhap,ngaynhap,idsupplier)
{  
    
    $(".bodyprint").empty(); //clear history when call function
    $('#modalprint').appendTo("body");
    $("#sohdnhap").text(sohd);
    $("#maphieunhap").text(maphieunhap);
    var formatngayhd = moment(ngayhd).format("DD-MM-YYYY");    
    $("#ngayhd").text(formatngayhd);
    var formatngaynhap = moment(ngaynhap).format("DD-MM-YYYY");
    $("#ngaynhap").text(formatngaynhap);
    var newdate = new Date(ngaynhap);
    var ngay = newdate.getDate();
    var thang = newdate.getMonth() + 1;
    var nam = newdate.getFullYear();
    $("#ngay").text(ngay);
    $("#thang").text(thang);
    $("#nam").text(nam);

    //get info supplier
    $.get('/api/supplier/' + idsupplier,
    function(response){
        $("#lbtenncc").text(response.data.tenncc);
        $("#diachi").text(response.data.diachincc);
        $("#sdt").text(response.data.sdtncc);
        $("#masothue").text(response.data.mst);
    });
    
    $.get('/api/apipurchaseinvoice/find/' + IDinvoice,
    function(response){
        
        var list = response.data;
        let sum = 0;
        $.each(list, function(key,value){
            let stt = key + 1;
            
            let dongia = Number(list[key].dongia).toLocaleString();
            let thanhtien = Number(list[key].soluong*list[key].dongia).toLocaleString();
            let thanhtiennumber =  list[key].soluong*list[key].dongia;
            sum = sum + thanhtiennumber;
            $('.bodyprint').append($("<tr>")
                .append($("<td>").append(stt))
                  .append($("<td>").append(list[key].tensp))
                  .append($("<td style='text-align:center;'>").append(list[key].donvi))
                  .append($("<td style='text-align:right;'>").append(list[key].soluong))
                  .append($("<td style='text-align:right;'>").append(dongia))
                  .append($("<td style='text-align:right;'>").append(thanhtien))
               ); 
        });
        var vat = (response.vat * sum)/100;
        var tongthanhtoan = sum + (response.vat*sum)/100;

        $('.bodyprint').append($("<tr style='font-weight:bold;'>").append($("<td colspan=5 style='text-align: Right;'>").append("Tổng tiền hàng:"))
        .append($("<td style='text-align: Right;'>").append(Number(sum).toLocaleString())));
        
        $('.bodyprint').append($("<tr style='font-weight:bold;'>").append($("<td colspan=5 style='text-align: Right;'>").append("Thuế GTGT(" + response.vat + "%):"))
        .append($("<td style='text-align: Right;'>").append(Number(vat).toLocaleString())));
        
        $('.bodyprint').append($("<tr style='font-weight:bold;'>").append($("<td colspan=5 style='text-align: Right;'> ").append("Tổng thanh toán:"))
        .append($("<td style='text-align: Right;'>").append(Number(tongthanhtoan).toLocaleString())));
    });
}
function getInfoCustomer()
{
    //Tìm theo mã khách hoặc số điện thoại
    let makh = $("#input_makh").val();
    let sdt = $("#input_sdt").val();
    let code = '';
    if(makh=='')
    {
        code = sdt;
    }
    else
    {
        code = makh;
    }
    $.get('api/customer/' + code + '/info',
    function(response){
        if(response.message_code==200)
        {
            let res = response.data;
            $(".idcustomer").attr('dataid', res.id);
            $("#input_makh").val(res.makh);
            $("#input_tenkh").val(res.tenkh);
            $("#input_diachi").val(res.diachi);
            $("#input_sdt").val(res.sdt);
            $("#input_email").val(res.email);
            $("#diem").text(res.diemtichluy);
        }
    });
}

    function printPage() {
        
        var printContent = document.getElementById("printpage");
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = printContent.innerHTML;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
    }
    function inds() {
        var table = document.querySelector('#viewtable table');
        var heading = document.createElement('h2');
        heading.textContent = "DANH SÁCH HÓA ĐƠN BÁN HÀNG";
        table.parentNode.insertBefore(heading, table);
        var printContent = document.getElementById("viewtable");
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = printContent.innerHTML;
        window.print();
        document.body.innerHTML = originalContent;        
        location.href="listsaleinvoice";
    }
    

