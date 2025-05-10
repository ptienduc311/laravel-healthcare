@extends('layouts.app')

@section('title', 'Giới thiệu HealthCare')

@section('content')
<div id="main-content">
    <div class="header-category" style="background-image: url(https://medlatec.vn/med/images/breadcrumb4.jpg);">
        <div class="container">
            <h1>Giới thiệu</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/">Trang chủ</a>
                </li>
                <li class="active">Giới thiệu</li>
            </ol>
        </div>
    </div>
    <div class="container">
        <div class="introduce">
            <h1 class="title">Giới thiệu HealthCare</h1>
            <p>Sức khỏe là tài sản quý giá nhất. Tuy nhiên, khi gặp vấn đề về sức khỏe, bạn dễ rơi vào trạng thái hoang mang, loay hoay giữa vô vàn lựa chọn về bác sĩ, phòng khám mà không biết đâu là đúng – đâu là phù hợp.</p>
            <p>Tại <strong>HealthCare</strong>, chúng tôi hiểu rõ những nỗi lo đó và mang đến giải pháp chăm sóc sức khỏe hiện đại, tiện lợi và đáng tin cậy cho mọi người dân.</p>

            <h2>🌟 HealthCare mang lại điều gì cho bạn?</h2>
            <h3>🔎 Tìm đúng – Chọn chuẩn</h3>
            <p>Thông tin bác sĩ, chuyên khoa, phòng khám luôn được kiểm duyệt và cập nhật minh bạch. Bạn có thể tự tin đưa ra quyết định phù hợp mà không cần phụ thuộc vào lời giới thiệu từ người thân hay mạng xã hội.</p>
            <h3>📅 Đặt lịch dễ dàng – Không chờ đợi</h3>
            <p>Chỉ vài thao tác, bạn đã có thể đặt lịch khám trực tuyến. Không còn phải xếp hàng hay gọi điện rườm rà – mọi thứ nằm gọn trong tay bạn.</p>
            
            <h2>🌟 Tầm nhìn & Sứ mệnh</h2>
            <p>Sứ mệnh của chúng tôi là mang lại cuộc sống khỏe mạnh cho cộng đồng thông qua các dịch vụ y tế tiên tiến, nhanh chóng và hiệu quả. HealthCare hướng tới trở thành trung tâm y tế được tin cậy và yêu mến nhất trong khu vực.</p>
            <p><strong>HealthCare – Vì sức khỏe của bạn, chúng tôi luôn sẵn sàng đồng hành!</strong></p>

            <div class="info-box">
                <h5><strong>📞 Thông tin liên hệ:</strong></h5>
                <p><strong>Hotline:</strong> {{ $site->hotline ?? 'Đang cập nhật' }}</p>
                <p><strong>Điện thoại:</strong> {{ $site->phone ?? 'Đang cập nhật' }}</p>
                <p><strong>Email:</strong> {{ $site->email ?? 'Đang cập nhật' }}</p>
                <p><strong>Địa chỉ:</strong> {{ $site->address ?? 'Đang cập nhật' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection