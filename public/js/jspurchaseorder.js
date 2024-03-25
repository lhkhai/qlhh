
    function getProductDetails() { //gọi API đổ dữ liệu vao datalist
        var idSupplier = document.getElementById('masp').value;       
        $.ajax({
            type: 'POST',
            url: 'api/product/pddetails',
            data: { masp: idSupplier },
            success: function(response) {
                var spDetails = response.product;
                $("#listproduct").empty(); // Clear previous options
                $.each(spDetails, function(index, spDetail) {
                    $("#listproduct").append('<option value="' + spDetail.masp + '">');
                });                
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    }

function getIndex() //Chạy lại cột số thứ tự
{
    let rowCount = $('#TableProduct tr').length;
    for(i=1;i<rowCount;i++)
    {
        $('tr').eq(i).find('td').eq(0).text(i); 
    }    
}

 function getInfoSupplier(link)
{
    let mancc = $(link).val();
    $.get('api/supplier/' + mancc +'/find',
    function(response){
        let supplier = response.data;    
            $('#idsupplier').val(supplier.id);    
            $('#mancc').val(supplier.mancc);
            $('#sdt').val(supplier.sdtncc);
            $('#diachi').val(supplier.diachincc);
    });
} 
//Gửi đơn hàng
$(document).ready(function(){
    let today = new Date(); //Set ngày hiện tại cho input ngày
    let formatDay = today.toISOString().split('T')[0];
    $('#ngaydat').val(formatDay);
    $('#ngaygiao').val(formatDay);
    $('#btn_dathang').on('click',function(){        
        let idsupplier = $('#idsupplier').val();
        let mancc = $('#mancc').val();
        let ngaydat = $('#ngaydat').val();
        let ngaygiao = $('#ngaygiao').val();
        let staff_id = $('#nguoilap').attr('dataid');
        let ghichu = $('#ghichu').val();
        let listproduct = [];
        let lenTable = $('#TableProduct tr').length;  
        if(mancc=="")
        {
            alert("Vui lòng chọn nhà cung cấp");
        }
        for(let i = 1; i<lenTable-1; i++)
        {
            let idsp = $('tr').eq(i).attr('dataid');
            let soluong = $('tr').eq(i).find('.input_soluong').val();
            let dongia =currency_to_number($('tr').eq(i).find('.input_dongia').val());
            if(soluong==0)
            { 
                
                $('tr').eq(i).find('.input_soluong').addClass('input_soluong_0');//('border', '1px solid red');
                setTimeout(function () {
                    alert("Vui lòng nhập số lượng");
                }, 200);
                return;
            }
            else {
                $('tr').eq(i).find('.input_soluong').removeClass('input_soluong_0');
                listproduct.push([idsp,soluong,dongia]);
            }
            
                
        } 
        $.post('api/purchaseorder/order', //Gửi danh sách đặt hàng qua API xử lý
        {
            'idsupplier': idsupplier,
            "mancc": mancc,
            "ngaydat": ngaydat,
            "ngaygiao":ngaygiao,
            "staff_id": staff_id,
            "ghichu": ghichu,
            "listproduct": listproduct
        },
        function(response){
            alert(response.message);
            location.reload();
        }) ;
    });  
});


