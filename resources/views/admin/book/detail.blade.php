@extends('layouts.admin')

@section('title', 'Thông tin lịch hẹn')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Lịch hẹn</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Trang chủ</a>
            </li>
            <li>
                <a>Lịch hẹn</a>
            </li>
            <li class="active">
                <strong>Thông tin chi tiết lịch hẹn</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-7">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Thông tin bệnh nhận</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('book.update', $book->id) }}" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tên bệnh nhân<span class="claim">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" value="{{old('name', $book->name)}}">
                                    @error('name')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Số điện thoại</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="phone" value="{{old('phone', $book->phone)}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email<span class="claim">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="email" name="email" value="{{old('email', $book->email)}}">
                                    @error('email')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Ngày sinh</label>
                                <div class="col-sm-9 input-group date" style="padding-right: 15px;padding-left: 15px;">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control" id="day-birth" value="{{old('birth', $book->birth)}}" name="birth">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Giới tính</label>
                                <div class="col-sm-9">
                                    <select class="form-control m-b" name="gender">
                                        <option value="1" {{ old('gender', $book->gender) == '1' ? 'selected' : '' }}>
                                            Nam
                                        </option>
                                        <option value="2" {{ old('gender', $book->gender) == '2' ? 'selected' : '' }}>
                                            Nữ
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Địa chỉ</label>
                                <div class="col-sm-9">
                                    <span style="display: block; padding-top: 7px;">{{ $book->ward?->name }}, {{ $book->district?->name }}, {{ $book->province?->name }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nơi ở</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="address" value="{{old('address', $book->address)}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Lý do</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control message-input" name="reason" id="reason">{{$book->reason}}</textarea>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    @if ($book->status != 3)
                                        <button class="btn btn-primary" type="submit">Cập nhật</button>
                                    @endif
                                    @if ($book->status != 1 && $book->status != 3)
                                        <a href="{{ route('book.start_examination', $book->id) }}" class="btn btn-success">
                                            Bắt đầu khám <i class="fa fa-play-circle"></i>
                                        </a>
                                    @endif
                                    @if ($book->status == 1 || $book->status == 2)
                                        <button class="btn btn-danger" type="button" id="btn-show-reason">
                                            <i class="fa fa-close"></i> Hủy hẹn
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group d-none">
                                <label class="col-sm-3 control-label">Lý do hủy hẹn</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control message-input" id="reason-cancel"></textarea>
                                    <button class="mt-3 btn btn-warning" type="button" id="btn-cancel-appointment" data-book-id="{{ $book->id }}">
                                        Gửi <i class="fa fa-send"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Thông tin lịch hẹn</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-4 control-label fw-bold d-block">Mã lịch hẹn:</div>
                            <div class="col-sm-8 mb-3">
                                <span class="fw-semibold text-danger">{{ $book->book_code }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 control-label fw-bold d-block">Trạng thái:</div>
                            <div class="col-sm-8 mb-3">
                                @php
                                    $status = $statusMap[$book->status] ?? ['name' => 'Không rõ', 'color' => 'dark'];
                                @endphp
                                <span class="fw-semibold text-{{ $status['color'] }}">{{ $status['name'] }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 control-label fw-bold d-block">Thời gian khám:</div>
                            <div class="col-sm-8 mb-3">
                                <span class="fw-semibold">
                                    {{ $book->appointment ? $book->appointment->hour_examination . ' - ' : '' }}{{ $book->date_examination }}
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 control-label fw-bold d-block">Bác sĩ:</div>
                            <div class="col-sm-8 mb-3">
                                <span class="fw-semibold">{{ $book->doctor?->name }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 control-label fw-bold d-block">Chuyên khoa:</div>
                            <div class="col-sm-8 mb-3">
                                <span class="fw-semibold">{{ $book->specialty?->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        $('#day-birth').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        });

        $('#btn-show-reason').on('click', function () {
            const $btn = $(this);
            const $cancelGroup = $btn.closest('.form-group').next('.form-group');
            const $reasonTextarea = $('#reason-cancel');

            if ($cancelGroup.hasClass('d-none')) {
                $cancelGroup.removeClass('d-none');
                $btn.text('Bỏ hủy');
                $reasonTextarea.focus();
            } else {
                $cancelGroup.addClass('d-none');
                $btn.html('<i class="fa fa-close"></i> Hủy hẹn');
                $reasonTextarea.val('');
            }
        });

        $(document).on('click', '#btn-cancel-appointment', function () {
            let bookId = $(this).data('book-id');
            let reason = $('#reason-cancel').val().trim();
            let email = $("#email").val();

            swal({
                title: "Hủy lịch hẹn",
                text: "Bạn có chắc chắn muốn hủy lịch hẹn không?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Chắc chắn",
                cancelButtonText: "Không",
                closeOnConfirm: false
            }, function (isConfirm) {
                if (isConfirm) {
                    const $btn = $('.sweet-alert .confirm');
                    $btn.addClass('ladda-button')
                    const ladda = Ladda.create($btn[0]);
                    ladda.start();
                    $btn.find('.ladda-label').text('Đang gửi email...');

                    $.ajax({
                        url: "{{ route('book.cancel') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            book_id: bookId,
                            email: email,
                            reason: reason
                        },
                        success: function (response) {
                            if (response.status == 'success') {
                                swal("Đã hủy!", response.message, "success");
                                setTimeout(() => {
                                    location.href = '/admin/book';
                                }, 1500);
                            } else {
                                swal("Lỗi", response.message, "error");
                            }
                        },
                        error: function () {
                            swal("Lỗi", "Không thể hủy lịch hẹn. Vui lòng thử lại.", "error");
                        },
                        complete: function () {
                            ladda.stop();
                        }
                    });
                }
            });
        });
    </script>
@endsection