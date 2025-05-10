<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Thông báo hủy lịch hẹn</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 6px;">
        <h2 style="background-color: #d9534f; color: #ffffff; padding: 15px; border-radius: 4px; text-align: center; margin: 0;">
            THÔNG BÁO HỦY LỊCH HẸN
        </h2>
        <div style="padding: 30px;">
          <p>Xin chào <strong>{{ $name }}</strong>,</p>
          <p>Chúng tôi xin thông báo rằng lịch hẹn khám bệnh của bạn đã được <strong>hủy</strong> với các thông tin như sau:</p>

          <ul>
              <li><strong>Mã lịch hẹn:</strong> {{ $book_code }}</li>
              <li><strong>Thời gian khám:</strong> {{ $time_examination }}</li>
              <li><strong>Bác sĩ:</strong> {{ $doctor_name }}</li>
              <li><strong>Chuyên khoa:</strong> {{ $specialty }}</li>
          </ul>

          <p><strong>Lý do hủy:</strong> {{ $reason }}</p>

          <p>Nếu bạn có bất kỳ thắc mắc nào hoặc muốn đặt lại lịch hẹn, vui lòng liên hệ với chúng tôi qua số điện thoại hoặc email hỗ trợ:</p>

          <ul>
              <li><strong>Email:</strong> {{ $email_web }}</li>
              <li><strong>Điện thoại:</strong> {{ $phone }}</li>
          </ul>

          <p>Trân trọng,<br><strong style="font-family: 'Brush Script MT', cursive; display: block; margin-top: 10px;">HealthCare</strong></p>
        </div>

    </div>
</body>
</html>
