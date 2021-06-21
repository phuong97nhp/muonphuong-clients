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
                    <form id="form-search-order" method="GET" action="">
                        <div class="row p-2">
                            <div class="form-group col-3">
                                <label class="label" for="">Mã đơn vận</label>
                                <input type="text" class="form-control rounded form-control-sm" placeholder="Nhập vào mã đơn vận" id="code_az" value="{{$arrData['param']['code_az']}}" name="code_az">

                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="city">Tỉnh/Thành phố:</label>
                                <select class="form-control rounded form-control-sm" name="city" id="city" @if($arrData['param']['city']) idOldCity="{{$arrData['param']['city']}}" @endif>
                                    <option  value="">=== Chọn tỉnh thành phố ===</option>
                                </select>
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="district">Quận/Huyện:</label>
                                <select class="form-control rounded form-control-sm" name="district" id="district" @if($arrData['param']['district']) idOldDistrict="{{ $arrData['param']['district']}}"@endif>
                                    <option  value="">=== Chọn quận huyện ===</option>
                                </select>
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="ward">Xã/Phương:</label>
                                <select class="form-control rounded form-control-sm" name="ward" id="ward"@if($arrData['param']['ward']) idOldWard="{{ $arrData['param']['ward']}}"@endif>
                                    <option  value="">=== Chọn xã phường ===</option>
                                </select>
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="Begin">Thời gian bắt:</label>
                                <input type="text" class="form-control rounded form-control-sm datepicker" name="dateBegin" id="dateBegin"  placeholder="mm/dd/yyyy" value="{{ $arrData['param']['dateBegin']}}">
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="dateEnd">Thời gian kết thúc</label>
                                <input type="text" name="dateEnd" id="dateEnd" class="form-control rounded form-control-sm datepicker" data-date="{{old('dateEnd')}}" placeholder="mm/dd/yyyy" value="{{ $arrData['param']['dateEnd']}}">
                            </div>

                            <div class="form-group col-3">
                                <label class="label" for="type">Loại dịch vụ:</label>
                                <select name="type" class="form-control rounded form-control-sm" id="type">
                                    <option  value="">=== Chọn loại dịch vụ ===</option>
                                    @foreach (App\Library\General::$arrTypeShip as $key => $item)
                                        <option {{($arrData['param']['type'] == $key)?'selected':''}} value="{{$key}}">{{$item}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-3">
                                <label class="label" for="status">Trạng thái đơn vận:</label>
                                <select name="status" class="form-control rounded
                                            form-control-sm" id="status">
                                            <option  value="">=== Chọn trạng thái đơn vận cần xem ===</option>
                                            @foreach (App\Library\General::$arrStatusOrder as $key => $item)
                                                <option {{($arrData['param']['status'] == $key)?'selected':''}} value="{{$key}}">{{$item}}</option>
                                            @endforeach
                                        </select>
                            </div>
                            <div class="form-group col-6">
                                <label class="label" for="address_id">Địa chỉ tạo đơn vận:</label>
                                <select name="address_id" class="form-control rounded form-control-sm" id="address_id">
                                    <option  value="">=== Chọn địa chỉ tạo đơn vận ===</option>
                                    @if ($arrData["address"])
                                        @foreach ($arrData["address"] as $key => $item)
                                            <option  @if($arrData['param']['address_id'])
                                                {{($arrData['param']['address_id'] == $key)?'selected':''}}
                                            @endif value="{{ $key }}">{{ $item }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-2">
                                <label class="label">&nbsp;</label>
                                <button type="submit" id="btnSeaarchDataTabel" class="btn btn-sm">
                                    <i class="fas fa-search"></i> Tìm kiếm
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <form action="/xuat-file-excel">
            <div class="col-12 mt-2 mb-1">
                <button type="button"  class="btn btn-sm btn-line">
                    <i class="far fa-file-excel"></i> Xuất excel
                </button>
                <button type="button" class="btn btn-sm btn-line" id="yeucauphat">
                    <i class="fas fa-paper-plane"></i> Yêu cầu phát
                </button>
            </div>
        </form>
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
                            <td>Thành tiền tạm tính</td>
                            <td>Thời gian tạo</td>
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