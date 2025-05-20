<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kết quả khám bệnh - HealthCare</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f9f9f9; padding: 20px; color: #333;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 700px; margin: auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 30px;">
        <tr>
            <td>
                <h2 style="color: #007BFF; border-bottom: 1px solid #eee; padding-bottom: 10px;">Kết quả khám bệnh của bạn đã sẵn sàng!</h2>

                <p>Xin chào <strong>{{ $patient_name }}</strong>,</p>
                <p>Chúng tôi xin thông báo kết quả khám bệnh của bạn từ ngày <strong>{{ $examination_date }}</strong> đã được cập nhật.</p>

                <p style="margin-top: 15px; background: #f1f1f1; padding: 12px 15px; border-left: 4px solid #007BFF; border-radius: 6px;">
                    <strong>Mã khám bệnh:</strong> <span style="color: #007BFF;">{{ $book_code }}</span><br>
                    Bạn có thể tra cứu kết quả khám bệnh của mình bất kỳ lúc nào bằng cách truy cập liên kết sau:<br>
                    <a href="{{ $lookup_url }}" style="color: #007BFF; text-decoration: underline;">{{ $lookup_url }}</a>
                </p>

                <p>Dưới đây là thông tin kết quả khám bệnh của bạn:</p>

                <hr style="border: none; border-top: 1px solid #eee; margin: 25px 0;">

                @if (!empty($diagnose))
                    <h3 style="color: #444;">Chẩn đoán ban đầu</h3>
                    <div style="background: #f2f6fc; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px;">
                        {!! $diagnose !!}
                    </div>
                @endif

                @if (!empty($clinical_examination))
                    <h3 style="color: #444;">Khám lâm sàng</h3>
                    <div style="background: #f9f9f9; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px;">
                        {!! $clinical_examination !!}
                    </div>
                @endif

                @if (!empty($conclude))
                    <h3 style="color: #444;">Kết luận</h3>
                    <div style="background: #f2f6fc; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px;">
                        {!! $conclude !!}
                    </div>
                @endif

                @if (!empty($treatment))
                    <h3 style="color: #444;">Hướng dẫn điều trị</h3>
                    <div style="background: #f9f9f9; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px;">
                        {!! $treatment !!}
                    </div>
                @endif

                @if (!empty($medicine))
                    <h3 style="color: #444;">Kê đơn thuốc</h3>
                    <div style="background: #f2f6fc; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px;">
                        {!! $medicine !!}
                    </div>
                @endif

                @if (!empty($re_examination_date))
                    <h3 style="color: #444;">Ngày tái khám</h3>
                    <div style="background: #fff3cd; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px; color: #856404;">
                        <strong>{{ $re_examination_date }}</strong>
                    </div>
                @endif

                <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">

                <p style="font-size: 15px;">Cảm ơn bạn đã tin tưởng <strong>Phòng khám HealthCare</strong>. Chúng tôi hy vọng bạn có trải nghiệm tốt và sức khỏe được cải thiện.</p>

                <p style="font-size: 15px;">Nếu bạn có bất kỳ câu hỏi nào, xin vui lòng liên hệ với chúng tôi. Hẹn gặp lại bạn trong lần tái khám tới.</p>

                <blockquote style="margin: 20px 0; padding-left: 15px; border-left: 4px solid #007BFF; color: #555;">
                    <strong>HealthCare:</strong> <em>Đặt niềm tin - Nhận chăm sóc tận tâm</em>
                </blockquote>

                <p style="margin-top: 30px;">Trân trọng,</p>
                <p><em><strong style="font-family: 'Brush Script MT', cursive; display: block; margin-top: 10px;">HealthCare</strong></em></p>
            </td>
        </tr>
    </table>
</body>
</html>
