@extends('layouts.admin')

@section('title', 'Danh sách lịch hẹn khám bệnh')
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
                <strong>Danh sách lịch hẹn khám bệnh</strong>
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
                <div class="ibox-content">
                    <div class="row mb-3">
                        <form action="{{ route('book.index') }}" method="get" class="row mb-4 ms-0" autocomplete="OFF">
                            @if ($isAdmin)
                            <div class="col-sm-2 m-b-xs">
                                <div class="input-group group-input-doctor">
                                    <input type="text" name="doctor_name" id="doctor-name-search" class="form-control input-sm" 
                                        placeholder="Nhập tên bác sĩ" 
                                        value="{{ old('doctor_name', $selectedDoctor?->name) }}"
                                        {{ $selectedDoctor ? 'readonly' : '' }}>

                                    <div class="doctor-dropdown" style="display: none;"></div>
                                    <input type="hidden" id="selected-doctor-id" name="doctor_id" value="{{ request('doctor_id') }}">

                                    @if ($selectedDoctor)
                                        <div class="doctor-badge">
                                            <div class="badge-content">
                                                <span>{{ $selectedDoctor->name }}</span>
                                            </div>
                                            <i class="fa fa-close close-btn"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-2 m-b-xs">
                                <select name="specialty_id" class="input-sm form-control input-s-sm inline">
                                    <option value="">Chọn chuyên khoa</option>
                                    @foreach ($medical_specialties as $item)
                                        <option value="{{ $item->id }}" {{ request('specialty_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="col-sm-2 m-b-xs">
                                <div class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control" id="date-examination" name="date_examination" value="{{ request('date_examination') }}" placeholder="Ngày khám">
                                </div>
                            </div>
                            <div class="col-sm-2 m-b-xs">
                                <select name="status" class="input-sm form-control input-s-sm inline">
                                    <option value="">Trạng thái</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Chưa xác nhận</option>
                                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Đã xác nhận</option>
                                    <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Hủy</option>
                                    <option value="4" {{ request('status') == '4' ? 'selected' : '' }}>Đang khám</option>
                                    <option value="5" {{ request('status') == '5' ? 'selected' : '' }}>Đang đợi kết quả</option>
                                    <option value="6" {{ request('status') == '6' ? 'selected' : '' }}>Đã có kết quả</option>
                                </select>
                            </div>
                            @if (!$isAdmin)
                                <div class="col-sm-4 m-b-xs"></div>
                            @endif
                            <div class="col-sm-1 m-b-xs"></div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" name="keyword" placeholder="Nhập tên hoặc email bệnh nhân"
                                           value="{{ request('keyword') }}"
                                           class="input-sm form-control">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mã lịch hẹn</th>
                                <th>Tên bệnh nhân</th>
                                <th>Thời gian khám</th>
                                <th>Bác sĩ</th>
                                <th>Trạng thái</th>
                                <th>Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($books as $key => $item)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>
                                    <a href="{{ route('book.show', $item->id) }}">
                                        <span class="text-danger fw-semibold">
                                            {{ $item->book_code }}
                                        </span>
                                    </a>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $item->name }}</span>
                                    <span class="d-block">{{ $item->email }}</span>
                                </td>
                                <td>
                                    <span class="fw-semibold">
                                        {{ $item->appointment ? $item->appointment->hour_examination . ' - ' : '' }}{{ $item->date_examination }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted font-bold">{{ $item->doctor?->name }}</span>
                                    {{ $item->doctor_id && $item->specialty_id ? " - " : "" }}
                                    <span class="text-muted font-bold">{{ $item->specialty?->name }}</span>
                                </td>
                                <td>
                                    @php
                                        $status = $statusMap[$item->status] ?? ['name' => 'Không rõ', 'color' => 'dark'];
                                    @endphp
                                    <span class="fw-semibold text-{{ $status['color'] }}">{{ $status['name'] }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('book.show', $item->id) }}" title="Thông tin chi tiết" class="edit">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @if ($item->status == 1 || $item->status == 2)
                                        <a title="Hủy lịch hẹn" class="delete" id="btn-cancel-appointment" data-book-id="{{ $item->id }}" data-email={{ $item->email }}>
                                            <i class="fa fa-window-close"></i>
                                        </a>
                                    @endif
                                    @if ($item->status == 2 || $item->status == 4)
                                        <a href="{{ route('book.start_examination', $item->id) }}" title="Bắt đầu khám" class="start">
                                            <i class="fa fa-play"></i>
                                        </a>
                                    @endif
                                    @if ($item->status == 5 || $item->status == 6)
                                        <a href="{{ route('book.start_examination', $item->id) }}" title="Kết quả khám" class="start">
                                            <i class="fa fa-file-text-o"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$books->links()}}
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
        $('#date-examination').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true
        });
        
        //Chọn tên bác sĩ
        const input = document.querySelector('#doctor-name-search');
        const dropdown = document.querySelector('.doctor-dropdown');
        const wrapper = document.querySelector('.group-input-doctor');
        const hiddenInput = document.querySelector('#selected-doctor-id');
    
        let selectedDoctorId = null;
        let canSearch = true;
    
        input.addEventListener('input', function () {
            const query = this.value.trim();
    
            if (!canSearch || query.length === 0) {
                dropdown.style.display = 'none';
                return;
            }
    
            fetch(`/admin/book/search-doctor?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(doctors => {
                    dropdown.innerHTML = '';
                    if (doctors.length === 0) {
                        dropdown.style.display = 'none';
                        return;
                    }
    
                    doctors.forEach(doc => {
                        const div = document.createElement('div');
                        div.className = 'doctor-item';
                        div.dataset.id = doc.id;
                        div.textContent = doc.name;
                        dropdown.appendChild(div);
                    });
    
                    dropdown.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error fetching doctors:', error);
                    dropdown.style.display = 'none';
                });
        });
    
        dropdown.addEventListener('click', function (e) {
            if (!e.target.classList.contains('doctor-item')) return;
    
            const id = e.target.dataset.id;
            const name = e.target.textContent;
    
            selectedDoctorId = id;
            hiddenInput.value = id;
            canSearch = false;
            input.value = name;
            input.placeholder = '';
            input.readOnly = true;
    
            dropdown.style.display = 'none';
    
            const badge = document.createElement('div');
            badge.className = 'doctor-badge';
            badge.innerHTML = `
                <div class="badge-content">
                    <span>${name}</span>
                </div>
                <i class="fa fa-close close-btn"></i>
            `;
            wrapper.appendChild(badge);
    
            // nút close
            badge.querySelector('.close-btn').addEventListener('click', function () {
                badge.remove();
                selectedDoctorId = null;
                hiddenInput.value = '';
                input.value = '';
                input.placeholder = 'Nhập tên bác sĩ';
                input.readOnly = false;
                canSearch = true;
                input.focus();
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const badge = document.querySelector('.doctor-badge');
            if (badge) {
                badge.querySelector('.close-btn').addEventListener('click', function () {
                    badge.remove();
                    selectedDoctorId = null;
                    hiddenInput.value = '';
                    input.value = '';
                    input.placeholder = 'Nhập tên bác sĩ';
                    input.readOnly = false;
                    canSearch = true;
                    input.focus();
                });
            }
        });

        //Hủy lịch hẹn
        $(document).on('click', '#btn-cancel-appointment', function () {
            let bookId = $(this).data('book-id');
            let email = $(this).data('email');

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
                            email: email
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