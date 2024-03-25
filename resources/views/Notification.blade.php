<style>
  #popup_noti {
    position: fixed;
    top: 5%;
    left: 37%;
    width: 25%;
    height: 150px;
    border: 1px solid #6C757D;
    background-color:white;
    border-radius: 5px;
  }
  #Noti_header {
    background-color: #007BFF;
    height: 40px;
    padding: 4px;
    color:white;
    padding-top:7px;
    padding-left:7px;
    
  }
  #Noti_body{    
    height: 70px;    
  }
  #Noti_footer{ height: 40px;
          background-color: #EEEEEE}
  #btnDismiss_Noti {   
   position: relative;
    margin-top: 3px;
    left:45%;
  }
  p{
    padding: 10px;  
  }
  </style>
<div  class="modal fade" id="Modal_Notification" role="dialog">
    <div class="modal-dialog" id='popup_noti'>         
        <div id="Noti_header" class="modal-content">
          <div class="#">
              <button style="color: white;" type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Thông báo</h4>
          </div>
        </div>
        <div  id="Noti_body"> 
          <p id='Notification_content'  for="text"></p>  
        </div>
        <div id="Noti_footer">
          <input id='btnDismiss_Noti' type="button" class="btn btn-primary" data-dismiss="modal" value="OK" />        
        </div>
    </div>
</div> 
