$(document).ready(function () {
    $(".fileinput").each(function () {
        // Chọn ảnh
        const fileinput = $(this);
        const preview = fileinput.find(".fileinput-preview");

        const updatePreviewVisibility = () => {
            if (fileinput.hasClass("fileinput-exists")) {
                preview.show();
            } else {
                preview.hide();
            }
        };
        updatePreviewVisibility();
        new MutationObserver(updatePreviewVisibility).observe(this, {
            attributes: true,
            attributeFilter: ["class"]
        });

        // Xóa ảnh
        fileinput.find('[data-dismiss="fileinput"]').on('click', function () {
            const parent = fileinput.closest('.form-group');
            const inputFlag = parent.find('input.remove-image-flag');
            inputFlag.val(1);
        });
    });

    // Nhân bản item
    $(document).on('click', '.btn-add', function () {
        const $group = $(this).closest('.dynamic-group');
        const containerSelector = $group.data('container');
        const itemSelector = $group.data('item');
        const $container = $(containerSelector);
        const $item = $container.find(itemSelector).first();

        $item.find('.error').remove();
        // Clone item đầu tiên và reset input
        const $clone = $item.clone();
        $clone.find('input').val('');
        $container.find('.btn-add').before($clone);
    });

    // Xóa item
    $(document).on('click', '.btn-remove', function () {
        const $group = $(this).closest('.dynamic-group');
        const containerSelector = $group.data('container');
        const itemSelector = $group.data('item');
        const $container = $(containerSelector);
        const itemsCount = $container.find(itemSelector).length;

        // Nếu còn hơn 1 thì cho phép xóa
        if (itemsCount > 1) {
            $(this).closest(itemSelector).remove();
        }
    });

    //Tìm kiếm bác sĩ
    $('.btn-search-doctor').on('click', function () {
        $('#ibox1').children('.ibox-content').addClass('sk-loading');
        let specialtyId = $('#specialty-id').val().trim();
        let doctorName = $('#doctor-name').val().trim();

        if($('#doctor-id')){
            $('#doctor-id').val('');
        }

        if($('#submit-form')){
            $('#submit-button').prop('disabled', true);
        }

        if (!specialtyId && !doctorName) {
            $('#ibox1').find('.ibox-content').removeClass('sk-loading');
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "progressBar": false,
                "preventDuplicates": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "10000",
                "timeOut": "1500",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr.warning("Vui lòng chọn chuyên khoa hoặc nhập tên bác sĩ.");
            return;
        }

        $.ajax({
            url: '/admin/api-get-doctors',
            type: 'GET',
            data: {
                specialty_id: specialtyId,
                name: doctorName
            },
            success: function (response) {
                if (response.status == 'success') {
                    // console.log(response)
                    let html = '';
                    response.doctors.forEach(function (doctor) {
                        html += `
                            <div class="item-doctor" data-doctor-id="${doctor.id}" data-doctor-name="${doctor.name}">
                                <img src="${doctor.avatar_url}" alt="Ảnh bác sĩ" class="avatar">
                                <div class="name">${doctor.name}</div>
                            </div>
                        `;
                    });
                    $('.list-doctor').html(html);
                } else {
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "progressBar": true,
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
                    };
                    toastr.warning(response.message);
                    $('.list-doctor').html('');
                }
            },
            error: function () {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "progressBar": true,
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
                };
                toastr.error("Đã xảy ra lỗi khi tải bác sĩ.");
            },
            complete: function () {
                $('#ibox1').find('.ibox-content').removeClass('sk-loading');
            }
        });
    });

    $(document).on('click', '.item-doctor', function () {
        $('.item-doctor').removeClass('selected');
        $(this).addClass('selected');
    });


    //Xử lý lịch hẹn
    let isManualIntervalChange = false;

    function generateTimeSlots(interval) {
        const start = 7 * 60;
        const end = 23 * 60;
        const slots = [];

        for (let time = start; time <= end; time += interval) {
            const hours = Math.floor(time / 60);
            const minutes = time % 60;
            const timeStr = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
            slots.push({
                timeStr,
                minutes: time
            });
        }

        return slots;
    }

    // function renderTimeSlots(interval = 30, checkedTimes = []) {
    //     const slots = generateTimeSlots(interval);
    //     const container = $('#time-slots');
    //     container.empty();

    //     slots.forEach(slot => {
    //         const isChecked = checkedTimes.includes(slot.timeStr) ? 'checked' : '';
    //         const checkbox = `
    //             <label class="timeline-item me-2 mb-2 d-inline-block">
    //                 <input type="checkbox" name="hour_examination[]" value="${slot.timeStr}" data-minutes="${slot.minutes}" ${isChecked}> ${slot.timeStr}
    //             </label>
    //         `;
    //         container.append(checkbox);
    //     });
    // }

    function renderTimeSlots(interval = 30, checkedData = []) {
        const slots = generateTimeSlots(interval);
        const container = $('#time-slots');
        container.empty();

        slots.forEach(slot => {
            const found = checkedData.find(item => item.time === slot.timeStr);
            const isChecked = found ? 'checked' : '';
            const hasAppointment = found && found.is_appointment ? 'have-appointment' : '';

            const checkbox = `
                <label class="timeline-item me-2 mb-2 d-inline-block ${hasAppointment}">
                    <input type="checkbox" name="hour_examination[]" value="${slot.timeStr}" data-minutes="${slot.minutes}" ${isChecked}> ${slot.timeStr}
                </label>
            `;
            container.append(checkbox);
        });
    }

    function handleTimeTypeSelection(radio) {
        const selected = radio.val();
        const alreadyChecked = radio.data('checked') || false;

        if (alreadyChecked) {
            $('input[name="type_time"]').prop('checked', false).data('checked', false);
            $('input[name="hour_examination[]"]').prop('checked', false);
            return;
        }

        $('input[name="type_time"]').data('checked', false);
        radio.data('checked', true);

        let start = 0, end = 0;
        switch (selected) {
            case 'all_day': start = 7 * 60; end = 23 * 60; break;
            case 'morning': start = 7 * 60; end = 12 * 60 + 59; break;
            case 'afternoon': start = 13 * 60; end = 17 * 60 + 59; break;
            case 'night': start = 18 * 60; end = 23 * 60; break;
            default: return;
        }

        $('input[name="hour_examination[]"]').each(function () {
            const time = parseInt($(this).data('minutes'));
            $(this).prop('checked', time >= start && time <= end);
        });
    }

    function loadAppointmentByDoctorAndDate() {
        const doctorId = $('#doctor-id').val();
        const dayExamination = $('#day-examination').val();
        const fallbackInterval = parseInt($('#time-interval').val()); // <-- fallback nếu không có API data

        if (!doctorId) {
            renderTimeSlots(fallbackInterval);
            return;
        }

        $.ajax({
            url: '/admin/api/check-doctor-appointments',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                doctor_id: doctorId,
                day_examination: dayExamination
            },
            success: function (response) {
                console.log(response)
                if (response.status === 'success') {
                    let interval = parseInt(response.data.type);
                    
                    if (isManualIntervalChange) {
                        interval = parseInt($('#time-interval').val()); // dùng giá trị người chọn
                        isManualIntervalChange = false; // reset lại flag
                    } else {
                        $('#time-interval').val(interval); // chỉ cập nhật khi load thường
                    }

                    const checkedTimes = response.data.hour_examinations || [];
                    renderTimeSlots(interval, checkedTimes);
                } else {
                    renderTimeSlots(fallbackInterval);
                }
            },
            error: function () {
                renderTimeSlots(fallbackInterval);
            }
        });
    }


    $(document).ready(function () {
        loadAppointmentByDoctorAndDate();
        
        $('#time-interval').on('change', function () {
            isManualIntervalChange = true;
            loadAppointmentByDoctorAndDate();
        });

        $('input[name="type_time"]').on('click', function () {
            handleTimeTypeSelection($(this));
        });

        $('#day-examination').on('change', function () {
            // console.log('api');
            loadAppointmentByDoctorAndDate();
        });
    });


    //Chọn bác sĩ tìm kiếm
    $(document).on('click', '.item-doctor', function () {
        const doctorId = $(this).data('doctor-id');
        const doctorName = $(this).data('doctor-name');

        // Cập nhật tiêu đề
        $('#selected-doctor-name').text(doctorName);

        // Cập nhật action form
        $('#appointment-form').attr('action', `/admin/appointment/store/${doctorId}`);

        // Nếu có input hidden doctor_id, cập nhật luôn
        if ($('#doctor-id').length) {
            $('#doctor-id').val(doctorId);
        } else {
            $('#appointment-form').append(`<input type="hidden" name="doctor_id" id="doctor-id" value="${doctorId}">`);
        }

        $('#submit-button').prop('disabled', false);

        // Gọi lại lịch hẹn theo bác sĩ đã chọn (nếu cần)
        loadAppointmentByDoctorAndDate();
    });

    $('#appointment-form').on('submit', function (e) {
        const doctorId = $('#doctor-id').val();
        if (!doctorId) {
            e.preventDefault();
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "progressBar": false,
                "preventDuplicates": false,
                "positionClass": "toast-top-center",
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "1000",
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "hide"
            }
            toastr.error('Vui lòng chọn bác sĩ trước khi thêm lịch khám.');
        }
    });
});

//CheckAll
document.addEventListener("DOMContentLoaded", function () {
    const checkAll = document.getElementById("check-all");
    const groupChecks = document.querySelectorAll(".group-check");
    const allPermissionChecks = document.querySelectorAll(".permission-checkbox");

    // Chọn tất cả
    if(checkAll) {
        checkAll.addEventListener("change", function () {
            const checked = this.checked;
            groupChecks.forEach(group => group.checked = checked);
            allPermissionChecks.forEach(item => item.checked = checked);
        });

        // Khi tick group cha
        groupChecks.forEach(groupCheckbox => {
            groupCheckbox.addEventListener("change", function () {
                const groupDiv = this.closest(".permission-group");
                const children = groupDiv.querySelectorAll(".permission-checkbox");
                children.forEach(child => child.checked = this.checked);

                updateCheckAll();
            });
        });
    }

    // Khi tick quyền con thì cập nhật group cha và check-all
    allPermissionChecks.forEach(childCheckbox => {
        childCheckbox.addEventListener("change", function () {
            const groupDiv = this.closest(".permission-group");
            const groupCheckbox = groupDiv.querySelector(".group-check");
            const children = groupDiv.querySelectorAll(".permission-checkbox");

            const allChecked = Array.from(children).every(child => child.checked);
            groupCheckbox.checked = allChecked;

            updateCheckAll();
        });
    });

    function updateCheckAll() {
        const allGroupsChecked = Array.from(groupChecks).every(group => group.checked);
        checkAll.checked = allGroupsChecked;
    }
});