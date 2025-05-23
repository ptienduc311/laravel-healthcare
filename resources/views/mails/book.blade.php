<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Xác nhận đặt lịch khám bệnh</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px;">
    <tr>
      <td>
        <table width="800" align="center" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden;">
          <tr>
            <td style="padding: 20px; background-color: #1976d2; color: #ffffff;">
              <h2 style="margin: 0;">Xác nhận đặt lịch khám bệnh</h2>
            </td>
          </tr>
          <tr>
            <td style="padding: 20px;">
              <p>Xin chào <strong>{{$name}}</strong>,</p>
              <p>Bạn đã đặt lịch khám thành công tại HealthCare.</p>
              <p>Dưới đây là thông tin bạn đã đăng ký:</p>

              <h3 style="margin-top: 30px; margin-bottom: 10px;">👥 Thông tin cá nhân</h3>
              <table cellpadding="8" cellspacing="0" width="100%" style="border-collapse: collapse;">
                <tr>
                  <td width="20%"><strong>Mã lịch hẹn:</strong></td>
                  <td>{{$book_code}}</td>
                </tr>
                <tr style="background-color: #f9f9f9;">
                  <td><strong>Họ tên:</strong></td>
                  <td>{{$name}}</td>
                </tr>
                <tr style="background-color: #f9f9f9;">
                  <td><strong>Ngày sinh:</strong></td>
                  <td>{{$birth}}</td>
                </tr>
                <tr style="background-color: #f9f9f9;">
                  <td><strong>Số điện thoại:</strong></td>
                  <td>{{$phone}}</td>
                </tr>
                <tr>
                  <td><strong>Email:</strong></td>
                  <td>{{$email}}</td>
                </tr>
                <tr>
                  <td><strong>Giới tính:</strong></td>
                  <td>{{$gender}}</td>
                </tr>
                <tr>
                  <td rowspan="2"><strong>Địa chỉ:</strong></td>
                  <td>{{$address_common}}</td>
                </tr>
                <tr>
                    <td>{{$address}}</td>
                </tr>
                <tr style="background-color: #f9f9f9;">
                  <td><strong>Lý do:</strong></td>
                  <td>{{$reason}}</td>
                </tr>
                <tr>
              </table>

              <h3 style="margin-top: 30px; margin-bottom: 10px;">📅 Thông tin lịch hẹn</h3>
              <table cellpadding="8" cellspacing="0" width="100%" style="border-collapse: collapse;">
                <tr>
                  <td width="20%"><strong>Ngày khám:</strong></td>
                  <td>{{$appointment_date}}</td>
                </tr>
                <tr style="background-color: #f9f9f9;">
                  <td><strong>Giờ khám:</strong></td>
                  <td>{{$appointment_time}}</td>
                </tr>
                <tr>
                  <td><strong>Bác sĩ:</strong></td>
                  <td>{{$doctor_name}}</td>
                </tr>
                <tr style="background-color: #f9f9f9;">
                  <td><strong>Chuyên khoa:</strong></td>
                  <td>{{$specialty_name}}</td>
                </tr>
              </table>
              <p style="font-size: 16px; color: #333; margin-bottom: 10px;">
                Để xác nhận lịch hẹn, bạn vui lòng click vào nút bên dưới:
              </p>
              <a href="{{$link_confirm_book}}"
                 style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">
                Xác nhận lịch hẹn
              </a>
              <p style="margin-top: 20px;">Vui lòng đến đúng giờ và mang theo mã lịch hẹn để được hỗ trợ tốt nhất.</p>
              <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.</p>
              <p>Trân trọng,<br><strong style="font-family: 'Brush Script MT', cursive; display: block; margin-top: 10px;">HealthCare</strong></p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
