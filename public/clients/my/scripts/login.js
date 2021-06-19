$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function(){
    $('#btnLogin').on('click', function () {
        var strEmail = $('#email').val();
        var strPassword = $('#password').val();
        var intRemember = $('#remember:checked').val();
        if(!strEmail){
            return bootbox.alert({
                message: "Cần nhập vào email trước !",
                backdrop: true
            });
        }
        if(!validateEmail(strEmail)){
            return bootbox.alert({
                message: "Địa chỉ email không hợp lệ !",
                backdrop: true
            });
        }
        if(!strPassword){
            return bootbox.alert({
                message: "Cần nhập vào mật khẩu !",
                backdrop: true
            });
        }
        
        bootbox.dialog({ 
            message: '<div class="text-center"><i class="fas fa-circle-notch fa-spin"></i></br> Đang tải...</div>', 
            closeButton: false 
        });

        if(!intRemember) {
            intRemember = 0;
        }

        $.ajax({
            url: '/ajax/login',
            type: 'POST',
            dataType: 'json',
            data: {
                email: strEmail,
                password: strPassword,
                remember: intRemember,
            },
            success: function(data) {
                if (data.constructor === String) {
                    data = JSON.parse(data);
                }
                if (data.success == true) {
                    location.reload();
                } else {
                    bootbox.hideAll();
                    return bootbox.alert({
                        message: data.messenger,
                        backdrop: true
                    });
                }
            }
        });
    })
});

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}