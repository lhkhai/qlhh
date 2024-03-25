<div class="modal fade" id="modalprint" role="dialog">
    <div class='container'>
        <div class='modal-dialog modal-lg' style="background-color:white;" id='viewpurchaseorder'>
            <button style="color: black;font-weight:bold;" type="button" class="close" data-dismiss="modal">&times;</button>
            <button onclick='printPage()' id='btnprintddh'  style="position: fixed;top:20px;right:10px;height: 30px;width:150px;">in phiếu</button>
            <div id='printpage'>  
                <style>
                    #saleinvoicedetail td:nth-child(1),
                    #saleinvoicedetail td:nth-child(3)
                    {
                        text-align: center;
                    }
                    #saleinvoicedetail td:nth-child(4),
                    #saleinvoicedetail td:nth-child(5),
                    #saleinvoicedetail td:nth-child(6)
                    {
                        text-align: right;
                    }
                    #logo {
                        height: 100px;
                        width:100px;
                    }
                    .titleshop h4, .titleshop h6 {
                        font-weight: bold;
                        text-align:center;
                    }
                    .titleshop {
                        margin-top: 40px;
                    }
                    #saleinvoicedetail .endline td {
                        font-weight: bold;
                        text-align: right;
                    }
                    #printfooter {
                        margin-top:40px;
                        font-size:24px;
                        text-align: center;
                        font-family: "Brush Script MT";
                        margin-bottom: 20px;
                    }
                </style>              
                <div class="titleshop">
                    <table id='tabletitle'>
                        <tr>
                            <td><img id='logo' src='{{asset("/icons/logoshop.png")}}' ></td>
                            <td style='padding-left: 10px;'>
                                <b>JAMIN COMPANY</b><br>
                                <b style='font-size: 12px;'>Addr:</b> 123 Hùng Vương, An Lạc,                                  
                                <br>&nbsp &nbsp &nbsp &nbsp &nbsp Bình Tân, TP. Hồ Chí Minh<br>
                                <b>Tel:</b> &nbsp &nbsp 0939123123
                            </td>                            
                        </tr>
                    </table>                
                    <p>                       
                        <h4>HÓA ĐÓN BÁN HÀNG</h4>
                        <h6 >Mã phiếu: <span id='maphieuxuat'></span>
                        <br>Ngày bán: <span id='ngayban'></span> </h6>
                    </p>
                    <b>Khách hàng: </b> <span id='lblcustomer'> Nguyễn Văn A</span> <br>
                    <b>Địa chỉ: </b> <span id='lbladdr'>Hòa An, Phụng Hiệp Hậu Giang </span> <br>
                    <b>Số điện thoại: </b><span id='lbltel'> 0939123456</span> <br>
                    <b>Điểm tích lũy: </b> <span id='lblscore'>10 </span> <br>
                </div>
                <table id='saleinvoicedetail' class='table table-bordered' style='margin-right:20px;'>
                    <thead><tr><th style='width:5%;'>STT</th><th>Tên sản phẩm</th><th style='width:10%;text-align:center;'>ĐVT</th><th style='width:10%;'>SL</th><th style='width:10%;text-align:right;'>Đơn giá</th><th style='width:15%;text-align:right;'>Thành tiền</th></tr></thead>
                    <tbody class='bodyprint'>
                      
                    </tbody>                    
                </table> 
                 <div id='printfooter'>Cảm ơn Quí khách.<br>Hẹn gặp lại!!!</div>             
            </div>
        </div>
    </div>    
</div>