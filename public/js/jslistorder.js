function openmodalview(maddh,idpo,tenncc,ngaydat,ngaygiao)
{  
    
    $(".bodyprint").empty(); //clear history when call function
    $('#modalview').appendTo("body");
    $("#name_supplier").text(tenncc);
    $("#madonhang").text(maddh);
    var formattedDate = moment(ngaygiao).format("DD/MM/YYYY");    
    $("#ngaygiao").text(formattedDate);
    var newdate = new Date(ngaydat);
    var ngay = newdate.getDate();
    var thang = newdate.getMonth() + 1;
    var nam = newdate.getFullYear();
    $("#ngay").text(ngay);
    $("#thang").text(thang);
    $("#nam").text(nam);
    $.get('/api/purchaseorder/find/' + idpo,
    function(data){

        var list = data.listproduct;
        $("#sodon").text(data.sodon);
        $.each(list, function(key,value){
            let stt = key + 1;
            let dongia = Number(list[key].dongia).toLocaleString();
            let thanhtien = Number(list[key].soluong*list[key].dongia).toLocaleString();   
            $('.bodyprint').append($("<tr>")
                .append($("<td>").append(stt))
                  .append($("<td>").append(list[key].tensp))
                  .append($("<td>").append(list[key].donvi))
                  .append($("<td>").append(list[key].soluong))
                  .append($("<td>").append(dongia))
                  .append($("<td>").append(thanhtien))
               ); 
        });
    });
}
