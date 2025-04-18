@extends('layouts.app')

@section('title', 'Bác sĩ Nguyễn Tú') {{-- Truyền biến --}}
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/css/listdoctor.css ') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/doctor.css ') }}">
@stop

@section('content')
<div id="main-content">
    <div class="header-category" style="background-image: url(https://medlatec.vn/med/images/breadcrumb4.jpg);">
        <div class="container">
            <h1>Đội ngũ chuyên gia</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/">Trang chủ</a>
                </li>
                <li>
                    <a href="">Đội ngũ chuyên gia</a>
                </li>
                <li class="active">TTND.GS.AHLĐ.BSCC Nguyễn Anh Trí</li>
            </ol>
        </div>
    </div>
    <div class="container-1200">
        <div class="doctor-single">
            <div class="doctor-single-info row">
                <div class="col-md-4">
                    <div class="avatar">
                        <img src="https://medlatec.vn/media/1505/catalog/quocdung-1.png?size=256" alt="">
                    </div>
                </div>
                <div class="doctor-single-detail col-md-8">
                    <div class="detail-top">
                        <div class="doctor-name">PGS.TS.BSCC Nguyễn Quốc Dũng</div>
                        <div class="doctor-review"><span style="color: #1D93E3;">Đánh giá:</span> <i class="fa-solid fa-star" style="color: #FFD43B;"></i>5/5</div>
                    </div>
                    <div class="detail-end">
                        <div class="doctor-special"><strong style="color: #1D93E3;">Chuyên khoa:</strong> Chẩn đoán hình ảnh</div>
                        <div class="doctor-level"><strong style="color: #1D93E3;">Trình độ:</strong> Phó giáo sư</div>
                        <div class="doctor-experience"><strong style="color: #1D93E3;">Số năm kinh nghiệm:</strong> hơn 40 năm</div>
                        <div class="doctor-price"><i class="fa-solid fa-hand-holding-dollar" style="color: #1D93E3;"></i> 500.000đ</div>
                    </div>
                </div>
            </div>
            <div class="make-appointment">
                <div class="book-title">Đặt lịch khám cùng chuyên gia</div>
                <div class="book-note">Quý khách hàng vui lòng điền thông tin để đặt lịch thăm khám cùng <span style="color: #1D93E3;">PGS.TS.BSCC Nguyễn Quốc Dũng</span></div>
                <div class="bookings">
                    <form action="" method="post">
                        <div class="form">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Họ và tên <sup>*</sup></label>
                                    <div class="control">
                                        <input type="text" name="patientName" class="form-control" id="patientName" placeholder="Nhập họ và tên">
                                        <div class="error" style="display: none;" id="patientName-error">Họ và tên không được để trống</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Số điện thoại <sup>*</sup></label>
                                    <div class="control">
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Nhập số điện thoại">
                                        <div class="error" style="display: none;" id="phone-error">Số điện thoại không được để trống</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Ngày sinh <sup>*</sup></label>
                                    <div class="control">
                                        <input type="date" name="patientBirthDate" class="form-control" id="patientBirthDate">
                                        <div class="error" style="display: none;" id="patientBirthDate-error">Ngày sinh không hợp lệ</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Email <sup>*</sup></label>
                                    <div class="control">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Nhập email">
                                        <div class="error" style="display: none;" id="email-error">Email không được để trống</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Giới tính <sup>*</sup></label>
                                    <div class="control">
                                        <select name="patientSex" class="form-control" id="patientSex">
                                            <option>Chọn giới tính</option>
                                            <option value="male">Nam</option>
                                            <option value="female">Nữ</option>
                                        </select>
                                        <div class="error" style="display: none;" id="patientBirthDate-error">Giới tính không được để trống</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Tỉnh/Thành phố <sup>*</sup></label>
                                    <div class="control filter-province">
                                        <div class="select-btn form-control">
                                            <span style="color: 4f4f4f;opacity: 0.5;font-weight: 600;">Chọn Tỉnh/Thành phố</span>
                                            <i class="fa-solid fa-angle-down"></i>
                                        </div>
                                        <div class="options-content">
                                            <div class="search">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                                <input type="text" placeholder="Search" class="search-input">
                                            </div>
                                            <ul class="options" id="province">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Quận/Huyện <sup>*</sup></label>
                                    <div class="control">
                                        <select name="district" class="form-control" id="district">
                                        </select>
                                        <div class="error" style="display: none;" id="district-error">Quận/Huyện không được để trống</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Phường/Xã <sup>*</sup></label>
                                    <div class="control">
                                        <select name="ward" class="form-control" id="ward">
                                        </select>
                                        <div class="error" style="display: none;" id="ward-error">Phường/Xã không được để trống</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Địa chỉ <sup>*</sup></label>
                                    <div class="control">
                                        <input type="text" name="address" id="address" class="form-control" placeholder="Nhập địa chỉ">
                                        <div class="error" style="display: none;" id="email-error">Địa chỉ không được để trống</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Chuyên khoa <sup>*</sup></label>
                                    <div class="control">
                                        <input type="text" name="special" id="special" class="form-control" value="Chuẩn đoán hình ảnh">
                                        <div class="error" style="display: none;" id="special-error">Quận/Huyện không được để trống</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Ngày khám <sup>*</sup></label>
                                    <div class="control">
                                        <input type="date" name="appointmentDate" id="appointmentDate" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Ngày khám <sup>*</sup></label>
                                    <div class="control">
                                        <input type="date" name="appointmentDate" id="appointmentDate" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Chọn giờ <sup>*</sup></label>
                                    <div class="control swiper swiperTimeMeet">
                                        <div class="swiper-wrapper">
                                        </div>
                                        <div class="swiper-button-prev">
                                            <i class="fa-solid fa-angle-left"></i>
                                        </div>
                                        <div class="swiper-button-next">
                                            <i class="fa-solid fa-angle-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Nội dung yêu cầu <sup>*</sup></label>
                                    <div class="control">
                                        <textarea name="reasonNote" id="reasonNote" class="form-control" placeholder="Tôi cảm thấy..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn-book btn btn-primary">Đặt lịch</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="doctor-single-content">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card-left introduce">
                            <div class="top-title">Giới thiệu</div>
                            <div class="main-content">
                                <p><span style="font-family: 'times new roman', times; font-size: 14pt;"><strong>Tiến sĩ, Bác sĩ Lê Quốc Việt</strong> Nguyên Giám đốc Trung tâm Cơ Xương khớp, Phó giám đốc Bệnh Viện E. Hơn 30 năm kinh nghiệm khám và điều trị các bệnh nội cơ xương khớp. Hiện tại&nbsp;<strong>Tiến sĩ, Bác sĩ</strong><strong style="font-family: 'times new roman', times;">&nbsp;</strong><strong style="font-family: 'times new roman', times;">Lê Quốc Việt </strong>đang là Giám đốc <strong>P</strong><strong style="font-family: 'times new roman', times;">hòng khám đa khoa Mediplus (Tổ hợp ý tế Mediplus).</strong></span></p>
                                <p><span style="font-family: 'times new roman', times; font-size: 14pt;"><strong><span style="font-family: times new roman, times;">Lịch khám&nbsp;</span>Bác sĩ Lê Quốc Việt</strong></span></p>
                                <ul>
                                <li><span style="font-family: 'times new roman', times; font-size: 14pt;"><span style="font-family: times new roman, times;">Thứ 2 đến Chủ nhật: Sáng (8h00 - 12h00); Chiều (13h30 - 17h00)</span></span></li>
                                </ul>
                                <p><span style="font-family: 'times new roman', times; font-size: 14pt;"><span style="font-family: times new roman, times;">Để biết Lịch khám chính xác của&nbsp;</span><a href="https://bcare.vn/danh-sach/bac-si/le-quoc-viet-767/chi-tiet"><strong style="font-family: 'times new roman', times;">Bác sĩ Lê Quốc Việt</strong></a><span style="font-family: times new roman, times;">. Vui Lòng gọi Hotline <strong>0941298865</strong> để được thư ký y khoa tư vấn, hỗ trợ!</span></span></p>
                                <p><span style="font-family: 'times new roman', times; font-size: 14pt;"><strong><span style="font-family: times new roman, times;">Quy trình đăng ký khám&nbsp;</span>Bác sĩ Lê Quốc Việt<span style="font-family: times new roman, times;">&nbsp;như sau:</span></strong></span></p>
                                <ul>
                                <li><span style="font-family: 'times new roman', times; font-size: 14pt;"><span style="font-family: times new roman, times;">Bước 1: Gọi Hotline: <strong>0941298865</strong> Hoặc Điền đầy đủ thông tin của người khám, bao gồm họ tên, giới tính, ngày sinh, số điện thoại, địa chỉ (tỉnh/thành, quận/huyện, phường/xã), và mô tả triệu chứng (nếu có).</span></span></li>
                                <li><span style="font-family: 'times new roman', times; font-size: 14pt;"><span style="font-family: times new roman, times;">Bước 2: Nhấn nút "Đặt lịch". Thư ký y khoa sẽ nhanh chóng liên hệ với bạn để xác nhận và hoàn tất quy trình đăng ký khám.</span></span></li>
                                </ul>
                                <p><span style="font-family: 'times new roman', times; font-size: 14pt;"><strong><span style="font-family: times new roman, times;">Quy trình thăm khám&nbsp;</span>Bác sĩ Lê Quốc Việt<span style="font-family: times new roman, times;">&nbsp;như sau:</span></strong></span></p>
                                <ul>
                                <li><span style="font-family: 'times new roman', times; font-size: 14pt;"><span style="font-family: times new roman, times;">Bước 1: Đăng ký khám và nhận tư vấn ban đầu</span></span></li>
                                <li><span style="font-family: 'times new roman', times; font-size: 14pt;"><span style="font-family: times new roman, times;">Bước 2: Bác sĩ khám lâm sàng và cho chỉ định cần thiết</span></span></li>
                                <li><span style="font-family: 'times new roman', times; font-size: 14pt;"><span style="font-family: times new roman, times;">Bước 3: Bác sĩ đưa kết luận và kê đơn thuốc sau khi tổng hợp kết quả</span></span></li>
                                </ul>
                                <p><span style="font-family: 'times new roman', times; font-size: 14pt;"><strong>Tiến sĩ, Bác sĩ</strong><strong style="font-family: 'times new roman', times;">&nbsp;</strong><strong style="font-family: 'times new roman', times;">Lê Quốc Việt Khám và điều trị</strong></span></p>
                                <ul>
                                <li><span style="font-family: 'times new roman', times; font-size: 14pt;"><strong>Thoái hóa đa khớp ( cột sống thắt lưng, cột sống cổ, khớp gối, khớp háng..)</strong>: Nguyên nhân bệnh do tuổi (trên 60t),nghề nghiệp, sang chấn, chấn thương, viêm nhiễm...gây ra sưng, đau, cứng khớp, , cử động khớp thấy có tiếng động bất thường , cứng khớp buổi sáng, hai chân tê bì , mất cảm giác, cứng cổ, đau cổ, chóng mặt , đau đầu , vai yếu, sức lực của tay giảm….biến dạng hạn chế vận động ảnh hưởng đến chất lượng cuốc sống, ( đi lại , lên xuống cầu thang, vận động .... mất ngủ) . Nếu không chẩn đoán và điều trị kịp thời có thể gây bệnh mạn tính lâu dài mất khả năng vận động. Thường gặp thoái hóa khớp gối, cột sống cổ, thắt lưng, khớp háng và các khớp bàn ngón tay</span></li>
                                <li><span style="font-family: 'times new roman', times; font-size: 14pt;"><strong>Loãng xương</strong>: Biểu hiện đau xương, đau lưng êm ẩm, tê mỏi, buốt, khó chịu. Cột sống có thể bị gù, vẹo, khó thở do hạn chế giãn nở lồng ngực, dễ gãy xương sau những sang chấn nhẹ. Đôi khi người bệnh không có triệu chứng khi phát hiện thì đã muộn. Nguy cơ xẹp đốt sống, gẫy cố xương đùi hay đầu dưới xương cánh tay. Chất lượng cuộc sống giảm nhiều</span></li>
                                <li><span style="font-family: 'times new roman', times; font-size: 14pt;"><strong>Viêm khớp dạng thấp</strong>: Bệnh biểu hiện ở các khớp nhỡ nhỏ, có tính chất đối xứng ( khớp bàn ngón tay , ngón chân, khớp cổ tay, khớp gối....) thường có những đợt sưng đau xen kẽ,cứng khớp buổi sáng,mệt mỏi, suy nhược …sưng, nóng, đỏ đau hay gặp, cứng khớp buổi sáng, viêm khớp đối xứng, di chuyển.</span></li>
                                <li><span style="font-family: 'times new roman', times; font-size: 14pt;"><strong>Đau thần kinh tọa</strong>: do một tác nhân nào đó ảnh hưởng đến đường dẫn truyền thần kinh gây đau dọc theo đường đi của dây thần kinh chi phối như dau từ cột sống thắt lưng lan xuống đùi, cẳng chân và bàn chân</span></li>
                                <li><span style="font-family: 'times new roman', times; font-size: 14pt;"><strong>Gout</strong>: Bệnh thường gặp ở nam giới, tuổi 30- 60 tuổi gây ra những đợt viêm cấp tính của một vài khớp với các triệu chứng cấp tính sưng, nóng, đỏ đau không thể chịu đựng được, bệnh thuyên giảm rồi lại có những đợt tái phát hậu quả nếu không được phát hiện, điều trị kịp thời có thể gây ra các biến chứng về thận, hay để lại các u cục tại khớp.</span></li>
                                </ul>
                                <p><span style="font-family: 'times new roman', times; font-size: 14pt;"><span style="font-family: times new roman, times;"><strong>Một số hình ảnh thăm khám của </strong></span><strong style="font-family: 'times new roman', times;">Bác sĩ Lê Quốc Việt</strong></span></p>
                                <p><span style="font-family: 'times new roman', times; font-size: 14pt;"><img src="https://cdn.bcare.vn/source/bac-si/bs-le-quoc-viet-1.jpg" alt="bs-le-quoc-viet-1"> </span></p>
                                <p><span style="font-family: 'times new roman', times; font-size: 14pt;"><img src="https://cdn.bcare.vn/source/bac-si/bs-le-quoc-viet-2.jpg" alt="bs-le-quoc-viet-2"> </span></p>                                                    
                            </div>  
                        </div>
                        <div class="card-left experience">
                            <div class="top-title">Kinh nghiệm</div>
                            <div class="main-content">
                                
                            </div>
                        </div>
                        <div class="card-left train">
                            <div class="top-title">Quá trình đào tạo</div>
                            <div class="main-content">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card-right office">
                            <div class="top-title">Chức vụ</div>
                            <div class="main-content">
                                
                            </div>
                        </div>
                        <div class="card-right workplace">
                            <div class="top-title">Nơi công tác</div>
                            <div class="main-content">
                                
                            </div>
                        </div>
                        <div class="card-right prize">
                            <div class="top-title">Giải thưởng và ghi nhận</div>
                            <div class="main-content">
                                
                            </div>
                        </div>
                        <div class="card-right organization-member">
                            <div class="top-title">Thành viên của các tổ chức</div>
                            <div class="main-content">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection