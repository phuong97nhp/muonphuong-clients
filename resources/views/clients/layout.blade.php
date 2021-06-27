<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('public/clients/library/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/clients/library/datatables/css/dataTables.foundation.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/clients/library/datatables/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/clients/library/jquery-ui-themes/themes/base/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/clients/library/jquery-ui/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/clients/my/styles/all.css')}}">
    <script>
        var url_base = '{{asset('/')}}';
    </script>
</head>

<body>
    <header id="headerContainer" class="container-fluid">
        <nav id="mainMenu" class="row">
            <ul class="nav col">
                <li class="nav-item">
                    <a class="nav-link active" href="{{asset('/')}}"> 
                        <img id="logo" src="{{asset('public/clients/images/logo.png')}}" alt="Logo
                                azexpress.com.vn">
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Mục lục</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{asset('/tao-don-van')}}">Tạo đơn
                                vận</a>
                        <a class="dropdown-item" href="{{asset('/theo-doi-don-van')}}">Theo
                                dõi đơn vận</a>
                        <a class="dropdown-item" href="{{asset('/them-dia-chi')}}">Thêm địa chỉ</a>
                </li>
            </ul>
            <ul class="nav justify-content-center col-3 py-1">
                <!-- <div class="input-group">
                    <input type="text" class="form-control form-control-sm" placeholder="Nhầp mã bill">
                    <div class="input-group-append">
                        <button class="btn btn-success btn-sm" type="submit">Tìm</button>
                    </div>
                </div> -->
            </ul>
            <ul class="nav justify-content-end col-3">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="login.html">Chào: {{Auth::user()["full_name"]}}</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{asset('/thong-tin-tai-khoan')}}">Thông tin tài khoản</a>
                        <a class="dropdown-item" href="{{asset('/doi-mat-khau')}}">Đổi mật khẩu</a>
                        <a class="dropdown-item" href="{{asset('/dang-xuat')}}">Đăng xuất</a>
                </li>
            </ul>
        </nav>
    </header>
    
    @yield('mainContainer')

    <footer id="footerContainer" class="container-fluid">
        <div class="row">
            <div class="author col">
                <p class="text-center mt-2" id="copy-righter">Bản quyền thuộc về &copy; <a target="_back" href="http://azexpress.com.vn/">AZExpress</a> - Version <a style="color: #ffc400" href="/phien-ban">1.0.0</a> - By team<a style="color: #ffc400" href="/phien-ban"> Nguyễn Hoàng Phương</a></p>
            </div>
        </div>
    </footer>
</body>

<script src="{{asset('public/clients/library/jquery/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('public/clients/library/jquery/popper.min.js')}}"></script>
<script src="{{asset('public/clients/library/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('public/clients/library/bootstraps/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/clients/library/fontawesome/js/all.min.js')}}"></script>
<script src="{{asset('public/clients/library/bootbox/bootbox.min.js')}}"></script>
<script src="{{asset('public/clients/library/datatables/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('public/clients/library/datatables/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('public/clients/library/datatables/js/jszip.min.js')}}"></script>
<script src="{{asset('public/clients/library/excel/jszip.js')}}"></script>
<script src="{{asset('public/clients/library/excel/xlsx.js')}}"></script>
<script src="{{asset('public/clients/library/datatables/js/pdfmake.min.js')}}"></script>
<script src="{{asset('public/clients/library/datatables/js/vfs_fonts.js')}}"></script>
<script src="{{asset('public/clients/library/datatables/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('public/clients/library/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/clients/library/datatables/js/buttons.print.min.js')}}"></script>
<script src="{{asset('public/clients/my/scripts/all.js')}}"></script>

</html>









