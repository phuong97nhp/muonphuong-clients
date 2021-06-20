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
                var html = '<option>=== Chọn quận huyện ===</option>';
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
                $('#ward').html('<option>=== Chọn xã phường ===</option>');
                break;
            case 'district':
                intIdAddrees = 'ward'
                var html = '<option>=== Chọn xã phường ===</option>';
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
                var html = '<option>=== Chọn tỉnh thành phố ===</option>';
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
                $('#ward').html('<option>=== Chọn xã phường ===</option>');
                $('#district').html('<option>=== Chọn quận huyện ===</option>');
                break;
        }
        $('#' + intIdAddrees).html(html)
    }
});