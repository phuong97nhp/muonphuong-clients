<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ admin</title>
</head>

<body>

<?php echo utf8_decode ('HỒ CHÍ MINH')."<br>"; echo utf8_encode(utf8_decode ('HỒ CHÍ MINH')); ?>

    <div id="app">
        <chuyenweb-app-view></chuyenweb-app-view>
    </div>

    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>