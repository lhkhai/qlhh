function load(rowperpage = 10){
    $.get("http://localhost/qlhh/public/api/customer/" + rowperpage,
      function(data){  
        if(data.status_code == 200)  { 
          let customers = data.data.data;
        $.each(customers, function(i, value) {      
          //hiển thị nội dung ra view       
         let stt = i + 1;               
         let html = '<a  class="btnEdit" href="#" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalUpdate" ><img class="icon_edit" src="./icons/icon_edit.png" /></a>'                  
           html += '<a style="margin-left: 15px;" value="' + customers[i].id + '"  class="btnDelete" href="#" ><img value="' + customers[i].id + '"  class="icon_delete" src="/.icons/icon_delete.png" /></a>'                 
             
           $('#list_kh').append($("<tr>")
              .append($("<td>").addClass('idkh').append(customers[i].id))
              .append($("<td>").append(stt))
              .append($("<td>").append(customers[i].makh))
              .append($("<td>").append(customers[i].tenkh))
              .append($("<td>").append(customers[i].diachikh))
              .append($("<td>").append(customers[i].sdtkh))
              .append($("<td>").append(customers[i].emailkh))
              .append($("<td>").append(customers[i].ttthanhtoan))
              .append($("<td>").append(customers[i].ghichu))
              .append($("<td>").addClass('thaotac').append(html))
           );  
           
           
      }); 
    }
    else { 
          let empty_table = '<tr><td colspan="9" class="table_emmpty">' + data.message + '</td></tr>'
          $('#list_kh').append(empty_table);
        }
    });
};
//======================================================================//
function addRecord() {    
let txtmakh = $("input[name='makh']").val();
let txttenkh = $("input[name='tenkh']").val();
let txtdiachi = $("input[name='diachi']").val();
let txtsdt= $("input[name='sdt']").val();
let txtemail = $("input[name='email']").val();
let txtdiem = $("input[name='diemtichluy']").val();
let txtghichu = $("input[name='ghichu']").val();
$.post("http://localhost/qlhh/public/api/customer",
{
  "makh": txtmakh,
  "tenkh": txttenkh,
  "diachi": txtdiachi,
  "sdt": txtsdt,
  "email": txtemail,
  "diemtichluy": txtdiem,
  "ghichu": txtghichu
},
function(data,status){ 
  switch(data.message_code){
    case 111:
      alert(data.message);
      break;
      case 112:
      alert(data.message);
      break;
      case 500:
      alert(data.message);
      break;
      case 200:   
                
                let stt = data.len; 
                if(data.len == 1){
                  $('#myModal').modal('hide');
                  RefreshTable();
                  document.getElementById('formAdd').reset(); //reset form input
                } 
                else {             
                  $('#myModal').modal('hide'); 
                  notification(data.message);
                  document.getElementById('formAdd').reset(); //reset form input
                  $.get("http://localhost/qlhh/public/api/customer/" + txtmakh +"/find",
                  function(data){ 
                    $("tr:last").clone(true).appendTo("tbody");                        
                      $.each(data, function(i, item){   
                      
                      let tdEdit = '<a  class="btnEdit" value="' + item.id +'" href="#" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalUpdate" ><img class="icon_edit" src="./icons/icon_edit.png" /></a>'  ;                
                      let tdDel= '<a class="btnDelete" href="#" value="' + item.id +'" ><img class="icon_delete" src="./icons/icon_delete.png" /></a>' ; 
                      
                      $("tr:last").find("td").eq(0).text(stt);
                      $("tr:last").find("td").eq(1).text(item.makh);
                      $("tr:last").find("td").eq(2).text(item.tenkh);
                      $("tr:last").find("td").eq(3).text(item.diachi);
                      $("tr:last").find("td").eq(4).text(item.sdt);
                      $("tr:last").find("td").eq(5).text(item.email);
                      $("tr:last").find("td").eq(6).text(item.diemtichluy);                        
                      $("tr:last").find("td").eq(7).text(item.ghichu);
                      $("tr:last").find("td").eq(8).addClass("tdEditDel").html(tdEdit); 
                      $("tr:last").find("td").eq(9).html(tdDel);
                    });                        
                    //location.reload();                    
                    });  
  }
}
});      
}

$(document).ready ( function () { 
$(document).on("click",".btnEdit", function(){
let idkh = $(this).attr('value');
    index_row_update = $(this).parents("tr").index(); //create global var use for update function
     $.get("http://localhost/qlhh/public/api/customer/" + idkh,
    function(data){        
        $.each(data,function(i,item){
        $('#myModalUpdate').appendTo("body");
        $("input[name='Edit_idkh']").val(item.id);
        $("input[name='Edit_makh']").val(item.makh);
        $("input[name='Edit_tenkh']").val(item.tenkh);
        $("input[name='Edit_diachi']").val(item.diachi);
        $("input[name='Edit_sdt']").val(item.sdt);      
        $("input[name='Edit_email']").val(item.email);
        $("input[name='Edit_diemtichluy']").val(item.diemtichluy);
        $("input[name='Edit_ghichu']").val(item.ghichu);
        });    
    });    
});
$("#btnSave_Update").click(function(){
    UpdateCustomer(index_row_update); //call Updatecustomer function with parameters index tr
});
});

function UpdateCustomer(index_row_update)
{ 
let index_row = index_row_update + 1;
let txtidkh = $("input[name='Edit_idkh']").val();
let txtmakh = $("input[name='Edit_makh']").val();
let txttenkh = $("input[name='Edit_tenkh']").val();
let txtdiachikh = $("input[name='Edit_diachi']").val();
let txtsdtkh = $("input[name='Edit_sdt']").val();
let txtemailkh = $("input[name='Edit_email']").val();
let txtdiemtichluy = $("input[name='Edit_diemtichluy']").val();
let txtghichu = $("input[name='Edit_ghichu']").val();
$("#myModalUpdate").modal("hide");
$.post("http://localhost/qlhh/public/api/customer/" + txtidkh + "/edit",
  {
    "id": txtidkh,
    "makh": txtmakh,
    "tenkh": txttenkh,
    "diachi": txtdiachikh,
    "sdt": txtsdtkh,
    "email": txtemailkh,
    "diemtichluy": txtdiemtichluy,
    "ghichu": txtghichu
  },
  function(data,status){ 
    let customer = data.customer;        
    let tdEdit = '<a  class="btnEdit" value="'+ customer.id +'" href="#" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalUpdate" ><img class="icon_edit" src="icons/icon_edit.png" /></a>'                  
    let tdDel = '<a  value="' + customer.id + '" class="btnDelete" href="#" ><img class="icon_delete" value="' + customer.id + '" src="icons/icon_delete.png" /></a>'   
         $.each(customer, function(){    
                      $("tr").eq(index_row).find("td").eq(1).text(customer.makh);
                      $("tr").eq(index_row).find("td").eq(2).text(customer.tenkh);
                      $("tr").eq(index_row).find("td").eq(3).text(customer.diachi);
                      $("tr").eq(index_row).find("td").eq(4).text(customer.sdt);
                      $("tr").eq(index_row).find("td").eq(5).text(customer.email);
                      $("tr").eq(index_row).find("td").eq(6).text(customer.diemtichluy);                        
                      $("tr").eq(index_row).find("td").eq(7).text(customer.ghichu);
                      $("tr").eq(index_row).find("td").eq(8).html(tdEdit);
                      $("tr").eq(index_row).find("td").eq(9).html(tdDel);

                    });
        alert(data.message);
        location.reload(); 
        
        
  });

}
$(document).ready(function(){
$(document).on("click",".btnDelete", function(){
  let id = $(this).attr('value');
  if(confirm("Bạn có chắc muốn xóa không?")==true)
  {
    $.get("http://localhost/qlhh/public/api/customer/" + id + "/delete",
    function(data){
    alert(data.message);
    location.reload();
    });
  }
})
});

function notification(message)
{  
  $("#Modal_Notification").modal('show');
  $("#Modal_Notification").appendTo("body");
  $("#Notification_content").text(message);
};


