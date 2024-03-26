
function NumberKey(e) //only input number
    {
    const charCode = (e.which) ? e.which : keyCode;
    if(charCode > 47 && charCode < 58)
        return true;
    return false;
    }

function CheckNumberphone(id) //check number phone by id
    {
        let txtid = $("#" + id).val();    
        var regExp = /^(0[235789][0-9]{8}$)/;
        if (!regExp.test(txtid)) 
            alert('Số điện thoại không hợp lệ!');    
    }
function OpenModal(myModal)
    {   
        $('#' + myModal).appendTo("body");
        $('#' + myModal).modal('show');
    }
function str_to_currency(a) {
  a.value = a.value.replace(/\./g,""); //Loại bỏ dấu "." phần ngàn nếu có
  a.value = Number(a.value).toLocaleString();
    }
function currency_to_number(currency)
    {
    return parseFloat(currency.replace(/\./g,""));
    }
  
$(document).ready(function()
    { //hiển thị ảnh lớn trong trang product
        $('.imgProduct').hover (function (e) {
            const urlimg = $(this).attr('src');
            $('.large-image img').attr('src',urlimg);
            $(".large-image").appendTo('body');
            $('.large-image').toggle();
        });
    });
function getInfoProduct(index)
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
                    addRow();     
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

function getIndex() //Chạy lại cột số thứ tự
    {
        let rowCount = $('#TableProduct tr').length;
        for(i=1;i<rowCount;i++)
        {
            $('tr').eq(i).find('td').eq(0).text(i); 
        }    
    }
function addRow()
    { 
        let row = "<tr dataid=''><td class='STT_SP'></td><td><input class='input_masp' id='masp' onblur='getInfoProduct(this)' list='listproduct'\
                        placeholder='nhập mã sp' /></td><td class='tensp'></td><td></td><td></td><td><input class='input_soluong' onblur='Thanhtien($(this))' value=0 onkeypress='return NumberKey(event)' /></td>\
                        <td><input class='input_dongia' onblur='Thanhtien($(this))'oninput='str_to_currency(this);' onkeypress='return NumberKey(event)' value=0 /></td> \
                        <td class='thanhtien'><input id='showthanhtien' value=0 disabled /><img src='/icons/iconBtnDelete.png' onclick='RemoveRow($(this))' class='btnDeleteRow-hide' ></td></tr>" ;
                    /*  <td class='thanhtien'><input id='showthanhtien' value=0 disabled /><a href='#' onclick='RemoveRow($(this))' class='md-altTheme-theme'><img src='/icons/iconBtnDelete.png' class='btnDeleteRow-hide' ></a></td></tr>" */
        
        let check = $('#TableProduct tbody tr:last').find('td').eq(2).text();
        
        if(check!=""){
        $('#TableProduct tbody').append(row);
        }
    }
function RemoveRow(link) 
    {
        let rowindex = $(link).parents('tr').index();
        $('tr').eq(rowindex+1).remove();
        getIndex();
    }
function Thanhtien(index)
    {    
        let soluong = $(index).parents('tr').find('.input_soluong').val();
        let dongia = currency_to_number($(index).parents('tr').find('.input_dongia').val());       
        let thanhtien = soluong*dongia;
        $(index).parents('tr').find('#showthanhtien').val(thanhtien.toLocaleString());
        
    }
function currentDay ()
    {
        let today = new Date();
        let month = ("0" + (today.getMonth() + 1)).slice(-2);
        let day = ("0" + today.getDate()).slice(-2);
        today = today.getFullYear() + "-" + month + "-" + day;
        return today;
    };

function ShowModal(namemodal)
    {
       $("#" + namemodal).appendTo("body");
    }


function Themdong()
{ alert("đã gọi hàm");
    $('#tablesubpromotion').append($("<tr>")
              .append($("<td>").append("dfadf"))
              .append($("<td>").append("dkjfkal"))
              .append($("<td>").append("dfadf"))
              .append($("<td>").append("dkjfkal"))
              .append($("<td>").append("dfadf"))
              .append($("<td>").append("dkjfkal"))
           );
           alert('kt hàm'); 
}
function DeleteRow(link) 
{
    let rowindex = $(link).parents('tr').index();
    $('tr').eq(rowindex+1).remove();
    getIndex();
}