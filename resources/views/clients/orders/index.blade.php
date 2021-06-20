@extends('clients.layout')
@section('title', 'Theo dõi đơn vận - AZExpress')
@section('mainContainer')
    <section id="mainContainer" class="container-fluid my-2">
        <ul class="nav nav-tabs nav-tabs-table" role="tablist">
            <li class="nav-item">
                <a class="nav-link nav-link-table active" data-toggle="tab" href="#home">
                    <i class="fas fa-clipboard-list"></i> Theo dõi đơn vận
                </a>
            </li>
        </ul>

        <div class="tab-content tab-content-table">
            <div id="home" class="tab-pane active">
                <div class="bg-eee border-ff6600">
                    <form id="form-search-order" method="POST">
                        @csrf
                        <div class="row p-2">
                            <div class="form-group col-3">
                                <label class="label" for="">Mã đơn vận</label>
                                <input type="text" value="{{old('address_customer')}}" class="form-control rounded form-control-sm" placeholder="Nhập vào mã đơn vận" id="code_az" name="code_az">
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="city">Tỉnh/Thành phố:</label>
                                <select class="form-control rounded form-control-sm" name="city" id="city" @if(old('city')) idOldCity="{{old('city')}}" @endif>
                                    <option  value="">=== Chọn tỉnh thành phố ===</option>
                                </select>
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="district">Quận/Huyện:</label>
                                <select class="form-control rounded form-control-sm" name="district" id="district" @if(old('district')) idOldDistrict="{{old('district')}}"@endif>
                                    <option  value="">=== Chọn quận huyện ===</option>
                                </select>
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="ward">Xã/Phương:</label>
                                <select class="form-control rounded form-control-sm" name="ward" id="ward"@if(old('ward')) idOldWard="{{old('ward')}}"@endif>
                                    <option  value="">=== Chọn xã phường ===</option>
                                </select>
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="Begin">Thời gian bắt:</label>
                                <input type="text" class="form-control rounded form-control-sm datepicker" name="dateBegin" id="dateBegin"  placeholder="mm/dd/yyyy">
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="dateEnd">Thời gian kết thúc</label>
                                <input type="text" name="dateEnd" id="dateEnd" class="form-control rounded form-control-sm datepicker" data-date="{{old('dateEnd')}}" placeholder="mm/dd/yyyy">
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="type">Loại dịch vụ:</label>
                                <select name="type" class="form-control rounded form-control-sm" id="type">
                                    <option  value="">=== Chọn loại dịch vụ ===</option>
                                    @foreach (App\Library\General::$arrTypeShip as $key => $item)
                                        <option {{(old('type') == $key)?'selected':''}} value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="status">Trạng thái đơn vận:</label>
                                <select name="status" class="form-control rounded
                                            form-control-sm" id="status">
                                            <option  value="">=== Chọn trạng thái đơn vận cần xem ===</option>
                                            @foreach (App\Library\General::$arrStatusOrder as $key => $item)
                                                <option {{(old('status') == $key)?'selected':''}} value="{{$key}}">{{$item}}</option>
                                            @endforeach
                                        </select>
                            </div>
                            <div class="form-group col-6">
                                <label class="label" for="address_customer">Địa chỉ tạo đơn vận:</label>
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
                            </div>
                            <div class="form-group col-2">
                                <label class="label">&nbsp;</label>
                                <button type="button" id="btnSeaarchDataTabel" class="btn btn-sm">
                                    <i class="fas fa-search"></i> Tìm kiếm
                                </button>
                            </div>
                            <div class="form-group col-2">
                                <label class="label">&nbsp;</label>
                                <button type="button" class="btn btn-sm">
                                    <i class="far fa-file-excel"></i> Xuất excel
                                </button>
                            </div>
                            <div class="form-group col-2">
                                <label class="label">&nbsp;</label>
                                <button type="button" class="btn btn-sm">
                                    <i class="fas fa-paper-plane"></i> Yêu cầu phát
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-2">
                <table class="table table-striped" id="data-tabel-search">
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
                            <td>Thành tiền tạm tính</td>
                            <td>Thời gian tạo</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="mt-2 col"></div>
            </div>
        </div>
    </section>
@endsection