// Search mobile
const search_open = document.querySelector(".search-open");
const search_close = document.querySelector(".search-close");

const header_search = document.querySelector(".header-search");
const header_logo = document.querySelector(".header-logo");
const header_nav = document.querySelector(".header-nav");
const menu_open = document.querySelector(".menu-open");
const main_content = document.querySelector("#main-content");
const overlay = document.getElementById("overlay");

const has_submenu = document.querySelectorAll(".has-submenu");
const submenu_back = document.querySelector(".submenu-back");

const menu_close = document.querySelector(".menu-close");
const isMobile = () => window.matchMedia("(max-width: 800px)").matches;

search_open.addEventListener("click", () => {
    header_search.classList.add("active");
    header_logo.style.display = "none";
    search_open.style.display = "none";
    menu_open.style.display = "none";
})

search_close.addEventListener("click", () => {
    header_search.classList.remove("active");
    header_logo.style.display = "block";
    search_open.style.display = "block";
    menu_open.style.display = "block";
})

menu_open.addEventListener("click", () => {
    header_nav.classList.add("active");
    main_content.style.filter = "blur(2px)"
    overlay.style.display = "block";
})

has_submenu.forEach((toggle) => {
    toggle.addEventListener("click", function () {
        toggle.classList.toggle("open");
        submenu_back.classList.add("active");

        const icon = toggle.querySelector(".fa-solid");
        if (icon && isMobile()) {
            icon.style.transform = toggle.classList.contains("open") ? "rotate(90deg)" : "rotate(0deg)";
        }
    });
});

submenu_back.addEventListener("click", () => {
    submenu_back.classList.remove("active");
    has_submenu.forEach((toggle) => {
        toggle.classList.remove("open");
        const icon = toggle.querySelector(".fa-solid");
        if (icon && isMobile()) {
            icon.style.transform = "rotate(0deg)";
        }
    });
});

menu_close.addEventListener("click", () => {
    header_nav.classList.remove ("active");
    main_content.style.filter = "none";
    overlay.style.display = "none";
})

//Swipper
const swiper = new Swiper('.swiperSlider', {
    direction: 'horizontal',
    loop: true, 
    autoplay: {
        delay: 5000,
    },

    pagination: {
        el: '.swiper-pagination',
        clickable: true
    },

    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

var swiper2 = new Swiper(".swiperPost", {
    watchSlidesProgress: true,
    loop: true,
    slidesPerView: 1,
    spaceBetween: 10,
    breakpoints: {
        768: {
            slidesPerView: 2,
            spaceBetween: 20
        },
        1024: {
          slidesPerView: 4,
          spaceBetween: 30
        }
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
});

var swiper3 = new Swiper(".slideDoctor", {
    watchSlidesProgress: true,
    slidesPerView: 1,
    spaceBetween: 10,
    loop: true,
    breakpoints: {
        768: {
            slidesPerView: 2,
            spaceBetween: 20
        },
        1024: {
          slidesPerView: 4,
          spaceBetween: 30
        }
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
});

var swiper4 = new Swiper(".slideDoctorSpecial", {
    watchSlidesProgress: true,
    slidesPerView: 1,
    spaceBetween: 10,
    loop: true,
    breakpoints: {
        768: {
            slidesPerView: 2,
            spaceBetween: 20
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 30
        }
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
});

//Teams Filter
document.querySelectorAll(".type-filter[data-type]").forEach(typeFilter => {
    const typeKey = typeFilter.getAttribute("data-type");
    const selectBtn = typeFilter.querySelector(".select-btn");
    const optionsWrapper = typeFilter.querySelector(".options");
    const searchInp = typeFilter.querySelector(".search-input");
    const listItems = Array.from(optionsWrapper.querySelectorAll("li"));

    const originalData = listItems.map(item => ({
        id: item.getAttribute("data-id"),
        name: item.textContent.trim()
    }));

    const hiddenInput = document.getElementById(typeKey);

    function renderOptions(data, selectedId = null) {
        optionsWrapper.innerHTML = data.map(item => 
            `<li data-id="${item.id}" class="${item.id === selectedId ? 'selected' : ''}">${item.name}</li>`
        ).join('');
    }

    if (selectBtn) {
        selectBtn.addEventListener("click", (event) => {
            document.querySelectorAll(".type-filter").forEach(tf => {
                if (tf !== typeFilter) tf.classList.remove("active");
            });
            typeFilter.classList.toggle("active");
            event.stopPropagation();
        });
    }

    // Click chọn item
    if (optionsWrapper) {
        optionsWrapper.addEventListener("click", (event) => {
            if (event.target.tagName === "LI") {
                const selectedText = event.target.innerText;
                const selectedId = event.target.getAttribute("data-id");

                selectBtn.querySelector("span").innerText = selectedText;

                if (hiddenInput) {
                    hiddenInput.value = selectedId;
                }

                typeFilter.classList.remove("active");
                searchInp.value = "";

                renderOptions(originalData, selectedId);
            }
        });
    }

    // Tìm kiếm
    if (searchInp) {
        searchInp.addEventListener("keyup", () => {
            const searchVal = searchInp.value.toLowerCase();
            const filtered = originalData.filter(item =>
                item.name.toLowerCase().includes(searchVal)
            );
            if (filtered.length) {
                renderOptions(filtered, hiddenInput?.value);
            } else {
                optionsWrapper.innerHTML = `<p>Không tìm thấy!</p>`;
            }
        });
    }
});

const buttonFilter = document.querySelector(".teams-filter-collapse")
const teamFilterContent = document.querySelector(".teams-filter-content")
if(buttonFilter){
    buttonFilter.addEventListener("click", () => {
        if (buttonFilter.classList.contains("collapsed")) {
            buttonFilter.classList.remove("collapsed");
        } else {
            buttonFilter.classList.add("collapsed");
        }
        teamFilterContent.classList.toggle("active");
    })
}

//Tỉnh/Thành phố, Quận/Huyện, Xã/Phường(https://oapi.vn/api-tinh-thanh-viet-nam)
document.addEventListener("DOMContentLoaded", function () {
    const filterProvince = document.querySelector(".filter-province");
    if(filterProvince){
        const selectBtn = filterProvince.querySelector(".select-btn");
        const options = filterProvince.querySelector(".options");
        const searchInp = filterProvince.querySelector(".search-input");
        const provinceList = document.getElementById("province");
        const districtSelect = document.getElementById("district");
        const wardSelect = document.getElementById("ward");
    
        let listProvince = [];
        let listDistricts = [];
        let listWards = [];
    
        districtSelect.disabled = true;
        wardSelect.disabled = true;
    
        const errorApi = document.createElement("p");
        errorApi.style.color = "red";
        errorApi.textContent = "Không thể tải danh sách tỉnh/thành phố.";
        errorApi.style.display = "none";
        provinceList.parentNode.insertBefore(errorApi, provinceList.nextSibling);
    
        // Lấy danh sách tỉnh/thành phố
        fetch("/api-get-provinces")
            .then(response => response.json())
            .then(data => {
                if (data && data.data) {
                    provinceList.innerHTML = "";
                    listProvince = data.data.map(province => {
                        return { name: province.name, id: province.id };
                    });
                    listProvince.forEach(province => {
                        const listItem = document.createElement("li");
                        listItem.textContent = province.name;
                        listItem.dataset.id = province.id;
                        provinceList.appendChild(listItem);
                    });
                    setupSearchEvent();

                    const savedProvinceId = document.getElementById("province-id").value;
                    if (savedProvinceId) {
                        const selectedProvince = listProvince.find(p => p.id == savedProvinceId);
                        if (selectedProvince) {
                            selectBtn.firstElementChild.innerText = selectedProvince.name;
                            selectBtn.firstElementChild.style.color = "#000";
                            selectBtn.firstElementChild.style.opacity = "1";
                            selectBtn.firstElementChild.style.fontWeight  = "normal";

                            // Load quận/huyện
                            loadDistricts(savedProvinceId, () => {
                                const savedDistrictId = document.getElementById("district-id").value;
                                if (savedDistrictId) {
                                    districtSelect.value = savedDistrictId;
                                    loadWards(savedDistrictId, () => {
                                        const savedWardId = document.getElementById("ward-id").value;
                                        if (savedWardId) {
                                            wardSelect.value = savedWardId;
                                        }
                                    });
                                }
                            });
                        }
                    }

                }
            })
            .catch(error => {
                errorApi.style.display = "block";
            });
    
        if(selectBtn){
            selectBtn.addEventListener("click", (event) => {
                document.querySelectorAll(".type-filter").forEach(tf => {
                    if (tf !== filterProvince) tf.classList.remove("active");
                });
    
                filterProvince.classList.toggle("active");
                event.stopPropagation();
            });
        }
    
        // Chọn tỉnh/thành phố
        options.addEventListener("click", (event) => {
            if (event.target.tagName === "LI") {
                const selectedText = event.target.innerText;
                const selectedId = event.target.dataset.id;
    
                selectBtn.firstElementChild.innerText = selectedText;
                selectBtn.firstElementChild.style.color = "#000";
                selectBtn.firstElementChild.style.opacity = "1";
                selectBtn.firstElementChild.style.fontWeight  = "normal";
    
                filterProvince.classList.remove("active");
                searchInp.value = "";
    
                districtSelect.innerHTML = "<option value=''>Chọn Quận/Huyện</option>";
                wardSelect.innerHTML = "<option value=''></option>";
                wardSelect.disabled = true;
    
                loadDistricts(selectedId);
                document.getElementById("province-id").value = selectedId;
                document.getElementById("district-id").value = '';
                document.getElementById("ward-id").value = '';
            }
        });
    
        // Tải danh sách quận/huyện
        function loadDistricts(provinceId, callback = null) {
            districtSelect.innerHTML = "<option value=''>Chọn Quận/Huyện</option>";
            districtSelect.disabled = true;

            fetch(`/api-get-districts?province_id=${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        listDistricts = data.data;
                        listDistricts.forEach(district => {
                            const option = document.createElement("option");
                            option.value = district.id;
                            option.textContent = district.name;
                            districtSelect.appendChild(option);
                        });
                        districtSelect.disabled = false;
                        if (callback) callback();
                    } else {
                        alert(data.message || 'Không thể tải danh sách quận/huyện.');
                    }
                })
                .catch(() => {
                    alert('Lỗi khi lấy dữ liệu quận/huyện.');
                });
        } 
    
        // Chọn quận/huyện
        districtSelect.addEventListener("change", function () {
            const districtId = this.value;
            document.getElementById("district-id").value = districtId;
            document.getElementById("ward-id").value = '';
            if (districtId) {
                loadWards(districtId);
            }
        });
    
        // Tải danh sách phường/xã
        function loadWards(districtId, callback = null) {
            wardSelect.innerHTML = "<option value=''>Chọn Phường/Xã</option>";
            wardSelect.disabled = true;

            fetch(`/api-get-wards?district_id=${districtId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        listWards = data.data;
                        listWards.forEach(ward => {
                            const option = document.createElement("option");
                            option.value = ward.id;
                            option.textContent = ward.name;
                            wardSelect.appendChild(option);
                        });
                        wardSelect.disabled = false;
                        if (callback) callback();
                    } else {
                        alert(data.message || 'Không thể tải danh sách phường/xã.');
                    }
                })
                .catch(() => {
                    alert('Lỗi khi lấy dữ liệu phường/xã.');
                });
        }
        
        wardSelect.addEventListener("change", function () {
            const wardId = this.value;
            document.getElementById("ward-id").value = wardId;
        });
    
        // Xử lý tìm kiếm tỉnh/thành phố
        function setupSearchEvent() {
            searchInp.addEventListener("keyup", () => {
                let searchVal = searchInp.value.toLowerCase();
                let filtered = listProvince.filter(data => 
                    data.name.toLowerCase().startsWith(searchVal)
                ).map(data => `<li data-id="${data.id}">${data.name}</li>`).join("");
    
                options.innerHTML = filtered ? filtered : `<p style="color:red;">Không tìm thấy!</p>`;
            });
        }
    }
});

//Tải giờ khám khi đặt lịch hẹn
document.addEventListener("DOMContentLoaded", function () {
    const dateInput = document.getElementById("appointmentDate");
    const doctorInput = document.getElementById("doctor-id");
    const timeSlotList = document.getElementById("time-slot-list");

    if(dateInput){
        dateInput.addEventListener("change", function () {
            const date = dateInput.value;
            if (!date) return;

            const doctorId = doctorInput.value;

            timeSlotList.innerHTML = `<div class="loading">Đang tải giờ khám...</div>`;

            fetch(`/api-get-available-times?doctor_id=${doctorId}&date=${date}`)
            .then(res => res.json())
            .then(data => {
                // console.log(data);
                const listTimes = document.querySelector(".list-times");
                listTimes.innerHTML = "";

                if (data.status == 'error') {
                    listTimes.innerHTML = `<div class="error-message">${data.message}</div>`;
                    return;
                }

                const hours = data.data;
                if (!hours.length) {
                    listTimes.innerHTML = `<div class="error-message">Không có giờ khám nào cho ngày này.</div>`;
                    return;
                }

                hours.forEach(item => {
                    const disabled = item.is_appointment == 1 ? 'disabled' : '';
                    const labelClass = item.is_appointment == 1 ? 'disabled-label' : '';

                    const label = document.createElement("label");
                    label.className = `label-time-meet ${labelClass}`;
                    label.innerHTML = `
                        <input type="radio" name="appointment_id" class="time-meet" value="${item.id}" ${disabled}>
                        <span>${item.hour_examination}</span>
                    `;
                    listTimes.appendChild(label);
                });
            });
        });
    }
});

//Validate đặt lịch hẹn
document.addEventListener('DOMContentLoaded', function () {
    const formBook = document.querySelector('#form-book');

    function showError(id, message) {
        const errorDiv = document.getElementById(id + '-error');
        if (errorDiv) {
            errorDiv.textContent = message;
        }
    }

    function clearError(id) {
        const errorDiv = document.getElementById(id + '-error');
        if (errorDiv) {
            errorDiv.textContent = '';
        }
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function isValidPhone(phone) {
        return /^[0-9]{9,11}$/.test(phone);
    }

    function getInputValue(id) {
        return document.getElementById(id)?.value?.trim();
    }

    function addInputEventListener(id, validateFunc) {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', () => {
                validateFunc();
            });
        }
    }

    if(formBook) {
        formBook.addEventListener('submit', function (e) {
            let isValid = true;

            const name = getInputValue('patientName');
            if (!name) {
                showError('patientName', 'Vui lòng nhập họ tên');
                isValid = false;
            } else {
                clearError('patientName');
            }

            const phone = getInputValue('phone');
            if (!phone) {
                showError('phone', 'Vui lòng nhập số điện thoại');
                isValid = false;
            } else if (!isValidPhone(phone)) {
                showError('phone', 'Số điện thoại không hợp lệ');
                isValid = false;
            } else {
                clearError('phone');
            }

            const birth = getInputValue('patientBirthDate');
            if (!birth) {
                showError('patientBirthDate', 'Vui lòng chọn ngày sinh');
                isValid = false;
            } else {
                clearError('patientBirthDate');
            }

            const email = getInputValue('email');
            if (!email) {
                showError('email', 'Vui lòng nhập email');
                isValid = false;
            } else if (!isValidEmail(email)) {
                showError('email', 'Email không hợp lệ');
                isValid = false;
            } else {
                clearError('email');
            }

            const sex = document.getElementById('patientSex').value;
            if (!sex || sex === 'Chọn giới tính') {
                showError('patientSex', 'Vui lòng chọn giới tính');
                isValid = false;
            } else {
                clearError('patientSex');
            }

            const provinceId = document.getElementById('province-id').value;
            if (!provinceId) {
                showError('province', 'Vui lòng chọn tỉnh/thành');
                isValid = false;
            } else {
                clearError('province');
            }

            const districtId = document.getElementById('district-id').value;
            if (!districtId) {
                showError('district', 'Vui lòng chọn quận/huyện');
                isValid = false;
            } else {
                clearError('district');
            }

            const wardId = document.getElementById('ward-id').value;
            if (!wardId) {
                showError('ward', 'Vui lòng chọn phường/xã');
                isValid = false;
            } else {
                clearError('ward');
            }

            const requireSpecialty = formBook?.dataset.requireSpecialty === '1';
            const specialty = getInputValue('specialty-id');
            if (requireSpecialty && !specialty) {
                showError('specialty-id', 'Vui lòng chọn chuyên khoa');
                isValid = false;
            } else {
                clearError('specialty-id');
            }

            const doctor = getInputValue('doctor-id');
            if (!doctor) {
                showError('doctor-id', 'Vui lòng chọn bác sĩ');
                isValid = false;
            } else {
                clearError('doctor-id');
            }

            const address = getInputValue('address');
            if (!address) {
                showError('address', 'Vui lòng nhập địa chỉ');
                isValid = false;
            } else {
                clearError('address');
            }

            const appointmentDate = getInputValue('appointmentDate');
            if (!appointmentDate) {
                showError('appointmentDate', 'Vui lòng chọn ngày khám');
                isValid = false;
            } else {
                clearError('appointmentDate');
            }

            const note = getInputValue('reasonNote');
            if (!note) {
                showError('reasonNote', 'Vui lòng nhập nội dung yêu cầu');
                isValid = false;
            } else {
                clearError('reasonNote');
            }

            const selectedTime = document.querySelector('input[name="appointment_id"]:checked');
            const timeSlotList = document.getElementById("time-slot-list");
            const existingTimeError = timeSlotList.querySelector('.time-error');
        
            if (existingTimeError) existingTimeError.remove();
        
            if (!selectedTime) {
                showError('time', 'Vui lòng chọn giờ khám');
                isValid = false;
            }
            else{
                clearError('time');
            }

            if (!isValid) {
                e.preventDefault();

                const btn = document.querySelector('.ladda-button');
                if (btn) {
                    const ladda = Ladda.create(btn);
                    ladda.stop();
                    btn.querySelector('.ladda-label').textContent = 'Đặt lịch';
                }

                return;
            }

            const btn = document.querySelector('.ladda-button');
            if (btn) {
                const ladda = Ladda.create(btn);
                btn.querySelector('.ladda-label').textContent = 'Đang đặt lịch hẹn';
                ladda.start();
            }
        });
    }

    const fieldsToWatch = [
        'patientName', 'phone', 'patientBirthDate', 'email', 'patientSex',
        'address', 'specialty-id', 'doctor-id', 'appointmentDate', 'reasonNote'
    ];

    fieldsToWatch.forEach(id => {
        addInputEventListener(id, () => clearError(id));
    });
    ['province-id', 'district-id', 'ward-id'].forEach((id, index) => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('change', () => {
                const errorField = ['province', 'district', 'ward'][index];
                clearError(errorField);
            });
        }
    });
});

//Tìm kiếm
document.getElementById('btn_search').addEventListener('click', function (e) {
    var keyword = document.getElementById('keyword').value;
    if (keyword !== "") {
        var url = "/tim-kiem-bai-viet?keyword=" + encodeURIComponent(keyword);
        window.location.href = url;
    }
});

//Load more data tìm kiếm
$(document).ready(function () {
    $('#load-more-data').on('click', function () {
        var $btn = $(this);
        var offset = parseInt($btn.data('offset'));
        var limit = parseInt($btn.data('limit'));
        var type = $btn.data('type');
        var keyword = $btn.data('keyword');

        $btn.prop('disabled', true);
        $btn.html(`<i class="fa-solid fa-spinner fa-spin"></i> Đang tải...`);

        $.ajax({
            url: '/load-more-data',
            type: 'GET',
            data: {
                keyword: keyword,
                offset: offset,
                type: type,
                limit: limit
            },
            success: function (response) {
                console.log(response);
                if(response.status == 'success'){
                    $('#show-more-data').append(response.html);

                    if (response.has_more) {
                        $btn.data('offset', offset + limit);
                        $btn.prop('disabled', false);
                        $btn.html('Xem thêm');
                    } else {
                        $btn.remove();
                    }
                }else{
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "progressBar": false,
                        "preventDuplicates": false,
                        "positionClass": "toast-top-center",
                        "onclick": null,
                        "showDuration": "400",
                        "hideDuration": "10000",
                        "timeOut": "4000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                    toastr.error(response.message);
                    $btn.prop('disabled', false);
                    $btn.html('Xem thêm');
                }
            },
            error: function () {
                $btn.html('Lỗi tải dữ liệu');
            }
        });
    });
});

//Back to Top
const backToTop = document.getElementById('backToTop');
window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
        backToTop.classList.add('show');
    } else {
        backToTop.classList.remove('show');
    }
});

backToTop.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

$(document).on('click', function (e) {
    const target = $(e.target);
    const hasDoctorGroup = target.closest('.group-doctor').length > 0;
    const hasFilterProvince = target.closest('.filter-province').length > 0;

    if (!hasDoctorGroup) {
        $('.show-list-doctor').hide();
    }

    if(!hasFilterProvince){
        $('.filter-province').removeClass('active');
    }
});

//Danh sách trạng thái lịch hẹn
const statusMap = {
    1: { label: 'Chưa xác nhận', color: 'secondary' },
    2: { label: 'Đã xác nhận', color: 'primary' },
    3: { label: 'Đã hủy', color: 'danger' },
    4: { label: 'Đang khám', color: 'warning' },
    5: { label: 'Chờ kết quả', color: 'info' },
    6: { label: 'Đã có kết quả', color: 'success' }
};

//Hủy lịch hẹn
$(document).on('click', '.cancel-booking', function () {
    var $btn = $(this); 
    var bookingId = $(this).data('book-id');
    var bookingCode = $(this).data('book-code');

    swal({
        title: "Bạn chắc chắn muốn hủy?",
        text: "Lịch hẹn này sẽ không thể khôi phục!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Đồng ý, hủy lịch!",
        cancelButtonText: "Không",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (isConfirm) {
            $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Đang xử lý ...');
            swal.close();

            $.ajax({
                url: '/api-cancel-book',
                type: 'POST',
                data: {
                    bookingId: bookingId,
                    bookingCode: bookingCode
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    const status = statusMap[response.status];
                    if (response.status !== undefined) {
                        $(`.status-apm-${bookingId}`).removeClass().addClass(`badge bg-${status.color} status-apm-${bookingId}`).text(status.label);
                    }
                    else{
                        $(`.status-apm-${bookingId}`).removeClass().addClass(`badge bg-dark`).text('Không rõ');
                    }

                    $btn.remove();
                    if (response.type === 'success') {
                        swal("Đã hủy!", response.message, "success");
                    } else {
                        swal("Thông báo!", response.message, "warning");
                    }
                },
                error: function () {
                    swal("Lỗi!", "Đã xảy ra lỗi khi gửi yêu cầu.", "error");
                    $btn.prop('disabled', false).html('Hủy lịch hẹn');
                }
            });
        }
    });
});
