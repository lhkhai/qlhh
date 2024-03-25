
function update(id) {    
  $('#myModalUpdate').appendTo("body");
  $.get("/api/product/" + id + "/show",
      function(data){    
           
        $.each(data,function(i,item){  
        $("input[name='masp_edit']").val(item.masp);
        $("input[name='tensp_edit']").val(item.tensp);
        $("#categories_id_edit").val(item.categories_id);
        $("#chatlieu_edit").val(item.chatlieu); 
        $("#donvi_edit").val(item.donvi);
        $("input[name='kichthuoc_edit']").val(item.kichthuoc);
        $("input[name='giaban_edit']").val(item.giaban);
        $("input[name='soluong_edit']").val(item.soluong);
        $("#mota_edit").val(item.mota);  
        $("#spnoibat_edits").val(item.spnoibat);
        $("#spmoi_edit").val(item.spmoi);
        $("input[name='mota_edit']").val(item.mota);           
        });        
        
        
    });  
    $('#formEdit').on('submit', function (e) {
      e.preventDefault();  
       $('#myModalUpdate').modal('hide');
       var formData = new FormData(document.getElementById('formEdit'));
        $.ajax({        
           url: '/api/product/' + id +'/update', 
           type: 'POST',
           data: formData,
           contentType: false,
           processData: false,
           success: function (response) {
            
               if(response.message_code==200)
               {
                 alert(response.message);
                 location.reload();
               }
               else {
                 alert(response.message);                 
               }
           } ,
           error: function (xhr, status, error) {
              alert('Lỗi: ' + error);
           } 
       }); 
     
    });
};

$(document).ready(function () {
  $('#formAdd').on('submit', function (e) {
     e.preventDefault(); /*ngăn chặn sự kiện chuyển tiếp link của form*/ 
      var formData = new FormData(this);
      //var formData = new FormData(document.getElementById('formAdd'))
      $('#myModal').modal('hide');
      $.ajax({
          url: '/api/product', 
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
             
              if(response.message_code==200)
              {
                alert(response.message);
                location.reload();
              }
              else {
                alert(response.message);
              }
          },
          error: function (xhr, status, error) {
              console.log('Lỗi: ' + error);
          }
      });
    
 });
});

function destroy(id){
 
  if(confirm("Bạn có chắc muốn xóa không?")==true)
  {
    $.get("http://localhost/qlhh/public/api/product/" + id + "/delete",
    function(data){
    alert(data.message);
    location.reload();
    });
  }
}

$(document).ready(function() { //sort giá trị theo từng cột
    
    $("#title_table th").click(function() {
      var table = $(this).parents('table').eq(0);        
      var columnIndex = $(this).index();
      var rows = table.find('tr:gt(0)').toArray().sort(comparator(columnIndex));
        this.asc = !this.asc;
        if (!this.asc) { rows = rows.reverse(); }
        for (var i = 0; i < rows.length; i++)
         {
             table.append(rows[i]);
         }
         updateIndexColumn();
    });
    function comparator(index) {       
            return function(a, b) {            
                var valA = getCellValue(a, index);
                var valB = getCellValue(b, index);
                return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB);
            };       
    }
    function getCellValue(row, index) {  
        if(index==10)
        {         
           return $(row).children('td').eq(index).attr('value');  
        }      
         return $(row).children('td').eq(index).text();          
        
    }
    function updateIndexColumn() {
    $('#title_table tbody tr').each(function (index) {
      $(this).children('td').eq(0).text(index + 1);
    });
    }
  });
  