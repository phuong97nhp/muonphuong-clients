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
        
        @if(session('message'))
            <div class="alert alert-success text-success my-1 p-2">
                {{session('message')}}
                <button type="button" class="close btn-close-message" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="tab-content tab-content-table">
            <div id="home" class="tab-pane active">
                <div class="bg-eee border-ff6600">
                    <form method="POST" action="{{url('/post-add-order')}}">
                        @csrf
                        <div class="row p-2">
                            <div class="form-group col-12">
                                <label class="label" for="address_customer">Địa chỉ tạo đơn vận:<span class="text-danger text-weight-600">(*)</span></label>
                                <select name="address_customer" class="form-control rounded form-control-sm" id="address_customer">
                                    <option  value="">=== Chọn địa chỉ tạo đơn vận ===</option>
                                    @if ($arrData["address"])
                                        @foreach ($arrData["address"] as $key => $item)
                                            <option  @if(old('address_customer'))
                                                {{(old('address_customer') == $key)?'selected':''}}
                                            @else
                                                {{(Auth::user()['address_id'] == $key)?'selected':''}}
                                            @endif value="{{ $key }}">{{ $item }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if($errors->has('address_customer'))
                                    <p class="error-warning">{{$errors->first('address_customer')}}</p>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="">Địa chỉ<span class="text-danger text-weight-600">(*)</span></label>
                                <input id="address"  type="text" class="form-control rounded form-control-sm" placeholder="Nhập vào địa chỉ (nhà và đường)" name="address" value="{{old('address')}}">
                                @if($errors->has('address'))
                                    <p class="error-warning">{{$errors->first('address')}}</p>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="city">Tỉnh/Thành phố:<span class="text-danger text-weight-600">(*)</span></label>
                                <select class="form-control rounded form-control-sm" name="city" id="city" @if(old('city')) idOldCity="{{old('city')}}" @endif>
                                    <option value="0" >=== Chọn tỉnh thành phố ===</option>
                                </select>
                                @if($errors->has('city'))
                                    <p class="error-warning">{{$errors->first('city')}}</p>
                                @endif
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="district">Quận/Huyện:<span class="text-danger text-weight-600">(*)</span></label>
                                <select class="form-control rounded form-control-sm" name="district" id="district" @if(old('district')) idOldDistrict="{{old('district')}}"@endif>
                                    <option value="0" >=== Chọn quận huyện ===</option>
                                </select>
                                @if($errors->has('district'))
                                    <p class="error-warning">{{$errors->first('district')}}</p>
                                @endif
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="ward">Xã/Phương:<span class="text-danger text-weight-600">(*)</span></label>
                                <select class="form-control rounded form-control-sm" name="ward" id="ward"@if(old('ward')) idOldWard="{{old('ward')}}"@endif>
                                    <option value="0" >=== Chọn xã phường ===</option>
                                </select>
                                @if($errors->has('ward'))
                                    <p class="error-warning">{{$errors->first('ward')}}</p>
                                @endif
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="type">Loại dịch vụ:<span class="text-danger text-weight-600">(*)</span></label>
                                <select name="type" class="form-control rounded
                                            form-control-sm" id="type">
                                            <option  value="">=== Chọn loại dịch vụ ===</option>
                                            @foreach (App\Library\General::$arrTypeShip as $key => $item)
                                                <option {{(old('type') == $key)?'selected':''}} value="{{$key}}">{{$item}}</option>
                                            @endforeach
                                        </select>
                                @if($errors->has('type'))
                                    <p class="error-warning">{{$errors->first('type')}}</p>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="payments">Hình thức thanh toán:</label>
                                <select name="payments" class="form-control rounded
                                            form-control-sm" id="payments">
                                            <option  value="">=== Chọn hình thức thanh toán ===</option>
                                            <option {{(old('payments') == 'Cuoi thang')?'selected':''}} value="Cuoi thang">Cuối tháng</option>
                                        </select>
                                @if($errors->has('payments'))
                                    <p class="error-warning">{{$errors->first('payments')}}</p>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="weight">Trọng lượng<span class="text-danger text-weight-600">(*)</span></label>
                                <input type="number" id="weight" name="weight" class="form-control rounded
                                            form-control-sm" placeholder="Nhập trọng lương" name="weight" value="{{old('weight')}}">
                                @if($errors->has('weight'))
                                    <p class="error-warning">{{$errors->first('weight')}}</p>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="full_name_b2c">
                                    Tên người nhận<span class="text-danger text-weight-600">(*)</span>
                                </label>
                                <input type="text" id="full_name_b2c" class="form-control rounded
                                form-control-sm" placeholder="Nhập tên người nhận hàng" name="full_name_b2c" value="{{old('full_name_b2c')}}">
                                @if($errors->has('full_name_b2c'))
                                    <p class="error-warning">{{$errors->first('full_name_b2c')}}</p>
                                @endif
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="phone_b2c">Điện thoại người nhận<span class="text-danger text-weight-600">(*)</span></label>
                                <input type="number" name="phone_b2c" class="form-control rounded
                                            form-control-sm" placeholder="Nhập số điện thoại" name="phone" value="{{old('phone_b2c')}}">
                                @if($errors->has('phone_b2c'))
                                    <p class="error-warning">{{$errors->first('phone_b2c')}}</p>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="code_b2c">Mã đơn hàng riêng</label>
                                <input type="text" name="code_b2c" class="form-control rounded
                                            form-control-sm" placeholder="Mã đơn hàng riêng" name="code_b2c" value="{{old('code_b2c')}}">
                                @if($errors->has('code_b2c'))
                                    <p class="error-warning">{{$errors->first('code_b2c')}}</p>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="collection_money">Thu hộ</label>
                                <input type="text" name="collection_money" class="form-control rounded
                                            form-control-sm" placeholder="Nhận số tiền thu hộ" name="collection_money" value="{{old('collection_money')}}">
                                @if($errors->has('collection_money'))
                                    <p class="error-warning">{{$errors->first('collection_money')}}</p>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="into_money">Tổng cước tạm tính </label>
                                <input readonly type="text" id="into_money" class="form-control rounded
                                            form-control-sm" placeholder="" name="into_money" value="{{old('into_money')}}">
                                @if($errors->has('into_money'))
                                    <p class="error-warning">{{$errors->first('into_money')}}</p>
                                @endif
                            </div>
                            <div class="form-group col-9">
                                <label class="label" for="content">Ghi chú</label>
                                <input type="text" name="content" class="form-control rounded
                                            form-control-sm" placeholder="Nhận nội dung yêu cầu thêm" name="content"  value="{{old('content')}}">
                                @if($errors->has('content'))
                                    <p class="error-warning">{{$errors->first('content')}}</p>
                                @endif
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
                                    <option  value="">=== Chọn địa chỉ tạo đơn vận ===</option>
                                    @if ($arrData["address"])
                                        @foreach ($arrData["address"] as $key => $item)
                                            <option {{Auth::user()["address_id"]==$key?'selected':'' }} value="{{ $key }}">{{ $item }}</option>
                                        @endforeach
                                    @endif
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
        <div class="row">
            <div class="col-12 mt-2">
                <table class="table table-striped">
                    <thead class="table-header">
                        <tr>
                            {{-- <th><input type="checkbox"></th> --}}
                            <th>STT</th>
                            <th>Mã bill</th>
                            <th>Tên người nhận</th>
                            <th>Số điện thoại</th>
                            <th>Số kiện</th>
                            <th>Trọng lượng</th>
                            <th>Loại dịch vụ</th>
                            <th>HTTT</th>
                            <th>Xã/phường</th>
                            <th>Quận/huyện</th>
                            <th>Tỉnh/thành phố</th>
                            <th>Thành tiền tạm tính</th>
                            <th>Thời gian tạo</th>
                            <!-- <th>Trạng thái</th> -->
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @if($arrData['orders'])
                            @foreach ($arrData['orders'] as $key => $item)
                                <tr>
                                    {{-- <td class="text-center"><input type="checkbox"></td> --}}
                                    <td class="text-center">{{$key+1}}</td>
                                    <td class="text-center">{{$item['code_az']}}</td>
                                    <td class="text-left">{{$item['full_name_b2c']}}</td>
                                    <td class="text-center">{{$item['phone_b2c']}}</td>
                                    <td class="text-center">{{$item['packages']}}</td>
                                    <td class="text-center">{{$item['weight']}} <sub>gram</sub></td>
                                    <td class="text-center">{{$item['type']}}</td>
                                    <td class="text-center">{{$item['payments']}}</td>
                                    <td class="text-center">{{App\Library\Address\ReadAddress::getWard($item['ward'])}}</td>
                                    <td class="text-center">{{App\Library\Address\ReadAddress::getDistrict($item['district'])}}</td>
                                    <td class="text-center">{{App\Library\Address\ReadAddress::getCity($item['city'])}}</td>
                                    <td class="text-center">{{$item['into_money']}} <sup>đ</sup></td>
                                    <td class="text-center">{{$item['enter_date']}}</td>
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
                            {{-- <td><input type="checkbox"></td> --}}
                            <td>STT</td>
                            <td>Mã bill</td>
                            <td>Tên người nhận</td>
                            <td>Số điện tdoại</td>
                            <td>Số kiện</td>
                            <td>Trọng lượng</td>
                            <td>Loại dịch vụ</td>
                            <td>HTTT</td>
                            <td>Xã/phường</td>
                            <td>Quận/huyện</td>
                            <td>Tỉnh/tdành phố</td>
                            <td>tdành tiền tạm tính</td>
                            <td>tdời gian tạo</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $arrData['orders']->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </section>
@endsection