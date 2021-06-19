<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <title>Đăng nhập - AZExpress</title>
    <link rel="icon" type="image/png" href="{{asset('public/favicon.ico')}}"/>
    <meta name="description" content="Đăng nhập vào trang đăng nhập khách hàng">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- set token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('public/clients/library/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/clients/my/styles/login.css')}}">
</head>
<!-- end::Head -->

<!-- begin::Body -->
<body class="container-fluid">
    <div class="row">
        <div id="mainContainer" class="mx-auto">
            <div id="Logo" class="pt-3">
                <img src="{{asset('public/clients/images/logo.png')}}" alt="Logo azexpress.com.vn">
            </div>
            <div>
                <form class="was-validated my-3 mx-4" method="POST">
                    <div class="form-group">
                        <label for="username">Tài khoản:</label>
                        <input type="text" class="form-control" id="email" placeholder="Nhập tài khoản" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu" name="password" required>
                    </div>
                    <div class="form-group form-check d-flex justify-content-center">
                        <label class="form-check-label">
                            <input class="form-check-input" value="1" id="remember" type="checkbox" name="remember"> <label for="remember">Nhớ mật khẩu này.</label>
                        </label>
                    </div>
                    <div class="mx-auto">
                        <button type="button" id="btnLogin" class="btn btn-login">Đăng nhập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end:: Page -->
    <script src="{{asset('public/clients/library/jquery/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('public/clients/library/jquery/popper.min.js')}}"></script>
    <script src="{{asset('public/clients/library/bootstraps/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/clients/library/fontawesome/js/all.min.js')}}"></script>
    <script src="{{asset('public/clients/library/bootbox/bootbox.min.js')}}"></script>
    <script src="{{asset('public/clients/my/scripts/login.js')}}"></script>
    <!--end::Page Scripts -->
</body>
<!-- end::Body -->

</html>