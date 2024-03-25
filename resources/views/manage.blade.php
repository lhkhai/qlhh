
<!DOCTYPE HTML>
<html lang='en'>
<head>
    <meta charset="UTF-8" />
    @section('title') Administrator @endsection
    <title>@yield('title')</title>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="GallerySoft.info" />   
    <link rel="icon" href="/icons/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/icons/favicon.ico" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!--Boostrap 3 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" /> <!--Use icon -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>     
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script type="text/javascript" src="{{asset('/js/jsFunction.js')}}" ></script>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/cssAdmin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/cssGeneral.css')}}">
    <style>


</style>
</head>

<body style="background-color:#F5F8FD"> 
    
    <div class='container'>
       <div class='navigation'> 
            <ul>
                <li class="list" >
                    <a href="{{asset('/manage')}}">
                        <span class="icon" title='Trang chủ'><img src="{{asset('/icons/icon_home.png' )}}" /></span>
                        <span class="title">Trang chủ</span>
                    </a>
                </li>
                <li class="list">
                    <a href="#">
                        <span class="icon" title='Đơn hàng' ><img src="{{asset('/icons/icon_order.png' )}}" /></span>
                        <span class="title">Đơn hàng</span>
                    </a>
                </li>
                <li class="list">
                    <a href="{{asset('sales')}}">
                        <span class="icon" title='Bán hàng'><img src="{{asset('/icons/icon_sell.png' )}}" /></span>
                        <span class="title">Bán hàng</span>
                    </a>
                </li>
                <li class="list">
                    <a href="#">
                        <span class="icon" title='Danh mục'><img src="{{asset('/icons/icon_list.png' )}}"  /></span>
                        <span class="title">Danh mục</span>
                    </a>
                    <ul class="icon_sub">
                        <li><a title='DS Nhà cung cấp' href="{{asset('supplier')}}" ><img  src="{{asset('/icons/icon_supplier_black.png')}}"><span>Nhà cung cấp</span></a></li>
                        <li><a title='DS Khách hàng' href="{{asset('customer')}}" ><img  src="{{asset('/icons/icon_customer_black.png')}}"><span >Khách hàng</span></a></li>
                        <li><a title='Danh mục' href="{{asset('categories')}}"><img  src="{{asset('/icons/icon_category_black.png')}}"><span>Nhóm Sản phẩm</span></a></li>
                        <li><a title='DS Sản phẩm' href="{{asset('product')}}"><img src="{{asset('/icons/icon_product_black.png')}}"><span>Sản phẩm</span></a></li>
                    </ul>
                </li>
                <li class="list">
                    <a href="{{asset('purchaseorder')}}">
                        <span class="icon" title='Đặt hàng'><img src="{{asset('/icons/icon_purchaseorder_whtie.png' )}}"   /></span>
                        <span class="title">Đặt hàng</span>
                    </a>
                </li>
                <li class="list">
                    <a href="{{asset('/purchaseinvoice')}}">
                        <span class="icon" title='Nhập hàng'><img src="{{asset('/icons/icon_buy.png' )}}"   /></span>
                        <span class="title">Nhập hàng</span>
                    </a>
                </li>
                <li class="list">
                    <a href="{{asset('/setprice')}}">
                        <span class="icon" title='Định giá'><img src="{{asset('/icons/icon_setprice_white.png' )}}"   /></span>
                        <span class="title">Định giá</span>
                    </a>
                </li>
                <li class="list">
                    <a href="{{asset('promotion')}}">
                        <span class="icon" title='Chương trình khuyến mãi'><img src="{{asset('/icons/icon_promotion_white.png' )}}"   /></span>
                        <span class="title">Khuyến mãi</span>
                    </a>
                </li>
                <li class="list">
                    <a href="report">
                        <span class="icon" title='Thống kê'><img src="{{asset('/icons/icon_chart.png' )}}"   /></span>
                        <span class="title">Thống kê</span>
                    </a>
                </li>
                <li class="list">
                    <a href="#">
                        <span class="icon" title='Đăng xuất'><img src="{{asset('/icons/icon_logout.png' )}}"  /></span>
                        <span class="title">Đăng xuất</span>
                    </a>
                </li>
            </ul>

        </div>
        <div class="toggle">
            <img class="open" src="{{asset('/icons/icon_menu.png')}}" />
            <img class="close" src="{{asset('/icons/icon_close.png')}}" />
        </div>
        <div class='content'>
        @hasSection('content')
            @yield('content')
        @endif

        @sectionMissing('content')
        <div class="imgbackground"><img src="{{asset('/icons/background-admin.jpg')}}" /></div>
        @endif
        </div> <!--content -->
        <div id='footer'>
            
        </div> <!--footer -->

    </div>
    
</body>
@php
    $id = 1;
    session()->put('user', 'Nguyễn Hồng Phượng');
    session()->put('IdUser', $id);
@endphp
@include('Notification') <!--Include notification page -->
<script>
    let menuToggle = document.querySelector('.toggle');
    let divContent = document.querySelector('.content');
    let divNavigation = document.querySelector('.navigation');    
    menuToggle.onclick = function(){
        menuToggle.classList.toggle('active');
        divNavigation.classList.toggle('active');
        divContent.classList.toggle('active');
    }
    </script>
    
</html>