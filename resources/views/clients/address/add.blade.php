@extends('clients.layout')
@section('title', 'Thêm địa chỉ - AZExpress')
@section('mainContainer')
<section id="mainContainer" class="container-fluid my-2">
    <ul class="nav nav-tabs nav-tabs-table" role="tablist">
        <li class="nav-item">
            <a class="nav-link nav-link-table active" data-toggle="tab" href="#home">
                <i class="fas fa-pencil-ruler"></i> Thêm địa chỉ
            </a>
        </li>
    </ul>

    <div class="tab-content tab-content-table">
        <div id="home" class="tab-pane active">
            <div class="bg-eee border-ff6600">
                <form>
                    <div class="row p-2">
                        <div class="form-group col-12">
                            <label class="label" for="name_address">Địa chỉ<span
                                    class="text-danger text-weight-600">(*)</span></label>
                            <input id="name_address" type="text" class="form-control rounded form-control-sm"
                                placeholder="Nhập vào tên địa chỉ (ví dụ Trà Sữa TocoToco)" name="name_address"
                                value="{{old('name_address')}}">
                            @if($errors->has('name_address'))
                            <p class="error-warning">{{$errors->first('name_address')}}</p>
                            @endif
                        </div>
                        <div class="form-group col-3">
                            <label class="label" for="city">Tỉnh/Thành phố:<span
                                    class="text-danger text-weight-600">(*)</span></label>
                            <select class="form-control rounded form-control-sm" name="city" id="city" @if(old('city'))
                                idOldCity="{{old('city')}}" @endif>
                                <option>=== Chọn tỉnh thành phố ===</option>
                            </select>
                            @if($errors->has('city'))
                            <p class="error-warning">{{$errors->first('city')}}</p>
                            @endif
                        </div>

                        <div class="form-group col-3">
                            <label class="label" for="district">Quận/Huyện:<span
                                    class="text-danger text-weight-600">(*)</span></label>
                            <select class="form-control rounded form-control-sm" name="district" id="district"
                                @if(old('district')) idOldDistrict="{{old('district')}}" @endif>
                                <option>=== Chọn quận huyện ===</option>
                            </select>
                            @if($errors->has('district'))
                            <p class="error-warning">{{$errors->first('district')}}</p>
                            @endif
                        </div>

                        <div class="form-group col-3">
                            <label class="label" for="ward">Xã/Phường:<span
                                    class="text-danger text-weight-600">(*)</span></label>
                            <select class="form-control rounded form-control-sm" name="ward" id="ward" @if(old('ward'))
                                idOldWard="{{old('ward')}}" @endif>
                                <option>=== Chọn xã phường ===</option>
                            </select>
                            @if($errors->has('ward'))
                            <p class="error-warning">{{$errors->first('ward')}}</p>
                            @endif
                        </div>
                        <div class="form-group col-3">
                            <label class="label" for="address">Địa chỉ<span
                                    class="text-danger text-weight-600">(*)</span></label>
                            <input id="address" type="text" class="form-control rounded form-control-sm"
                                placeholder="Nhập vào địa chỉ (nhà và đường)" name="address" value="{{old('address')}}">
                            @if($errors->has('address'))
                            <p class="error-warning">{{$errors->first('address')}}</p>
                            @endif
                        </div>

                        <div class="form-group col-3">
                            <label class="label" for="address_of">
                                Tên người nhận<span class="text-danger text-weight-600">(*)</span>
                            </label>
                            <input type="text" id="address_of" class="form-control rounded
                                form-control-sm" placeholder="Nhập tên người nhận hàng" name="address_of"
                                value="{{old('address_of')}}">
                            @if($errors->has('address_of'))
                            <p class="error-warning">{{$errors->first('address_of')}}</p>
                            @endif
                        </div>

                        <div class="form-group col-3">
                            <label class="label" for="phone">Điện thoại người nhận<span
                                    class="text-danger text-weight-600">(*)</span></label>
                            <input type="number" name="phone" class="form-control rounded
                                            form-control-sm" placeholder="Nhập số điện thoại" name="phone"
                                value="{{old('phone')}}">
                            @if($errors->has('phone'))
                            <p class="error-warning">{{$errors->first('phone')}}</p>
                            @endif
                        </div>
                        <div class="form-group col-2">
                            <label class="label" for="">&nbsp;</label>
                            <button type="button" class="btn btn-sm">Thêm</button>
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
                        <th>STT</th>
                        <th>Tên người nhận</th>
                        <th>Số điện thoại</th>
                        <th>Tên địa chỉ</th>
                        <th>Địa chỉ</th>
                        <th>Xã/phường</th>
                        <th>Quận/huyện</th>
                        <th>Tỉnh/thành phố</th>
                        <th>Thời gian tạo</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if($arrData['address'])
                    @foreach ($arrData['address'] as $key => $item)
                    <tr>
                        {{-- <td class="text-center"><input type="checkbox"></td> --}}
                        <td class="text-center">{{$key+1}}</td>
                        <td class="text-left">{{$item['address_of']}}</td>
                        <td class="text-center">{{$item['phone']}}</td>
                        <td class="text-center">{{$item['name_address']}}</td>
                        <td class="text-center">{{$item['address']}}</td>
                        <td class="text-center">{{App\Library\Address\ReadAddress::getWard($item['ward'])}}</td>
                        <td class="text-center">{{App\Library\Address\ReadAddress::getDistrict($item['district'])}}</td>
                        <td class="text-center">{{App\Library\Address\ReadAddress::getCity($item['city'])}}</td>
                        <td class="text-center">{{$item['created_at']}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="10">
                            <p class="text-center">Không có dữ liệu</p>
                        </td>
                    </tr>
                    @endif
                </tbody>
                <tfoot class="table-header">
                    <tr>
                        <th>STT</th>
                        <th>Tên người nhận</th>
                        <th>Số điện thoại</th>
                        <th>Tên địa chỉ</th>
                        <th>Địa chỉ</th>
                        <th>Xã/phường</th>
                        <th>Quận/huyện</th>
                        <th>Tỉnh/thành phố</th>
                        <th>Thời gian tạo</th>

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