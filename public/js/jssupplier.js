function load(){
        $.get("http://localhost/qlhh/public/api/supplier/",
          function(data){  
            if(data.status_code == 200)  { 
              let suppliers = data.data.data;
            $.each(suppliers, function(i, value) {      
              //hiển thị nội dung ra view       
             let stt = i + 1;               
             let html = '<a  class="btnEdit" href="#" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalUpdate" ><img class="icon_edit" src="icons/icon_edit.png" /></a>'                  
               html += '<a style="margin-left: 15px;" value="' + suppliers[i].id + '"  class="btnDelete" href="#" ><img value="' + suppliers[i].id + '"  class="icon_delete" src="icons/icon_delete.png" /></a>'                 
                 
               $('#list_ncc').append($("<tr>")
                  .append($("<td>").addClass('idncc').append(suppliers[i].id))
                  .append($("<td>").append(stt))
                  .append($("<td>").append(suppliers[i].mancc))
                  .append($("<td>").append(suppliers[i].tenncc))
                  .append($("<td>").append(suppliers[i].diachincc))
                  .append($("<td>").append(suppliers[i].sdtncc))
                  .append($("<td>").append(suppliers[i].emailncc))
                  .append($("<td>").append(suppliers[i].ttthanhtoan))
                  .append($("<td>").append(suppliers[i].ghichu))
                  .append($("<td>").addClass('thaotac').append(html))
               );  
               
               
          }); 
        }
        else { 
              let empty_table = '<tr><td colspan="9" class="table_emmpty">' + data.message + '</td></tr>'
              $('#list_ncc').append(empty_table);
            }
        });
};
//======================================================================//
function addSupplier() {    
    
    let txtmancc = $("input[name='mancc']").val();
    let txttenncc = $("input[name='tenncc']").val();
    let txtdiachincc = $("input[name='diachincc']").val();
    let txtsdtncc = $("input[name='sdtncc']").val();
    let txtemailncc = $("input[name='emailncc']").val();
    let txtttthanhtoan = $("input[name='ttthanhtoan']").val();
    let txtghichu = $("input[name='ghichu']").val();
    
    $.post("http://localhost/qlhh/public/api/supplier",
    {
      "mancc": txtmancc,
      "tenncc": txttenncc,
      "diachincc": txtdiachincc,
      "sdtncc": txtsdtncc,
      "emailncc": txtemailncc,
      "ttthanhtoan": txtttthanhtoan,
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
                      document.getElementById('formAddNcc').reset(); //reset form input
                    } 
                    else {             
                      $('#myModal').modal('hide'); 
                      notification(data.message);
                      document.getElementById('formAddNcc').reset(); //reset form input
                      $.get("http://localhost/qlhh/public/api/supplier/" + txtmancc +"/find",
                      function(data){ 

                        $("tr:last").clone(true).appendTo("tbody");                        
                          $.each(data, function(i, item){   
                          let html = '<a  class="btnEdit" value="' + item.id +'" href="#" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalUpdate" ><img class="icon_edit" src="./icons/icon_edit.png" /></a>'                  
                           html += '<a style="margin-left: 15px;" class="btnDelete" href="#" value="' + item.id +'" ><img class="icon_delete" src="./icons/icon_delete.png" /></a>'   
                          $("tr:last").find("td").eq(0).text(stt);
                          $("tr:last").find("td").eq(1).text(item.mancc);
                          $("tr:last").find("td").eq(2).text(item.tenncc);
                          $("tr:last").find("td").eq(3).text(item.diachincc);
                          $("tr:last").find("td").eq(4).text(item.sdtncc);
                          $("tr:last").find("td").eq(5).text(item.emailncc);
                          $("tr:last").find("td").eq(6).text(item.ttthanhtoan);                        
                          $("tr:last").find("td").eq(7).text(item.ghichu);
                          $("tr:last").find("td").eq(8).html(html); 
                        });                        
                       
                        });  
      }
    }
    });      
}

$(document).ready ( function () { 
  $(document).on("click",".btnEdit", function(){
    let idncc = $(this).attr('value');
        idx_update_supp = $(this).parents("tr").index(); //create global var use for update function
         $.get("/api/supplier/" + idncc,
        function(data){        
            $.each(data,function(i,item){
            $('#myModalUpdate').appendTo("body");
            $("input[name='Edit_idncc']").val(item.id);
            $("input[name='Edit_mancc']").val(item.mancc);
            $("input[name='Edit_tenncc']").val(item.tenncc);
            $("input[name='Edit_diachincc']").val(item.diachincc);
            $("input[name='Edit_sdtncc']").val(item.sdtncc);      
            $("input[name='Edit_emailncc']").val(item.emailncc);
            $("input[name='Edit_ttthanhtoan']").val(item.ttthanhtoan);
            $("input[name='Edit_ghichu']").val(item.ghichu);
            });    
        });    
    });
    $("#btnEditNcc").click(function(){
        UpdateSupplier(idx_update_supp); //call UpdateSupplier function with parameters index tr
    });

 
});
function UpdateSupplier(index)
{  
    let txtidncc = $("input[name='Edit_idncc']").val();
    let txttenncc = $("input[name='Edit_tenncc']").val();
    let txtdiachincc = $("input[name='Edit_diachincc']").val();
    let txtsdtncc = $("input[name='Edit_sdtncc']").val();
    let txtemailncc = $("input[name='Edit_emailncc']").val();
    let txtttthanhtoan = $("input[name='Edit_ttthanhtoan']").val();
    let txtghichu = $("input[name='Edit_ghichu']").val();
    $("#myModalUpdate").modal("hide");
    $.post("http://localhost/qlhh/public/api/supplier/" + txtidncc + "/edit",
      {
        "id": txtidncc,
        "tenncc": txttenncc,
        "diachincc": txtdiachincc,
        "sdtncc": txtsdtncc,
        "emailncc": txtemailncc,
        "ttthanhtoan": txtttthanhtoan,
        "ghichu": txtghichu
      },
      function(data,status){ 
        let supplier = data.supplier;   
        let html = '<a  class="btnEdit" value="'+supplier.id +'" href="#" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalUpdate" ><img class="icon_edit" src="./public/icons/icon_edit.png" /></a>'                  
            html += '<a style="margin-left: 15px;" value="' + supplier.id + '" class="btnDelete" href="#" ><img class="icon_delete" src="./icons/icon_delete.png" /></a>'   
             $.each(supplier, function(){                         
                          //$("tr").eq(idx_update_supp).find("td").eq(0).text(supplier.id);
                          $("tr").eq(idx_update_supp).find("td").eq(1).text(supplier.mancc);
                          $("tr").eq(idx_update_supp).find("td").eq(2).text(supplier.tenncc);
                          $("tr").eq(idx_update_supp).find("td").eq(3).text(supplier.diachincc);
                          $("tr").eq(idx_update_supp).find("td").eq(4).text(supplier.sdtncc);
                          $("tr").eq(idx_update_supp).find("td").eq(5).text(supplier.emailncc);
                          $("tr").eq(idx_update_supp).find("td").eq(6).text(supplier.ttthanhtoan);                        
                          $("tr").eq(idx_update_supp).find("td").eq(7).text(supplier.ghichu);
                          $("tr").eq(idx_update_supp).find("td").eq(8).html(html); 
                        });
            notification(data.message); 
            location.reload();           
            
      });

}
$(document).ready(function(){
    $(document).on("click",".btnDelete", function(){
      let id = $(this).attr('value');
      if(confirm("Bạn có chắc muốn xóa không?")==true)
      {
        $.get("http://localhost/qlhh/public/api/supplier/" + id + "/delete",
        function(data){
        alert(data.message);
        location.reload();
        });
      }
    })
  });
function RefreshTable() {
 //location.reload();
 $(".list_ncc").DataTable.ajax.reload();
}
function notification(message)
{  
  $("#Modal_Notification").modal('show');
  $("#Modal_Notification").appendTo("body");
  $("#Notification_content").text(message);
 
};
