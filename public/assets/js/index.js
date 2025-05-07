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

var swiper4 = new Swiper(".specialty-items", {
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
    
        let listProvince = []; // Danh sách tỉnh/thành phố
        let listDistricts = []; // Danh sách quận/huyện
        let listWards = []; // Danh sách phường/xã
    
        districtSelect.disabled = true;
        wardSelect.disabled = true;
    
        const errorApi = document.createElement("p");
        errorApi.style.color = "red";
        errorApi.textContent = "Không thể tải danh sách tỉnh/thành phố.";
        errorApi.style.display = "none";
        provinceList.parentNode.insertBefore(errorApi, provinceList.nextSibling);
    
        // Lấy danh sách tỉnh/thành phố
        fetch("https://open.oapi.vn/location/provinces?page=0&size=64")
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
            }
        });
    
        // Tải danh sách quận/huyện
        function loadDistricts(provinceId) {
            districtSelect.innerHTML = "<option value=''>Chọn Quận/Huyện</option>";
            districtSelect.disabled = true;
    
            fetch(`https://open.oapi.vn/location/districts/${provinceId}?page=0&size=30`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.data) {
                        listDistricts = data.data;
                        listDistricts.forEach(district => {
                            const option = document.createElement("option");
                            option.value = district.id;
                            option.textContent = district.name;
                            districtSelect.appendChild(option);
                        });
                        districtSelect.disabled = false;
                    }
                });
        }
    
        // Chọn quận/huyện
        districtSelect.addEventListener("change", function () {
            const districtId = this.value;
            if (districtId) {
                loadWards(districtId);
            }
        });
    
        // Tải danh sách phường/xã
        function loadWards(districtId) {
            wardSelect.innerHTML = "<option value=''>Chọn Phường/Xã</option>";
            wardSelect.disabled = true;
    
            fetch(`https://open.oapi.vn/location/wards/${districtId}?page=0&size=30`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.data) {
                        listWards = data.data;
                        listWards.forEach(ward => {
                            const option = document.createElement("option");
                            option.value = ward.id;
                            option.textContent = ward.name;
                            wardSelect.appendChild(option);
                        });
                        wardSelect.disabled = false;
                    }
                });
        }
    
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

//Swipper
document.addEventListener("DOMContentLoaded", function () {
    const timeMeetWrapper = document.querySelector(".swiperTimeMeet .swiper-wrapper");
    if(timeMeetWrapper){
        // Tạo danh sách thời gian từ 6h00 đến 23h30
        function generateTimeSlots() {
            let times = [];
            for (let h = 6; h <= 23; h++) {
                times.push({ value: h, label: `${h.toString().padStart(2, "0")}h00` });
                if (h < 23) {
                    times.push({ value: h + 0.5, label: `${h.toString().padStart(2, "0")}h30` });
                }
            }
            return times;
        }

        // Lấy index mốc thời gian gần nhất với thời gian hiện tại
        function getNearestTimeSlotIndex(timeSlots) {
            const now = new Date();
            let currentHour = now.getHours();
            let currentMinute = now.getMinutes();
            let currentValue = currentHour + (currentMinute >= 30 ? 0.5 : 0);

            for (let i = 0; i < timeSlots.length; i++) {
                if (timeSlots[i].value >= currentValue) {
                    return i;
                }
            }
            return 0;
        }

        // Đổ dữ liệu vào Swiper
        const timeSlots = generateTimeSlots();
        timeMeetWrapper.innerHTML = "";

        timeSlots.forEach((time) => {
            let slide = document.createElement("div");
            slide.classList.add("swiper-slide");

            slide.innerHTML = `
                <label class="label-time-meet">
                    <input type="radio" name="time-meet" class="time-meet" value="${time.value}">
                    <span>${time.label}</span>
                </label>
            `;

            timeMeetWrapper.appendChild(slide);
        });

        const startIndex = getNearestTimeSlotIndex(timeSlots);

        // Khởi tạo Swiper
        let swiper5 = new Swiper(".swiperTimeMeet", {
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            slidesPerView: 1,
            spaceBetween: 10,
            initialSlide: Math.max(startIndex - 1, 0),
            breakpoints: {
                450: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },  
                660: {
                    slidesPerView: 3,
                    spaceBetween: 20
                },
                800: {
                slidesPerView: 4,
                spaceBetween: 30
                },
                980: {
                slidesPerView: 5,
                spaceBetween: 30
                }
            },
            on: {
                init: function () {
                    updatePrevButtonState(this);
                },
                slideChange: function () {
                    if (this.activeIndex < startIndex) {
                        this.slideTo(startIndex, 200);
                    }
                    updatePrevButtonState(this);
                },
                reachBeginning: function () {
                    updatePrevButtonState(this);
                }
            }
        });

        // Cập nhật trạng thái của nút prev
        function updatePrevButtonState(swiper) {
            const prevButton = document.querySelector(".swiper-button-prev");
            if (swiper.activeIndex === startIndex) {
                prevButton.classList.add("swiper-button-disabled");
            } else {
                prevButton.classList.remove("swiper-button-disabled");
            }
        }

        // Đánh dấu radio có mốc gần nhất
        document.querySelectorAll(".time-meet")[startIndex].checked = true;
    }
});
