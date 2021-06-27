$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#btnEraser').on('click', function() {
        $('input').val('');
        $('select').val([]);
    });

    // $('#btnPostAdd').on('click', function () {
    //     $('input').val('');
    // });

    var localCity = localStorage.getItem("localCity");
    var localDistrict = localStorage.getItem("localDistrict");
    var localWard = localStorage.getItem("localWard");

    if (!localCity) {
        $.getJSON(url_base + '/storage/json/tinh_tp.json', function(result) {
            localStorage.setItem("localCity", JSON.stringify(result));
        });
    } else {
        getAddress(); // load địa chỉ thành phố đầu tiên 
    }
    if (!localDistrict) {
        $.getJSON(url_base + '/storage/json/district.json', function(result) {
            localStorage.setItem("localDistrict", JSON.stringify(result));
        });
    }
    if (!localWard) {
        $.getJSON(url_base + '/storage/json/ward.json', function(result) {
            localStorage.setItem("localWard", JSON.stringify(result));
        });
    }

    $('#city, #district').on('change', function() {
        var idValue = $(this).children("option:selected").val();
        var intIdAddrees = $(this).attr('id');
        if (idValue && intIdAddrees) { getAddress(intIdAddrees, idValue); }
    });

    if ($('#city').attr('idOldCity')) {
        getAddress('city', $('#city').attr('idOldCity'))
    }

    if ($('#district').attr('idOldDistrict')) {
        getAddress('district', $('#district').attr('idOldDistrict'))
    }

    $('#weight, #type, #district').on('blur change', function() {
        var weight = $('#weight').val();
        var type = $('#type').children("option:selected").val();
        var district = $('#district').children("option:selected").val();

        if (type == '=== Chọn loại dịch vụ ===') {
            type = '';
        }
        if (district == '=== Chọn quận huyện ===') {
            district = '';
        }
        if (weight && type && type) {
            $.ajax({
                url: url_base + 'post-payment',
                type: 'POST',
                dataType: 'json',
                data: {
                    weight: weight,
                    type: type,
                    district: district,
                },
                success: function(result) {
                    if (result.constructor === String) {
                        result = JSON.parse(result);
                    }
                    if (result.success == true) {
                        $('#into_money').val(result.data.totalcharge);
                    }
                }
            });
        }
    });

    function getAddress(intIdAddrees = '', idValue = '') {
        switch (intIdAddrees) {
            case 'city':
                intIdAddrees = 'district'
                var html = '<option  value="">=== Chọn quận huyện ===</option>';
                var localDistrict = localStorage.getItem("localDistrict");
                localDistrict = JSON.parse(localDistrict);
                var idOldDistrictSelected = '';
                for (const [key, value] of Object.entries(localDistrict[idValue])) {
                    if ($('#district').attr('idOldDistrict') == key) {
                        idOldDistrictSelected = 'selected';
                    } else {
                        idOldDistrictSelected = '';
                    }
                    html += '<option ' + idOldDistrictSelected + ' value="' + key + '">' + value.name_with_type + '</option>';
                }
                $('#ward').html('<option  value="">=== Chọn xã phường ===</option>');
                break;
            case 'district':
                intIdAddrees = 'ward'
                var html = '<option  value="">=== Chọn xã phường ===</option>';
                var localWard = localStorage.getItem("localWard");
                localWard = JSON.parse(localWard);
                var idOldWardSelected = '';
                for (const [key, value] of Object.entries(localWard[idValue])) {
                    if ($('#ward').attr('idOldWard') == key) {
                        idOldWardSelected = 'selected';
                    } else {
                        idOldWardSelected = '';
                    }
                    html += '<option ' + idOldWardSelected + ' value="' + key + '">' + value.name_with_type + '</option>';
                }
                break;
            default:
                intIdAddrees = 'city'
                var html = '<option  value="">=== Chọn tỉnh thành phố ===</option>';
                var localCity = localStorage.getItem("localCity");
                localCity = JSON.parse(localCity);
                var idOldCitySelected = '';
                for (const [key, value] of Object.entries(localCity)) {
                    if ($('#city').attr('idOldCity') == key) {
                        idOldCitySelected = 'selected';
                    } else {
                        idOldCitySelected = '';
                    }
                    html += '<option ' + idOldCitySelected + ' value="' + key + '">' + value.name_with_type + '</option>';
                }
                $('#ward').html('<option  value="">=== Chọn xã phường ===</option>');
                $('#district').html('<option  value="">=== Chọn quận huyện ===</option>');
                break;
        }
        $('#' + intIdAddrees).html(html)
    }


    //!================================ theo dõi đơn vận ===========================

    $(".datepicker").datepicker({
        altFormat: "dd-mm-yy",
    });

    $('#data-tabel-search').DataTable({
        "dom": 'Bfrtip',
        "buttons": ['copyHtml5', 'excelHtml5', 'csvHtml5', 'print'],
        "pageLength": 50,
    });

    $(document).on("click", "#yeucauphat", function() {
        var params = $('#form-search-order').serialize();
        var status = $('#status').children("option:selected").val();
        $("#yeucauphat").html('<i class="fas fa-circle-notch fa-spin"></i> Đang thực thi...');
        $.ajax({
            url: url_base + 'yeu-cau-phat',
            type: 'POST',
            dataType: 'json',
            data: { status: status },
            success: function(result) {
                if (result.constructor === String) {
                    result = JSON.parse(result);
                }
                if (result.success == true) {
                    $("#yeucauphat").html('<i class="fas fa-paper-plane"></i> Yêu cầu phát');
                    return bootbox.alert({
                        message: result.messenger,
                        backdrop: true
                    });
                } else {
                    $("#yeucauphat").html('<i class="fas fa-paper-plane"></i> Yêu cầu phát');
                    return bootbox.alert({
                        message: result.messenger,
                        backdrop: true
                    });
                }
            }
        });
    });

    function dataTabelSearch() {
        var weight = 132;
        $.ajax({
            url: url_base + 'theo-doi-don-van-search',
            type: 'POST',
            dataType: 'json',
            data: {
                weight: weight,
            },
            success: function(result) {
                if (result.constructor === String) {
                    result = JSON.parse(result);
                }
                if (result.success == true) {
                    return result;
                }
            }
        });
    }
    // =================================================
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
                    if (json_object) {
                        var count = 0;
                        for (let i = 0; i < json_object.length; i++) {
                            $('body').find('.bootbox').hide();
                            sendAjax(json_object[i]);
                            count++;
                            if (count == json_object.length) {
                                bootbox.alert('Đã tải lên ' + count + 'đơn hàng, kiểm tra lại.');
                                location.reload();
                            }
                            sleep(500);
                        }
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
        bootbox.dialog({
            message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Loading...</div>',
            closeButton: false
        });
        var files = evt.target.files; // FileList object
        var xl2json = new ExcelToJSON();
        xl2json.parseExcel(files[0]);
        // console.log(xl2json);
    }

    document.getElementById('fileExcel').addEventListener('change', handleFileSelect, false);

    function sendAjax(item) {
        var htmlTable = '';
        $.ajax({
            url: '/post-add-order',
            type: 'POST',
            dataType: 'json',
            data: {
                'address_customer': item.dia_chi_lay_hang,
                'address': item.so_nha_va_duong,
                'city': item.tinh_thanh_pho,
                'district': item.quan_huyen,
                'ward': item.xa_phuong,
                'type': item.loai_dich_vu,
                'payments': item.hinh_thuc_thanh_toan,
                'weight': item.trong_luong,
                'full_name_b2c': item.ten_nguoi_nhan,
                'phone_b2c': item.so_dien_thoai,
                'code_b2c': item.ma_don_hang_rieng,
                'collection_money': item.thu_ho,
                'content': item.ghi_chu,
            },
        });
    }

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
});