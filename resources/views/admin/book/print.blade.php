<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Phiếu chụp X-quang</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #000;
            padding: 40px;
            font-size: 14px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
        }
        .hospital {
            text-align: left;
        }
        .info-table, .result-table {
            width: 100%;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 5px;
            vertical-align: top;
        }
        h2 {
            color: red;
            text-align: center;
        }
        h3.title {
            text-transform: uppercase;
            margin-top: 20px;
            text-align: center;
        }
        h3.cat{
            color: #007BFF;
        }
        .result {
            margin-top: 15px;
            padding: 10px;
            border: 1px solid #999;
            border-radius: 6px;
        }
        .section.even {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
        }
        .section.odd {
            background: #fff3cd;
            color: #856404;
            padding: 10px;
            border-radius: 4px;
        }
        .footer {
            margin-top: 50px;
            display: flex;
            font-size: 13px;
        }

        .signature {
            text-align: right;
            margin-left: auto;
        }
        .small {
            font-size: 12px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="hospital">
        <strong>PHÒNG KHÁM HEALTHCARE</strong><br>
        Địa chỉ: {{ $address_clinic }}<br>
        Hotline: {{ $hotline }}
    </div>

    <div style="position: absolute; top: 40px; right: 40px; font-size: 13px;">
        Mã lịch hẹn: <strong>{{ $book_code }}</strong>
    </div>

    <h2>PHIẾU KẾT QUẢ KHÁM BỆNH</h2>

    <table class="info-table">
        <tr>
            <td><strong>Họ và tên:</strong> {{ $patient_name }}</td>
            <td><strong>Ngày sinh:</strong> {{ $patient_birth }}</td>
        </tr>
        <tr>
            <td><strong>Địa chỉ:</strong> {{ $patient_address }}</td>
            <td><strong>Giới tính:</strong> {{ $patient_gender }}</td>
        </tr>
        <tr>
            <td><strong>Email:</strong> {{ $patient_email }}</td>
            <td><strong>Số điên thoại:</strong> {{ $patient_phone }}</td>
        </tr>
        <tr>
            <td><strong>Bác sĩ chỉ định:</strong> {{ $doctor_specialty }}</td>
        </tr>
        <tr>
            <td><strong>Lịch hẹn:</strong> {{ $time_examination }}</td>
        </tr>
    </table>

    <h3 class="title">KẾT QUẢ</h3>
    <div class="wrapper">
        @php $i = 0; @endphp
        <div class="wrapper">
            @if ($diagnose)
                <h3 class="cat">Chẩn đoán ban đầu</h3>
                <div class="section {{ $i++ % 2 == 0 ? 'even' : 'odd' }}">
                    {!! $diagnose !!}
                </div>
            @endif

            @if ($clinical_examination)
                <h3 class="cat">Khám lâm sàng</h3>
                <div class="section {{ $i++ % 2 == 0 ? 'even' : 'odd' }}">
                    {!! $clinical_examination !!}
                </div>
            @endif

            @if ($conclude)
                <h3 class="cat">Kết luận</h3>
                <div class="section {{ $i++ % 2 == 0 ? 'even' : 'odd' }}">
                    {!! $conclude !!}
                </div>
            @endif

            @if ($treatment)
                <h3 class="cat">Hướng dẫn điều trị</h3>
                <div class="section {{ $i++ % 2 == 0 ? 'even' : 'odd' }}">
                    {!! $treatment !!}
                </div>
            @endif

            @if ($medicine)
                <h3 class="cat">Kê đơn thuốc</h3>
                <div class="section {{ $i++ % 2 == 0 ? 'even' : 'odd' }}">
                    {!! $medicine !!}
                </div>
            @endif

            @if ($re_examination_date)
                <h3 class="cat">Ngày tái khám</h3>
                <div class="section {{ $i++ % 2 == 0 ? 'even' : 'odd' }}">
                    <strong>{{ $re_examination_date }}</strong>
                </div>
            @endif
        </div>

    <div class="footer">
        <div class="signature">
            {{ $today }}<br>
            <strong>Bác sĩ</strong>
            <p><em><strong style="font-family: 'Brush Script MT', cursive; display: block;">{{ $doctor }}</strong></em></p>
        </div>
    </div>
</body>
</html>
