const { map } = require("lodash");

function stockin(event){
        event.preventDefault();

        var currentUrl = window.location.href;
        var url = new URL(currentUrl);
        var pathname = url.pathname;
        var part = pathname.split("/");
        if(part.length==3) //Lấy mã đơn đặt hàng thông qua link
        {
            var poid = part[2];
        }
        else {
            var poid = ""; 
        }        
        let idsupplier = $('#input_supplier').val();
        let kyhieuhd = $("#input_kyhieu_hd").val();
        let sohoadon = $("#input_sohd").val();
        if(kyhieuhd =="" || sohoadon == "")
        {
            alert("Cần nhập đầy đủ các thông tin bắt buộc!");
            return;
        }
        let ngaylap = $("#input_ngaylap_hd").val();        
        let vat = $('#input_vat').val();
        let ngaynhapkho = $("#input_ngaynhap").val();        
        let ghichu = $("#ghichu").val();
        let staff_id = $("#nguoinhap").attr('dataid');
        let listproduct = [];
        let lentable = $("#TableProduct tr").length;
        for(let i = 1; i < lentable-1 ;i++)
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
            let price = row.find('.input_dongia').val();
            let dongia = convert_to_number(price);
            listproduct.push([id,soluong,dongia]);
        }
       $.post('/api/purchaseinvoice/stockin',
             {
                "idsupplier" : idsupplier,
                "kyhieuhd" : kyhieuhd,
                "sohoadon" : sohoadon,
                "ngaylap" : ngaylap,
                "vat" : vat,
                "ngaynhapkho" : ngaynhapkho,
                "ghichu" : ghichu,                
                "staff_id" : staff_id,
                "listproduct": listproduct,
                "poid": poid
             },
             function(response){
                alert(response.message);
                if(poid=='')
                {
                    location.href = '/purchaseinvoice';
                }
                else {
                    location.href='/listorder';
                }
                
             })
    }
function formatCurrency(input) {     
      var value = parseFloat(input.value);       
      if (!isNaN(value)) {       
        var formattedValue = value.toLocaleString();
        input.value = formattedValue;
      }
    } 
$(document).ready(function(){ //Hiển thị dấu chấm phần ngàn khi load đơn hàng nhập
    let kq=0;
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
});
function CopyRow()
{ 
    let row = "<tr dataid=''><td class='STT_SP'></td><td class='tdmasp'><input class='input_masp' id='masp' onblur='InfoProduct(this)' list='listproduct'\
                    placeholder='nhập mã sp' /></td><td class='tensp'></td><td></td><td></td><td class='tdsoluong'><input class='input_soluong' onkeyup='str_to_currency(this);' oninput='SumInvoice($(this))' value=0 onkeypress='return NumberKey(event)' /></td>\
                    <td class='tddongia'><input class='input_dongia' oninput='SumInvoice($(this))' onkeyup='str_to_currency(this);' onkeypress='return NumberKey(event)' value=0 /></td> \
                    <td class='thanhtien'><input class='inputcurrency' id='showthanhtien' value=0 disabled /><img src='/icons/iconBtnDelete.png' onclick='RemoveRow($(this))' class='btnDeleteRow-hide' ></td></tr>" ;
                   
    let len = $('#TableProduct tbody tr').length;
    let check = $('tr').eq(len-1).find('td').eq(2).text();
    $('#TableProduct tbody').append(row);
}
function InfoProduct(index)
{ 
    let masp = $(index).val();
    let indextr = $(index).closest('tr').index();
    let list = document.getElementsByClassName('input_masp');  
    for(var i = 0; i<list.length - 1; i++)
    {
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
            if (response.message_code == 200) {
                $.each(product, function (key, value) {
                    let currentRow = $('tbody tr').eq(indextr);
                    currentRow.attr('dataid', value.id);
                    currentRow.find('td').eq(2).text(value.tensp);
                    currentRow.find('td').eq(3).text(value.chatlieu);
                    currentRow.find('td').eq(4).text(value.donvi);
                    currentRow.find('img').removeClass('btnDeleteRow-hide');
                    currentRow.find('img').addClass('btnDeleteRow-show');
                }); 
                let check = $('tr:last').find('td').eq(2).text();
                if (check!="") {                                        
                CopyRow();
                getIndex();               
                }
                              
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 429) {
                console.log('Quá nhiều yêu cầu, đang chờ và thử lại sau.');                 
            }            
        }
    });
} 
function SumInvoice(index)
{    
     let soluong =convert_to_number($(index).parents('tr').find('.input_soluong').val());
     let dongia = convert_to_number($(index).parents('tr').find('.input_dongia').val());       
     let thanhtien = soluong*dongia;
     $(index).parents('tr').find('.inputcurrency').val(thanhtien.toLocaleString());
     Total();
     
     

}
function Total()
    {
        
        let total = 0;     
        let row = $("#TableProduct tbody tr");
        let len = $("#TableProduct tbody tr").length;
        for(i=0;i<len ;i++)
        {
           let tt = row.eq(i).find('.inputcurrency').val();          
           total = total + convert_to_number(tt);
         } 
         
         let vat = $("#input_vat").val();         
         let sumvat = total + total*vat/100;
         $(".LabelTotal").text(total.toLocaleString());
         $(".LabelTotalVat").text(sumvat.toLocaleString());
         return total;
       
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