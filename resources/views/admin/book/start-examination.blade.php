@extends('layouts.admin')

@section('title', 'Khám bệnh')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Khám bệnh</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Trang chủ</a>
            </li>
            <li>
                <a>Lịch hẹn</a>
            </li>
            <li class="active">
                <strong>Bắt đầu khám bệnh</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Thông tin lịch hẹn</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6 b-r">
                            <div class="form-group">
                                <div class="col-sm-4 control-label fw-bold d-block">Mã lịch hẹn:</div>
                                <div class="col-sm-8 mb-3">
                                    <span class="fw-semibold text-danger">{{ $book->book_code }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 control-label fw-bold d-block">Thời gian khám:</div>
                                <div class="col-sm-8 mb-3">
                                    <span class="fw-semibold">{{ $book->appointment ? $book->appointment->hour_examination . ' - ' : '' }}{{ $book->date_examination }}</span>
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-4 control-label fw-bold d-block">Tên bệnh nhân:</div>
                                <div class="col-sm-8 mb-3">
                                    <span class="fw-semibold">{{ $book->name }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 control-label fw-bold d-block">Giới tính:</div>
                                <div class="col-sm-8 mb-3">
                                    <span class="fw-semibold">{{ $book->gender == 1 ? 'Nam' : 'Nữ' }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 control-label fw-bold d-block">Lý do:</div>
                                <div class="col-sm-8 mb-3">
                                    <span class="fw-semibold">
                                        {{ $book->reason }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Kết quả khám</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('book.handle_examination', $book->id) }}" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-12"><h3 class="text-dark">Thông tin chẩn đoán ban đầu</h3></label>
                            <div class="col-sm-12">
                                <textarea class="editor form-control message-input" name="diagnose">{{ old('diagnose', $examinationResult->diagnose ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-12"><h3 class="text-dark">Kết quả khám lâm sàng</h3></label>
                            <div class="col-sm-12">
                                <textarea class="editor form-control message-input" name="clinical_examination">{{ old('clinical_examination', $examinationResult->clinical_examination ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-12"><h3 class="text-dark">Kết luận</h3></label>
                            <div class="col-sm-12">
                                <textarea class="editor form-control message-input" name="conclude">{{ old('conclude', $examinationResult->conclude ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-12"><h3 class="text-dark">Hướng dẫn điều trị</h3></label>
                            <div class="col-sm-12">
                                <textarea class="editor form-control message-input" name="treatment">{{ old('treatment', $examinationResult->treatment ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-12"><h3 class="text-dark">Kê đơn thuốc</h3></label>
                            <div class="col-sm-12">
                                <textarea class="editor form-control message-input" name="medicine">{{ old('medicine', $examinationResult->medicine ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ngày tái khám khám</label>
                            <div class="col-sm-3 input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" class="form-control" id="re-examination-date" name="re_examination_date" value="{{ !empty($examinationResult->re_examination_date) ? date('d-m-Y', $examinationResult->re_examination_date) : '' }}">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                @if ($book->status == 2 || $book->status == 4)
                                    <button class="btn btn-primary" type="submit" data-action="waiting_result">Hoàn thành khám</button>
                                @endif
                                <button class="btn btn-success" type="submit" data-action="return_result">Trả kết quả</button>
                                <button class="btn btn-danger ladda-button ladda-button-send-mail" type="submit" data-action="return_result_to_email">Trả kết quả về email bệnh nhân <i class="fa fa-send"></i></button>
                                <input type="hidden" name="action" id="action-value">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
    @if (session('warning'))
        <script>
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "progressBar": false,
                "preventDuplicates": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "10000",
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            toastr.warning("{{session('warning')}}")
        </script>
    @endif

    <script>
        const today = new Date();
        $('#re-examination-date').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            // startDate: today,
            autoclose: true
        });

        Ladda.bind('.ladda-button-send-mail');

        document.querySelector('.form-horizontal').addEventListener('submit', function(event) {
            var buttonClicked = event.submitter;
            
            if (buttonClicked) {
                var action = buttonClicked.dataset.action;
                document.getElementById('action-value').value = action;
 
                if (action === 'return_result_to_email') {
                    buttonClicked.innerHTML = 'Đang gửi kết quả...';
                    var laddaButton = Ladda.create(buttonClicked);
                    laddaButton.start();
                }
            }
        });
    </script>
@endsection