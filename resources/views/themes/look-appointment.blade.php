@extends('layouts.app')

@section('title', 'Đội ngũ chuyên gia')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/css/findbook.css ') }}">
@stop

@section('content')
<div id="main-content">
    <div class="header-category" style="background-image: url(https://medlatec.vn/med/images/breadcrumb4.jpg);">
        <div class="container">
            <h1>Tra cứu lịch hẹn</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/">Trang chủ</a>
                </li>
                <li class="active">Tra cứu lịch hẹn</li>
            </ol>
        </div>
    </div>
    <div class="container">
        <div class="booking-search-wrapper py-5">
            <h2 class="text-center mb-4 text-primary">Tra cứu thông tin lịch hẹn</h2>
            <form action="" method="post" class="booking-search-form mx-auto">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <label for="booking_token" class="form-label">Mã lịch hẹn</label>
                        <input type="text" name="booking_token" id="booking_token" class="form-control mb-3" placeholder="Nhập mã lịch hẹn (ưu tiên)">
                    </div>
                    <div class="col-12 text-center my-3">
                        <h5>Hoặc tra cứu bằng email và ngày khám</h5>
                    </div>
                    <div class="col-md-5">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control mb-3">
                    </div>
                    <div class="col-md-5">
                        <label for="appointment_date" class="form-label">Ngày khám</label>
                        <input type="date" name="appointment_date" id="appointment_date" class="form-control mb-3">
                    </div>
                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary px-4">Tra cứu</button>
                    </div>
                </div>
            </form>
        </div>
        <div id="booking-result" class="container py-4" style="display: none;">
            <h3 class="text-primary mb-3">Kết quả tra cứu lịch hẹn</h3>
            <div id="booking-list" class="row gy-3"></div>
        </div>
    </div>
    <div id="show-model"></div>
    {{-- <div class="modal inmodal" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title">Kết quả khám bệnh</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white"
                        data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div> --}}
</div>
<div id="loading-overlay" style="display: none;">
    <div class="loading-content">
        <div class="spinner"></div>
        <p class="loading-text">Đang tải lịch hẹn <span class="dots"></span></p>
    </div>
</div>
@endsection

@section('custom-js')
@if (session('success'))
    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "progressBar": true,
            "preventDuplicates": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "400",
            "hideDuration": "10000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        toastr.success("{{session('success')}}")
    </script>
    @endif
    @if (session('error'))
    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "progressBar": true,
            "preventDuplicates": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "400",
            "hideDuration": "10000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        toastr.error("{{session('error')}}")
    </script>
@endif
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector(".booking-search-form");
        const overlay = document.getElementById("loading-overlay");
        const statusMap = {
            1: { label: 'Chưa xác nhận', color: 'secondary' },
            2: { label: 'Đã xác nhận', color: 'primary' },
            3: { label: 'Đã hủy', color: 'danger' },
            4: { label: 'Đang khám', color: 'warning' },
            5: { label: 'Chờ kết quả', color: 'info' },
            6: { label: 'Đã có kết quả', color: 'success' }
        };
    
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            let booking_token = document.getElementById('booking_token').value.trim();
            let email = document.getElementById('email').value.trim();
            let appointment_date = document.getElementById('appointment_date').value.trim();

            if (!booking_token && (!email || !appointment_date)) {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "progressBar": true,
                    "preventDuplicates": false,
                    "positionClass": "toast-top-right",
                    "onclick": null,
                    "showDuration": "400",
                    "hideDuration": "10000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }

                toastr.error("Vui lòng nhập đúng thông tin để tra cứu.");
                return;
            }
            overlay.style.display = "flex";
            $.ajax({
                url: '/api-get-book-appointment',
                method: 'GET',
                data: {
                    booking_token: booking_token,
                    email: email,
                    appointment_date: appointment_date
                },
                success: function (response) {
                    overlay.style.display = "none";

                    if (response.status === 'success' && response.data.length > 0) {
                        console.log(response)
                        const listContainer = document.getElementById("booking-list");
                        listContainer.innerHTML = "";

                        response.data.forEach((data) => {
                            const card = document.createElement("div");
                            card.className = "col-12";
                            const status = statusMap[data.status] || { label: 'Không rõ', color: 'dark' };

                            let actionButtons = '';
                            if (data.status === 1 || data.status === 2) {
                                actionButtons += `<button class="btn btn-danger btn-sm me-2 cancel-booking" data-id="${data.id}">Hủy lịch hẹn</button>`;
                            }
                            if (data.status === 6) {
                                actionButtons += `<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalResult${data.id}">Xem kết quả khám</button>`;
                            }

                            card.innerHTML = `
                                <div class="card shadow-sm p-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <strong>Họ tên bệnh nhân:</strong> <span>${data.name || ''}</span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <strong>Mã lịch hẹn:</strong> <span>${data.book_code || ''}</span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <strong>Ngày khám:</strong> <span>${data.date_examination || ''}</span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <strong>Giờ khám:</strong> <span>${data.appointment?.hour_examination || ''}</span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <strong>Bác sĩ khám:</strong> <span>${data.doctor?.name || ''}</span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <strong>Chuyên khoa:</strong> <span>${data.specialty?.name || ''}</span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <strong>Trạng thái:</strong>
                                            <span class="badge bg-${status.color}">${status.label}</span>
                                        </div>
                                        <div class="col-12">
                                            <strong>Ghi chú:</strong>
                                            <p>Bệnh nhân vui lòng đến trước 15 phút để làm thủ tục.</p>
                                        </div>
                                        <div class="col-12 d-flex justify-content-start">
                                            ${actionButtons}
                                        </div>
                                    </div>
                                </div>
                            `;
                            listContainer.appendChild(card);

                            if (data.status === 6 && data.result_examination) {
                                const modalContainer = document.getElementById("show-model");
                                const result = data.result_examination;

                                let content = `
                                    <div class="modal inmodal" id="modalResult${data.id}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog animated bounceInRight">
                                            <div class="modal-content animated fadeIn">
                                                <div class="modal-header bg-success text-white">
                                                    <button type="button" class="close text-danger" data-dismiss="modal">
                                                        <span aria-hidden="true">&times;</span>
                                                        <span class="sr-only">Close</span>
                                                    </button>
                                                    <h5 class="modal-title">Kết quả khám bệnh</h5>
                                                </div>
                                                <div class="modal-body">`;

                                if (result.diagnose) {
                                    content += `
                                        <div class="mb-3 p-3 rounded bg-light border">
                                            <strong>Chẩn đoán:</strong>
                                            <p>${result.diagnose}</p>
                                        </div>`;
                                }
                                
                                if (result.clinical_examination) {
                                    content += `
                                        <div class="mb-3 p-3 rounded bg-info-subtle border">
                                            <strong>Khám lâm sàng:</strong>
                                            <p>${result.clinical_examination}</p>
                                        </div>`;
                                }
                                
                                if (result.conclude) {
                                    content += `
                                        <div class="mb-3 p-3 rounded bg-success-subtle border">
                                            <strong>Kết luận:</strong>
                                            <p>${result.conclude}</p>
                                        </div>`;
                                }
                                
                                if (result.treatment) {
                                    content += `
                                        <div class="mb-3 p-3 rounded bg-warning-subtle border">
                                            <strong>Hướng điều trị:</strong>
                                            <p>${result.treatment}</p>
                                        </div>`;
                                }
                                
                                if (result.medicine) {
                                    content += `
                                        <div class="mb-3 p-3 rounded bg-secondary-subtle border">
                                            <strong>Thuốc kê:</strong>
                                            <p>${result.medicine}</p>
                                        </div>`;
                                }
                                
                                if (result.re_examination_date) {
                                    const reExamDate = new Date(result.re_examination_date * 1000).toLocaleDateString();
                                    content += `
                                        <div class="mb-3 p-3 rounded bg-danger-subtle border">
                                            <strong>Ngày tái khám:</strong>
                                            <p>${reExamDate}</p>
                                        </div>`;
                                }

                                content += `
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Đóng</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;

                                modalContainer.innerHTML += content;
                            }
                        });

                        document.getElementById("booking-result").style.display = "block";
                    } else {
                        swal({
                            title: "Không tìm thấy lịch hẹn!",
                            text: "Hãy kiểm tra lại thông tin bạn đã nhập",
                            type: "error"
                        });
                    }
                },
                error: function () {
                    overlay.style.display = "none";
                    swal({
                        title: "Lỗi hệ thống!",
                        text: "Không thể xử lý yêu cầu, vui lòng thử lại.",
                        type: "error"
                    });
                }
            });
        });
    });
</script>
@endsection