<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{asset('public/favicon.ico')}}"/>
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
                        {{-- <a class="dropdown-item" href="{{asset('/thong-tin-tai-khoan')}}">Thông tin tài khoản</a> --}}
                        {{-- <a class="dropdown-item" href="{{asset('/doi-mat-khau')}}">Đổi mật khẩu</a> --}}
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
<script>

    $(document).ready(function(){
        $('#weight').on('blur change', function() {
            var  strAddressB2B = $('#addressB2B').val();
            var  intCity = $('#city').children("option:selected").val();
            var  intDistrict = $('#district').children("option:selected").val();
            var  intWard = $('#ward').children("option:selected").val();
            var  strAddress = $('#address').val();
            var  intWeight = parseFloat($('#weight').val());
            var  intCollectionMoney = parseFloat($('#collection_money').val());

            var localWard = localStorage.getItem("localWard");
            var localDistrict = localStorage.getItem("localDistrict");
            var localCity = localStorage.getItem("localCity");
            localWard = JSON.parse(localWard);
            localDistrict = JSON.parse(localDistrict);
            localCity = JSON.parse(localCity);
            var strCityDistrictWard =  '';
            if(intDistrict && intWard){
                strCityDistrictWard = localWard[intDistrict][intWard]['path_with_type'];
            }
            if(strAddress){
                var strAddressB2C = strAddress+', '+strCityDistrictWard;
            }else{
                var strAddressB2C = strCityDistrictWard;
            }
            document.getElementById("addressB2CText").innerText = strAddressB2C;

            var  intPrice = 22000; 
            var weightCounted = Math.round((parseFloat(intWeight) - 5000)/1000);
            if(weightCounted > 0){
                intPrice = (weightCounted * 3400) + parseFloat(intPrice);
            }

            //  tính ra km phải hoạt động
            const geocoder = new google.maps.Geocoder();
            const service = new google.maps.DistanceMatrixService();
            const request = {
                origins: [strAddressB2C],
                destinations: [strAddressB2B],
                travelMode: google.maps.TravelMode.DRIVING,
                unitSystem: google.maps.UnitSystem.METRIC,
                avoidHighways: false,
                avoidTolls: false,
            };
            // get distance matrix response
            service.getDistanceMatrix(request).then((response) => {
                document.getElementById("kmText").innerText = response.rows[0].elements[0].distance.text;
                const floatKm = Math.round((parseFloat(response.rows[0].elements[0].distance.value) - 5000)/1000);
                if(0 < floatKm){
                    var floatPriceKm = floatKm * 5000;
                    intPrice = parseFloat(intPrice) + parseFloat(floatPriceKm);
                }
                document.getElementById("into_money").value = parseFloat(intPrice);
                document.getElementById("into_moneyText").innerText = parseFloat(intPrice);
            });
            //  tính ra km phải hoạt động
        });


        // lấy sự kiệ của từng input
        // $('input').on('change', function(){
        //     var getId = $(this).attr('id');
        //     var getValue = $(this).val();
        //     $('#'+getId+'Text').text(getValue);
        // });

        $('#collection_money').on('change', function(){
            var getValue = $(this).val();
            document.getElementById("into_money").value = parseFloat($('#into_money').val())+parseFloat(getValue);
        });

        $('#btnPostAdd').on('click', function(){
            $("#btnPostAdd").html('<i class="fas fa-circle-notch fa-spin"></i> Đang thực thi...');
            var  intCity = $('#city').children("option:selected").val();
            var  intDistrict = $('#district').children("option:selected").val();
            var  intWard = $('#ward').children("option:selected").val();
            var  strAddress = $('#address').val();
            var  intWeight = parseFloat($('#weight').val());
            var  strFullNameB2C = $('#full_name_b2c').val();
            var  intPhoneB2C = $('#phone_b2c').val();
            var  strCodeB2C = $('#code_b2c').val();
            var  strContent = $('#content').val();
            var  intCollectionMoney = parseFloat($('#collection_money').val());
            var  intIntoMoney = parseFloat($('#into_money').val());

            $.ajax({
                url: url_base + 'tao-don-van-api-map',
                type: 'POST',
                dataType: 'json',
                data: { 
                    city: intCity, 
                    district: intDistrict, 
                    ward: intWard, 
                    address: strAddress, 
                    weight: intWeight, 
                    full_name_b2c: strFullNameB2C, 
                    phone_b2c: intPhoneB2C, 
                    code_b2c: strCodeB2C, 
                    collection_money: intCollectionMoney,
                    into_money: intIntoMoney,
                    content: strContent
                },
                success: function(result) {
                    if (result.constructor === String) {
                        result = JSON.parse(result);
                    }
                    if (result.success == true) {
                        bootbox.alert({
                            message: result.messenger,
                            backdrop: true
                        });
                        location.reload(); 
                    } else {
                        $("#btnPostAdd").html('<i class="fas fa-pencil-alt"></i> Tạo đơn vậnchỉ ');
                        return bootbox.alert({
                            message: result.messenger,
                            backdrop: true
                        });
                    }
                }
            });
        });

    });
</script>
<script>
    $(document).ready(function(){
        $('.btnDelete').on('click', function(){
            var idValue = $(this).attr('idValue');
            if(!idValue){
                return bootbox.alert({message: "Bạn không thể xóa địa chỉ này.", backdrop: true});
            }

            bootbox.confirm("Bạn có chắc là muốn xóa địa chỉ này không !", function(result){ 
                if(result){
                    $.ajax({
                        url: url_base + 'xoa-dia-chi',
                        type: 'POST',
                        dataType: 'json',
                        data: { id: idValue },
                        success: function(result) {
                            if (result.constructor === String) {
                                result = JSON.parse(result);
                            }
                            if (result.success == true) {
                                bootbox.alert({
                                    message: result.messenger,
                                    backdrop: true
                                });
                                location.reload(); 
                            } else {
                                return bootbox.alert({
                                    message: result.messenger,
                                    backdrop: true
                                });
                            }
                        }
                    });
                }
            });
        });

        $('.btnUserEdit').on('click', function(){
            var idValue = $(this).attr('idValue');
            if(!idValue){
                return bootbox.alert({message: "Bạn không thể xóa địa chỉ này.", backdrop: true});
            }

            bootbox.confirm("Bạn có chắc là muốn cập nhật địa chỉ này làm địa chỉ chính khoản này !", function(result){ 
                if(result){
                    $.ajax({
                        url: url_base + 'cap-nhat-dia-chi-cho-tai-khoan',
                        type: 'POST',
                        dataType: 'json',
                        data: { id: idValue },
                        success: function(result) {
                            if (result.constructor === String) {
                                result = JSON.parse(result);
                            }
                            if (result.success == true) {
                                bootbox.alert({
                                    message: result.messenger,
                                    backdrop: true
                                });
                                location.reload(); 
                            } else {
                                return bootbox.alert({
                                    message: result.messenger,
                                    backdrop: true
                                });
                            }
                        }
                    });
                }
            });
        });
    });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhhEyXoLJzMYzELUhSeysx0e2V_7hGFZE&libraries=&v=weekly" async></script>
</html>









