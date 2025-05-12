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
                    let html = '';
                    response.doctors.forEach(function (doctor) {
                        html += `
                            <div class="item-doctor" data-doctor-id="${doctor.id}">
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