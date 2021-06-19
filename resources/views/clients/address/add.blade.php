@extends('clients.layout')
@section('title', 'Tạo đơn vận - AZExpress')
@section('mainContainer')
    <section id="mainContainer" class="container-fluid my-2">
        <ul class="nav nav-tabs nav-tabs-table" role="tablist">
            <li class="nav-item">
                <a class="nav-link nav-link-table active" data-toggle="tab" href="#home">
                    <i class="fas fa-pencil-ruler"></i> Tạo đơn vận
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-table" data-toggle="tab" href="#menu1">
                    <i class="fas fa-file-excel"></i> Tạo đơn vận bằng file excel
                </a>
            </li>
        </ul>

        <div class="tab-content tab-content-table">
            <div id="home" class="tab-pane active">
                <div class="bg-eee border-ff6600">
                    <form>
                        <div class="row p-2">
                            <div class="form-group col-12">
                                <label class="label" for="city">Địa chỉ nhận đơn:</label>
                                <select class="form-control rounded
                                            form-control-sm" id="city">
                                            <option>Chọn tỉnh thành phố</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="city">Tỉnh/Thành phố:</label>
                                <select class="form-control rounded
                                            form-control-sm" id="city">
                                            <option>Chọn tỉnh thành phố</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="district">Quận/Huyện:</label>
                                <select class="form-control rounded
                                            form-control-sm" id="district">
                                            <option>Chọn quận huyện</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="ward">Xã/Phương:</label>
                                <select class="form-control rounded
                                            form-control-sm" id="ward">
                                            <option>Chọn xã phường</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="">Địa chỉ</label>
                                <input type="text" class="form-control rounded
                                            form-control-sm" placeholder="" name="text1">
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="type">Loại dịch vụ:</label>
                                <select class="form-control rounded
                                            form-control-sm" id="type">
                                            <option>Loại dịch vụ</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="pay_ments">Hình thức thanh toán:</label>
                                <select class="form-control rounded
                                            form-control-sm" id="pay_ments">
                                            <option>Hình thức thanh toán</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="">Tên người
                                            nhận</label>
                                <input type="text" class="form-control rounded
                                            form-control-sm" placeholder="" name="text1">
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="">Điện thoại
                                            người nhận</label>
                                <input type="text" class="form-control rounded
                                            form-control-sm" placeholder="" name="text1">
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="">Số kiện</label>
                                <input type="text" class="form-control rounded
                                            form-control-sm" placeholder="" name="text1">
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="">Nội dung</label>
                                <input type="text" class="form-control rounded
                                            form-control-sm" placeholder="" name="text1">
                            </div>
                            <div class="form-group col-4">
                                <label class="label" for="">Ghi chú</label>
                                <input type="text" class="form-control rounded
                                            form-control-sm" placeholder="" name="text1">
                            </div>
                            <div class="form-group col-2">
                                <label class="label" for="">&nbsp;</label>
                                <button type="button" class="btn btn-sm">Tạo đơn</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="menu1" class="tab-pane fade">
                <div id="height-form" class="bg-eee border-ff6600">
                    <form>
                        <div class="row p-2">
                            <div class="form-group col-12">
                                <label class="label" for="city">Địa chỉ nhận đơn:</label>
                                <select class="form-control rounded
                                            form-control-sm" id="city">
                                            <option>Chọn tỉnh thành phố</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label label " for="customFile">Cập nhật đơn hàng
                                                mới</label>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label class="label" for="">&nbsp;</label>
                                <button type="button" class="btn btn-sm">Tạo đơn</button>
                                <a href="http://">Tải về mẫu Excel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col-12 mt-2">
                <table class="table table-striped">
                    <thead class="table-header">
                        <tr>
                            <th><input type="checkbox"></th>
                            <th>Mã bill</th>
                            <th>Tên người nhận</th>
                            <th>Số điện thoại</th>
                            <th>Số kiện</th>
                            <th>Loại dịch vụ</th>
                            <th>HTTT</th>
                            <th>Địa chỉ</th>
                            <th>Nội dung</th>
                            <th>Ghi chú</th>
                            <!-- <th>Trạng thái</th> -->
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>123131313</td>
                            <td>Nguyễn Hoàng Phương Nam</td>
                            <td>0962640068</td>
                            <td>2</td>
                            <td>CPN</td>
                            <td>Cuối tháng</td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-map-signs"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-book"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="far fa-clipboard"></i>
                                </a>
                            </td>
                            <!-- <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="far fa-circle"></i>
                                </a>
                            </td> -->
                        </tr>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>123131313</td>
                            <td>Nguyễn Hoàng Phương Nam</td>
                            <td>0962640068</td>
                            <td>2</td>
                            <td>CPN</td>
                            <td>Cuối tháng</td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-map-signs"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-book"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="far fa-clipboard"></i>
                                </a>
                            </td>
                            <!-- <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-check-circle"></i>
                                </a>
                            </td> -->
                        </tr>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>123131313</td>
                            <td>Nguyễn Hoàng Phương Nam</td>
                            <td>0962640068</td>
                            <td>2</td>
                            <td>CPN</td>
                            <td>Cuối tháng</td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-map-signs"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-book"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="far fa-clipboard"></i>
                                </a>
                            </td>
                            <!-- <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="far fa-circle"></i>
                                </a>
                            </td> -->
                        </tr>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>123131313</td>
                            <td>Nguyễn Hoàng Phương Nam</td>
                            <td>0962640068</td>
                            <td>2</td>
                            <td>CPN</td>
                            <td>Cuối tháng</td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-map-signs"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-book"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="far fa-clipboard"></i>
                                </a>
                            </td>
                            <!-- <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-check-circle"></i>
                                </a>
                            </td> -->
                        </tr>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>123131313</td>
                            <td>Nguyễn Hoàng Phương Nam</td>
                            <td>0962640068</td>
                            <td>2</td>
                            <td>CPN</td>
                            <td>Cuối tháng</td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-map-signs"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-book"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="far fa-clipboard"></i>
                                </a>
                            </td>
                            <!-- <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="far fa-circle"></i>
                                </a>
                            </td> -->
                        </tr>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>123131313</td>
                            <td>Nguyễn Hoàng Phương Nam</td>
                            <td>0962640068</td>
                            <td>2</td>
                            <td>CPN</td>
                            <td>Cuối tháng</td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-map-signs"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-book"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="far fa-clipboard"></i>
                                </a>
                            </td>
                            <!-- <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-check-circle"></i>
                                </a>
                            </td> -->
                        </tr>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>123131313</td>
                            <td>Nguyễn Hoàng Phương Nam</td>
                            <td>0962640068</td>
                            <td>2</td>
                            <td>CPN</td>
                            <td>Cuối tháng</td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-map-signs"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-book"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="far fa-clipboard"></i>
                                </a>
                            </td>
                            <!-- <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="far fa-circle"></i>
                                </a>
                            </td> -->
                        </tr>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>123131313</td>
                            <td>Nguyễn Hoàng Phương Nam</td>
                            <td>0962640068</td>
                            <td>2</td>
                            <td>CPN</td>
                            <td>Cuối tháng</td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-map-signs"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-book"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="far fa-clipboard"></i>
                                </a>
                            </td>
                            <!-- <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-check-circle"></i>
                                </a>
                            </td> -->
                        </tr>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>123131313</td>
                            <td>Nguyễn Hoàng Phương Nam</td>
                            <td>0962640068</td>
                            <td>2</td>
                            <td>CPN</td>
                            <td>Cuối tháng</td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-map-signs"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-book"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="far fa-clipboard"></i>
                                </a>
                            </td>
                            <!-- <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="far fa-circle"></i>
                                </a>
                            </td> -->
                        </tr>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>123131313</td>
                            <td>Nguyễn Hoàng Phương Nam</td>
                            <td>0962640068</td>
                            <td>2</td>
                            <td>CPN</td>
                            <td>Cuối tháng</td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-map-signs"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-book"></i>
                                </a>
                            </td>
                            <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="far fa-clipboard"></i>
                                </a>
                            </td>
                            <!-- <td>
                                <a href="javascipt:void()" title="Gửi theo kí hiệu">
                                    <i class="fas fa-check-circle"></i>
                                </a>
                            </td> -->
                        </tr>
                    </tbody>
                    <tfoot class="table-header">
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>Mã bill</td>
                            <td>Tên người nhận</td>
                            <td>Số điện thoại</td>
                            <td>Số kiện</td>
                            <td>Loại dịch vụ</td>
                            <td>HTTT</td>
                            <td>Địa chỉ</td>
                            <td>Nội dung</td>
                            <td>Ghi chú</td>
                            <!-- <th>Trạng thái</th> -->
                        </tr>
                    </tfoot>
                </table>
                <div class="d-flex justify-content-center">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Trang trước</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Trang sau</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection