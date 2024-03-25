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
/* function OpenModal()
{
    $('#myModal').appendTo("body");
} */
  
function addRecord() {    
    let manhom = $("input[name='manhom']").val();
    let tennhom = $("input[name='tennhom']").val();
    let diengiai = $("input[name='diengiai']").val();
    $('#myModal').modal('hide'); 
    $.post("http://localhost/qlhh/public/api/categories",
    {
      "manhom": manhom,
      "tennhom": tennhom,
      "diengiai": diengiai  
    },
    function(data){ 
      
      switch(data.code){
        case 202:
          alert(data.message);
          break;
          case 500:
          alert(data.message);
          break;
          case 201:    
                  alert(data.message);
                  document.getElementById('formAdd').reset(); //reset form input
                  location.reload();  
      }
    });      
}
function update(idnhom) {    
  $('#myModalUpdate').appendTo("body");
  //let idnhom = $(this).attr('value');
  $.get("http://localhost/qlhh/public/api/categories/" + idnhom + "/show",
      function(data){        
        $.each(data,function(i,item){
        
        $("input[name='idnhom']").val(item.id);
        $("input[name='manhom_edit']").val(item.manhom);
        $("input[name='tennhom_edit']").val(item.tennhom);
        $("input[name='diengiai_edit']").val(item.diengiai);            
        });    
    });  
    $("#btnSave_Update").click(function(){
      let idnhom = $("input[name='idnhom']").val();
      let manhom = $("input[name='manhom_edit']").val();
      let tennhom = $("input[name='tennhom_edit']").val();
      let diengiai = $("input[name='diengiai_edit']").val();
      $("#myModalUpdate").modal("hide");
      $.post("http://localhost:8000/api/categories/" + idnhom + "/update",
        {
          "id": idnhom,
          "manhom": manhom,
          "tennhom": tennhom,
          "diengiai": diengiai
        },
        function(data){
              alert(data.message);
              location.reload(); 
        });
    });  
};
function destroy(id)
{
  if(confirm("Bạn có chắc muốn xóa không?")==true)
  {
    $.get("http://localhost:8000/api/categories/" + id + "/delete",
    function(data){
    alert(data.message);
    location.reload();
    });
  }

}

function notification(message)
{  
$("#Modal_Notification").modal('show');
$("#Modal_Notification").appendTo("body");
$("#Notification_content").text(message);

};


    