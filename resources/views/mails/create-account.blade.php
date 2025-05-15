<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Xác nhận tài khoản</title>
    <style>
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            color: #333;
        }

        p {
            color: #555;
            line-height: 1.5;
        }

        .note{
            font-size: 13px;
            font-style: italic;
        }

        .info {
            background-color: #f1f1f1;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
            margin-bottom: 20px;
        }

        .info strong {
            display: inline-block;
            width: 120px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn-confirm {
            background-color: #28a745;
            color: #fff !important;
        }

        .btn-cancel {
            background-color: #dc3545;
            color: #fff !important;
            margin-left: 10px;
        }

        .actions {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Xin chào,</h2>
    <p>
        Bạn nhận được email này vì quản trị viên của <strong>HealthCare</strong>
        (Dịch vụ đặt lịch khám chữa bệnh) đã tạo một tài khoản sử dụng email của bạn.
    </p>
    <p>Nếu bạn đồng ý tạo tài khoản, dưới đây là thông tin đăng nhập ban đầu:</p>

    <div class="info">
        <p><strong>Tên tài khoản:</strong> {{ $username }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Mật khẩu:</strong> {{ $password }}</p>
        <p><strong>Vai trò:</strong> {{ $roles }}</p>
        <p class="note">(Đăng nhập bằng email và mật khẩu)</p>
    </div>

    <div class="actions">
        @if (!$is_active)
            <p>Vui lòng nhấn vào nút bên dưới để kích hoạt tài khoản:</p>
            <a href="{{ $urlActive }}" class="btn btn-confirm">Xác nhận tài khoản</a>
        @endif

        <p>Nếu bạn không yêu cầu tạo tài khoản này, vui lòng nhấn "Hủy tài khoản" tại đây:</p>
        <a href="{{ $urlCancel }}" class="btn btn-cancel">Hủy tài khoản</a>
    </div>
    <p>Xin cảm ơn,<br><strong style="font-family: 'Brush Script MT', cursive; display: block; margin-top: 10px;">Hệ thống quản trị HealthCare</strong></p>
</div>
</body>
</html>
