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
                    <form method="POST" action="{{asset('/post-add-order')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row p-2">
                            <div class="form-group col-12">
                                <label class="label" for="address_customer">Địa chỉ tạo đơn vận:<span class="text-danger text-weight-600">(*)</span></label>
                                <select name="address_customer" class="form-control rounded form-control-sm" id="address_customer">
                                    <option>=== Chọn địa chỉ tạo đơn vận ===</option>
                                    @foreach ($arrData["address"] as $key => $item)
                                        <option {{Auth::user()["address_id"]==$key?'selected':'' }} value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="">Địa chỉ<span class="text-danger text-weight-600">(*)</span></label>
                                <input id="address"  type="text" class="form-control rounded form-control-sm" placeholder="Nhập vào địa chỉ (nhà và đường)" name="address">
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="city">Tỉnh/Thành phố:<span class="text-danger text-weight-600">(*)</span></label>
                                <select class="form-control rounded form-control-sm" name="city" id="city">
                                    <option>=== Chọn tỉnh thành phố ===</option>
                                </select>
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="district">Quận/Huyện:<span class="text-danger text-weight-600">(*)</span></label>
                                <select class="form-control rounded form-control-sm" name="district" id="district">
                                    <option>=== Chọn quận huyện ===</option>
                                </select>
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="ward">Xã/Phương:<span class="text-danger text-weight-600">(*)</span></label>
                                <select class="form-control rounded form-control-sm" name="ward" id="ward">
                                    <option>=== Chọn xã phường ===</option>
                                </select>
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="type">Loại dịch vụ:<span class="text-danger text-weight-600">(*)</span></label>
                                <select name="type" class="form-control rounded
                                            form-control-sm" id="type">
                                            <option>=== Chọn loại dịch vụ ===</option>
                                            <option value="CPN">Chuyển phát nhanh</option>
                                        </select>
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="payments">Hình thức thanh toán:</label>
                                <select name="payments" class="form-control rounded
                                            form-control-sm" id="payments">
                                            <option>=== Chọn hình thức thanh toán ===</option>
                                            <option value="Cuoi thang">Cuối tháng</option>
                                        </select>
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="weight">Trọng lượng<span class="text-danger text-weight-600">(*)</span></label>
                                <input type="text" id="weight" name="weight" class="form-control rounded
                                            form-control-sm" placeholder="Nhập trọng lương" name="weight">
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="full_name_b2c">
                                    Tên người nhận<span class="text-danger text-weight-600">(*)</span>
                                </label>
                                <input type="text" id="full_name_b2c" class="form-control rounded
                                form-control-sm" placeholder="Nhập tên người nhận hàng" name="full_name_b2c">
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="phone">Điện thoại người nhận<span class="text-danger text-weight-600">(*)</span></label>
                                <input type="text" name="phone" class="form-control rounded
                                            form-control-sm" placeholder="Nhập số điện thoại" name="phone">
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="code_b2c">Mã đơn hàng riêng</label>
                                <input type="text" name="code_b2c" class="form-control rounded
                                            form-control-sm" placeholder="Mã đơn hàng riêng" name="code_b2c">
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="collection_money">Thu hộ</label>
                                <input type="text" name="collection_money" class="form-control rounded
                                            form-control-sm" placeholder="Nhận số tiền thu hộ" name="collection_money">
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="into_money">Tổng cước tạm tính <span class="text-danger text-weight-600">(*)</span></label>
                                <input readonly type="text" id="into_money" class="form-control rounded
                                            form-control-sm" placeholder="" name="into_money">
                            </div>
                            <div class="form-group col-9">
                                <label class="label" for="content">Ghi chú</label>
                                <input type="text" name="content" class="form-control rounded
                                            form-control-sm" placeholder="Nhận nội dung yêu cầu thêm" name="content">
                            </div>
                            <div class="form-group col-2">
                                <label class="label" for="">&nbsp;</label>
                                <button type="submit" id="btnPostAdd" class="btn btn-sm"><i class="fas fa-pencil-alt"></i> Tạo đơn vận</button>
                            </div>
                            {{-- <div class="form-group col-1">
                                <label class="label" for="">&nbsp;</label>
                                <button type="button" id="btnEraser" class="btn btn-sm"> <i class="fas fa-eraser"></i> Xóa</button>
                            </div> --}}
                        </div>
                    </form>
                </div>
            </div>
            <div id="menu1" class="tab-pane fade">
                <div id="height-form" class="bg-eee border-ff6600">
                    <form method="POST" action="{{asset('/post-import-order')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row p-2">
                            <div class="form-group col-md-12">
                                <label class="label" for="address_customer">Địa chỉ nhận đơn:</label>
                                <select required name="address_customer" class="form-control rounded form-control-sm">
                                    <option>=== Chọn tỉnh thành phố ===</option>
                                    @foreach ($arrData["address"] as $key => $item)
                                        <option {{Auth::user()["address_id"]==$key?'selected':'' }} value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center">
                                    <div class="custom-file col-md-3">
                                        <input type="file" name="customFile" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label label " for="customFile">Cập nhật đơn vận
                                                    mới</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label class="label" for="">&nbsp;</label>
                                <button type="submit" class="btn btn-sm"><i class="fas fa-upload"></i> Tải lên đơn vận</button>
                                <a class="d-flex justify-content-center mt-2" target="_back" href="{{asset('public/excel/excel-import-customer.xlsx')}}">Tải về mẫu Excel</a>
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
                        @if($arrData['orders'])
                            @foreach ($arrData['orders'] as $item)
                                <tr>
                                    <td><p class="text-center">Không có dữ liệu</p></td>
                                    <td><p class="text-center">Không có dữ liệu</p></td>
                                    <td><p class="text-center">Không có dữ liệu</p></td>
                                    <td><p class="text-center">Không có dữ liệu</p></td>
                                    <td><p class="text-center">Không có dữ liệu</p></td>
                                    <td><p class="text-center">Không có dữ liệu</p></td>
                                    <td><p class="text-center">Không có dữ liệu</p></td>
                                    <td><p class="text-center">Không có dữ liệu</p></td>
                                    <td><p class="text-center">Không có dữ liệu</p></td>
                                    <td><p class="text-center">Không có dữ liệu</p></td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="10" ><p class="text-center">Không có dữ liệu</p></td>
                        </tr>
                        @endif
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