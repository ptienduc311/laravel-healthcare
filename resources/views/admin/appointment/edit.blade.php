@extends('layouts.admin')

@section('title', 'Sửa lịch khám bệnh')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Bác sĩ</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Trang chủ</a>
            </li>
            <li>
                <a>Bác sĩ</a>
            </li>
            <li class="active">
                <strong>Thêm lịch khám bệnh</strong>
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
                    <h5>Bác sĩ {{$doctor->name}}</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('appointment.update', ['doctorId' => $doctorId, 'date' => $date]) }}" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ngày khám <span class="claim">*</span></label>
                            <div class="col-sm-3 input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" class="form-control" id="day-examination" value="{{ date('d-m-Y', $date) }}" name="day_examination">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                @error('day_examination')
                                    <p class="error">{{ $message }}</p>
                                @enderror    
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Khoảng thời gian khám</label>
                            <div class="col-sm-2 px-0">
                                <select class="form-control m-b" id="time-interval">
                                    <option value="15">15 phút</option>
                                    <option value="30" selected>30 phút</option>
                                    <option value="60">1 giờ</option>
                                    <option value="120">2 giờ</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10 mt-3">
                                <div class="radio radio-success radio-inline pt-0">
                                    <input type="radio" id="all-day" value="all_day" name="type_time">
                                    <label for="all-day">Cả ngày</label>
                                </div>
                                <div class="radio radio-warning radio-inline pt-0">
                                    <input type="radio" id="morning" value="morning" name="type_time">
                                    <label for="morning">Sáng</label>
                                </div>
                                <div class="radio radio-danger radio-inline pt-0">
                                    <input type="radio" id="afternoon" value="afternoon" name="type_time">
                                    <label for="afternoon">Chiều</label>
                                </div>
                                <div class="radio radio-inline pt-0">
                                    <input type="radio" id="night" value="night" name="type_time">
                                    <label for="night">Tối</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Chọn giờ khám <span class="claim">*</span></label>
                            <div class="col-sm-10 px-0" id="time-slots">
                                @foreach ($appointments as $item)
                                    <label class="timeline-item me-2 mb-2 d-inline-block{{ $item->is_appointment == 1 ? " have-appointment" : "" }}">
                                        <input type="checkbox" name="hour_examination[]" value="{{ $item->hour_examination }}" checked>
                                        {{ $item->hour_examination }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                @if($errors->has('hour_examination'))
                                    <p class="error">{{ $errors->first('hour_examination') }}</p>
                                @endif   
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">Sửa lịch khám</button>
                                <a href="/admin/appointment" class="btn btn-info ms-2">Quay lại</a>
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
<script>
    const dateVal = $('#day-examination').val();
    $('#day-examination').datepicker({
        format: 'dd-mm-yyyy',
        startDate: dateVal,
        endDate: dateVal,
        autoclose: true
    });

    function generateTimeSlots(interval) {
        const start = 7 * 60;
        const end = 23 * 60;
        const slots = [];

        for (let time = start; time <= end; time += interval) {
            const hours = Math.floor(time / 60);
            const minutes = time % 60;
            const timeStr = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
            slots.push({ timeStr, minutes: time });
        }

        return slots;
    }

    function renderTimeSlots() {
        const interval = parseInt($('#time-interval').val());
        const slots = generateTimeSlots(interval);
        const container = $('#time-slots');
        container.empty();

        slots.forEach(slot => {
            const checkbox = `
                <label class="timeline-item me-2 mb-2 d-inline-block">
                    <input type="checkbox" name="hour_examination[]" value="${slot.timeStr}" data-minutes="${slot.minutes}"> ${slot.timeStr}
                </label>
            `;
            container.append(checkbox);
        });
    }

    function handleTimeTypeSelection(radio) {
        const selected = radio.val();
        const alreadyChecked = radio.data('checked') || false;
        const interval = parseInt($('#time-interval').val());

        if (alreadyChecked) {
            // Nếu đã chọn trước → bỏ chọn
            $('input[name="type_time"]').prop('checked', false).data('checked', false);
            $('input[name="hour_examination[]"]').prop('checked', false);
            return;
        }

        // Đánh dấu radio được chọn
        $('input[name="type_time"]').data('checked', false);
        radio.data('checked', true);

        let start = 0, end = 0;
        switch (selected) {
            case 'all_day':
                start = 7 * 60;
                end = 23 * 60;
                break;
            case 'morning':
                start = 7 * 60;
                end = 12 * 60 + 59;
                break;
            case 'afternoon':
                start = 13 * 60;
                end = 17 * 60 + 59;
                break;
            case 'night':
                start = 18 * 60;
                end = 23 * 60;
                break;
            default:
                return;
        }

        $('input[name="hour_examination[]"]').each(function () {
            const time = parseInt($(this).data('minutes'));
            console.log(time)
            if (time >= start && time <= end) {
                $(this).prop('checked', true);
            } else {
                $(this).prop('checked', false);
            }
        });
    }

    $(document).ready(function () {
        // renderTimeSlots();

        $('#time-interval').on('change', function () {
            renderTimeSlots();
            const checkedRadio = $('input[name="type_time"]:checked');
            if (checkedRadio.length) {
                handleTimeTypeSelection(checkedRadio);
            }
        });

        $('input[name="type_time"]').on('click', function () {
            handleTimeTypeSelection($(this));
        });
    });
</script>

@endsection