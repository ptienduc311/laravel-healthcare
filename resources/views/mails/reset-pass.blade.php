<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Đăng ký tài khoản</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
            box-sizing: border-box;
            font-size: 14px;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            height: 100%;
            line-height: 1.6;
        }
        
        table td {
            vertical-align: top;
        }

        body {
            background-color: #f6f6f6;
        }

        .body-wrap {
            background-color: #f6f6f6;
            width: 100%;
        }

        .container {
            display: block !important;
            max-width: 600px !important;
            margin: 0 auto !important;
            clear: both !important;
        }

        .content {
            max-width: 600px;
            margin: 0 auto;
            display: block;
            padding: 20px;
        }

        .main {
            background: #fff !important;
            border: 1px solid #e9e9e9;
            border-radius: 3px;
        }

        .content-wrap {
            padding: 20px;
        }

        .content-block {
            padding: 0 0 20px;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
        }

        h1, h2, h3 {
            font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
            color: #000;
            margin: 40px 0 0;
            line-height: 1.2;
            font-weight: 400;
        }

        h1 {
            font-size: 32px;
            font-weight: 500;
        }

        h2 {
            font-size: 24px;
        }

        h3 {
            font-size: 18px;
        }

        h4 {
            font-size: 14px;
            font-weight: 600;
        }

        p, ul, ol {
            font-weight: normal;
        }
        p li, ul li, ol li {
            margin-left: 5px;
            list-style-position: inside;
        }

        a {
            color: #007bff;
            text-decoration: underline;
        }

        p.phone,
        p.email {
            font-size: 14px;
            color: #555;
            font-style: italic;
            opacity: 0.8;
        }

        span.phone,
        .email {
            color: #cc0909;
            font-weight: bold;
            margin-top: 5px;
        }

        .link-redirect{
            font-size: 16px;
            background-color: red;
            color: #fff !important;
            padding: 8px 30px;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .link-redirect:hover{
            background-color: #E90101;
            text-decoration: underline;
        }

        .text-center{
            text-align: center;
        }

        .btn-redirect {
            text-decoration: none;
            color: #FFF !important;
            background-color: #007bff;
            border: solid #007bff;
            border-width: 5px 10px;
            line-height: 2;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            display: inline-block;
            border-radius: 5px;
            text-transform: capitalize;
            transition: 0.3s;
        }

        .btn-redirect:hover{
            background-color: #0070e7;
            border: solid #0070e7;
            border-width: 5px 10px;
        }

        .pb-10{
            padding-bottom: 10px !important;
        }

        .aligncenter {
            text-align: center;
        }

        .clear {
            clear: both;
        }
        
        .alert {
            font-size: 16px;
            color: #fff !important;
            font-weight: 700;
            padding: 20px;
            text-align: center;
            border-radius: 3px 3px 0 0;
        }
        .alert a {
            color: #fff !important;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
        }
        .alert.alert-warning {
            background: #f8ac59;
        }
        .alert.alert-bad {
            background: #ed5565;
        }
        .alert.alert-good {
            background: #007bff;
        }

        @media only screen and (max-width: 640px) {
            h1, h2, h3, h4 {
                font-weight: 600 !important;
                margin: 20px 0 5px !important;
            }

            h1 {
                font-size: 22px !important;
            }

            h2 {
                font-size: 18px !important;
            }

            h3 {
                font-size: 16px !important;
            }

            .container {
                width: 100% !important;
            }

            .content, .content-wrap {
                padding: 10px !important;
            }
        }
    </style>
</head>

<body>

    <table class="body-wrap">
        <tr>
            <td></td>
            <td class="container" width="600">
                <div class="content">
                    <table class="main" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="alert alert-good">
                                Đặt lại mật khẩu
                            </td>
                        </tr>
                        <tr>
                            <td class="content-wrap">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="content-block">
                                            Xin chào <strong>{{$username}}</strong>,
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu của bạn. Nếu bạn không yêu cầu điều này, vui lòng bỏ qua email này.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            Để đặt lại mật khẩu, hãy nhấp vào nút dưới đây:
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            <a href="{{$urlResetPass}}" class="btn-redirect">Đặt lại mật khẩu</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block pb-10">
                                            Nếu bạn gặp bất kỳ vấn đề nào, vui lòng liên hệ với chúng tôi:
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block pb-10">
                                            <p class="phone">Qua số điện thoại: <span class="phone">0338.237.xxx</span></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            <p class="email">Qua email: <a href="mailto:healthcare@gmail.com" class="email">healthcare@gmail.com</a></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            Trân trọng,
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            <strong style="font-family: 'Brush Script MT', cursive; display: block; margin-top: 10px;">HealthCare</strong>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td></td>
        </tr>
    </table>

</body>

</html>