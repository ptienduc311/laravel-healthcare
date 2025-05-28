<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 - Không tìm thấy trang</title>
    <link rel="stylesheet" href="{{ asset('assets/css/404.css') }}">
</head>
<body>
    <div class="page-404">
        <div class="page-404-content">
            <img class="img-fluid" src="{{ asset('assets/images/404-admin.png') }}">
            <h3>Không tìm thấy trang bạn yêu cầu.</h3>
            <a href="{{ route('admin.dashboard') }}">Quay lại trang chủ</a>
        </div>
    </div>
</body>
</html>