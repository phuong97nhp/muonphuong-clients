

<!DOCTYPE html>
<html>
<head>
<title>Nhập vào file excel</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="{{asset('cpn/my/styles/cpn.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{asset('cpn/library/bootbox/bootbox.min.js')}}"></script>
<script src="{{asset('cpn/library/excel/jszip.js')}}"></script>
<script src="{{asset('cpn/library/excel/xlsx.js')}}"></script>
</head>
<body>

    <header id="headerContainer" class="container-fluid">
        <nav id="mainMenu" class="row">

            <ul class="nav col">
                <li class="nav-item">
                    <a class="nav-link active" href="#"> <img id="logo" src="{{asset('cpn/images/logo.png')}}" alt="Logo
                                azexpress.com.vn/"></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Mục lục</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="index.html">Tạo đơn
                                hàng</a>
                        <a class="dropdown-item" href="tracking.html">Theo
                                dõi đơn hàng</a>
                        <a class="dropdown-item" href="in.html">In mã vạch</a></div>
                </li>
            </ul>


            <ul class="nav justify-content-center col-3 py-1">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" placeholder="Nhầp mã bill">
                    <div class="input-group-append">
                        <button class="btn btn-success btn-sm" type="submit">Tìm</button>
                    </div>
                </div>
            </ul>

            <ul class="nav justify-content-end col-3">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="login.html">Đã đăng nhập</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Thông tin khách
                                hàng</a>
                        <a class="dropdown-item" href="login.html">Thoát</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>
    <section id="mainContainer" class="container-fluid my-2">
        <div class="row">
            <div class="col-md-2">
                <div id="height-form" class="bg-eee border-ff6600">
                    <h3 class="text-center bg-ff6600 text-creat-bill">Up Excel </h3>
                    <form method="POST" action="{{asset('/')}}" enctype="multipart/form-data">
                    @csrf
                        <div class="row m-2">
                            <div class="form-group col-12">
                                <a href="{{asset('/file/file-247.xlsx')}}" type="button" class="btn btn-primary btn-sm">Tải về mẫu Excel</a>
                            </div>
                            <div class="custom-file col-12">
                                <input type="file" class="custom-file-input" id="fileExcel" name="fileExcel">
                                <label class="custom-file-label label" for="fileExcel">Cập nhật đơn hàng
                                            mới</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Tải lên</button>
                        </div>

                        @if(session('errors'))
                            @foreach($errors as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        @endif

                        @if(session('success'))
                            <li>{{session('success')}}</li>
                        @endif
                    </form>
                </div>
            </div>
            <div class="col-md-10">
                <div class="bg-eee border-ff6600">
                    <h3 class="text-center bg-ff6600 text-creat-bill col-md-12">Xuất file excel </h3>
                    <form method="POST" class="col-md-12" action="{{asset('/export')}}" enctype="multipart/form-data">
                        @csrf
                            <div class=row> 
                                <div class="form-group col-md-4">
                                    <label>Chọn thời gian bắt đầu:</label>
                                    <input type="date" class="form-control" name="dateFirst">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Chọn thời gian kết thúc:</label>
                                    <input type="date" class="form-control" name="dateEnd">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Nhập mã khách hàng:</label>
                                    <input type="text" class="form-control" name="code">
                                </div>
                            </div>
                            
                            <div class="row m-2">
                                <button type="submit" class="btn btn-primary btn-sm">Xuất file excel</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <footer id="footerContainer" class="container-fluid">
        <div class="row">
            <div class="author col">
                <p class="text-center mt-2" id="copy-righter">Bản quyền thuộc về &copy; <a target="_back" href="http://azexpress.com.vn/">AZExpress</a> - Version <a style="color: #ffc400" href="/phien-ban">1.0.0</a> - By<a style="color: #ffc400" href="/phien-ban"> Nguyễn Hoàng Phương</a></p>
            </div>
        </div>
    </footer>

<script>
$(document).ready(function() {
    var token = $('meta[name=csrf-token]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });

    if(!localStorage.getItem("auth")){
        bootbox.prompt({
            title: "Cần mã công ty trước khi nhập vào file excel", 
            centerVertical: true,
            callback: function(result){ 
                if(result == null){
                    return location.reload();
                }
                if(result === 'toi_la_nhan_vien_muon_phuong'){
                    localStorage.setItem("auth", result);
                }else{
                    return location.reload();
                }
            }
        });
    }

    var ExcelToJSON = function() {
        this.parseExcel = function(file) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var data = e.target.result;
                var workbook = XLSX.read(data, {
                    type: 'binary'
                });

                workbook.SheetNames.forEach(function(sheetName) {
                    // Here is your object
                    var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                    json_object = JSON.stringify(XL_row_object);
                    json_object = JSON.parse(json_object);

                    console.log(json_object);
                    // sendAjax(json_object);

                    if(data.success == true){
                        json_object.forEach(function(item, index) {
                            index = ++index;
                            htmlTable += '<tr><td>' + index + '</td><td class="tableEmail">' + item.name + '</td></tr>';
                        });

                        $('#tableBody').html(htmlTable);
                    }else{
                        htmlTable += '<tr><td colspan="2">Không có dữ liệu</td></tr>';
                        $('#tableBody').html(htmlTable);
                    }
                })
            };

            reader.onerror = function(ex) {
                console.log(ex);
            };

            reader.readAsBinaryString(file);
        };
    };

    function handleFileSelect(evt) {
        // bootbox.dialog({ 
        //     message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Loading...</div>', 
        //     closeButton: false 
        // });
        var files = evt.target.files; // FileList object
        var xl2json = new ExcelToJSON();
        xl2json.parseExcel(files[0]);
        console.log(xl2json);
    }
    
    document.getElementById('fileExcel').addEventListener('change', handleFileSelect, false);

    function sendAjax(json_object){
        var htmlTable = '';
        $.ajax({
            url: '/add',
            type: 'POST',
            dataType: 'json',
            data: {
                name: json_object,
            },
            success: function(data) {
                if(data.success == true){
                    json_object.forEach(function(item, index) {
                        index = ++index;
                        htmlTable += '<tr><td>' + index + '</td><td class="tableEmail">' + item.name + '</td></tr>';
                    });

                    $('#tableBody').html(htmlTable);
                }else{
                    htmlTable += '<tr><td colspan="2">Không có dữ liệu</td></tr>';
                    $('#tableBody').html(htmlTable);
                }
            }
        });
    }
});
</script>
</body>
</html>