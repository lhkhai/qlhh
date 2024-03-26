function clo_open_promotion(id)
{
    $.get('api/promotion/clopen/' + id,
    function(response){
        location.reload();
    });
}
function event_promotion(){ //Tùy theo loại khuyến mãi sẽ hiển thị form khuyenmaihd hay kmsp
    $('#viewpromotion').appendTo("body");
    $('#viewpromotion').modal('show');
    let maloai = $('#txtloaikm').val();
    var data;
    if(maloai==1){
        data = document.getElementById('khuyenmaihd');
    } else if(maloai==2)
    {
        data = document.getElementById('modalKMSP');
    }
    else {
        $("#dskhuyenmai").empty();
    }
    document.getElementById('dskhuyenmai').innerHTML = data.innerHTML;
}   
$(document).ready(function(){
        $("#txtloaikm").on('change',function(){
            var loaikm = $("#txtloaikm").val();
            if(loaikm ==2){
                $("#modalKMSP").appendTo("body");
            }
        });  
});


function viewpromotion() 
{
    $('#viewpromotion').appendTo("body");
}

function xoadong(link)
{
   
    let rowindex = $(link).closest('tr').index();
    $('#tbodypromotion tr').eq(rowindex).remove();
    LoadIndex();
}
function LoadIndex()
{
    let rowCount = $('#tbodypromotion tr').length;
    for(i=0;i<rowCount;i++)
    {
        $('#tbodypromotion tr').eq(i).find('td').eq(0).text(i+1); 
    }  
}
function LoadProduct(index)
{ 
    
    let masp = $(index).val();
    let indextr = $(index).closest('tr').index();
    if(masp == '')
    {
        let currentRow = $('tbodypromotion tr').eq(indextr);
        currentRow.attr('dataid', "");
        currentRow.find('td').eq(2).text('');
        currentRow.find('td').eq(3).text('');
        currentRow.find('td').eq(4).text('');                
              
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
                        let currentRow = $('#tbodypromotion tr').eq(indextr);               
                        currentRow.attr('dataid', value.id);
                        currentRow.find('td').eq(2).text(value.tensp);            
                        currentRow.find('td').eq(3).text(value.donvi);
                        currentRow.find('img').removeClass('btnDelRow-hide');
                        currentRow.find('img').addClass('btnDelRow-show');
                    }); 
                    var check = $("#tbodypromotion tr:last").find('td').eq(2).text();
                    if(check!="")
                    {
                        
                        $("#tbodypromotion tr:last").clone('true').appendTo("#tbodypromotion");
                        $("#tbodypromotion tr:last").find("td").eq(1).find('input').val("");
                        $("#tbodypromotion tr:last").find("td").eq(2).text(null);
                        $("#tbodypromotion tr:last").find("td").eq(3).text(null);
                    }                   
                                       
                    LoadIndex(); 
                                
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
$(document).ready(function()
{
   // $("#SavePromotion").on('click',function(){alert('gọi hàm lưu');});
    
});