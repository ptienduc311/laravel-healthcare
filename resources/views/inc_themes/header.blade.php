<div id="header">
    <div class="container">
        <div class="header-content">
            <div class="header-logo">
                <a href="/" title="Health Care">
                    <img src="{{asset('logo.png')}}" alt="Health Care">
                    {{-- <img src="https://medlatec.vn/media/115/content/logo-pc.png" alt="Health Care"> --}}
                </a>
            </div>
            <div class="header-search">
                <a href="#" class="search-close">
                    <i class="fa-solid fa-xmark"></i>
                </a>
                <div class="search-form">
                    <input type="text" id="keyword" class="form-control" placeholder="Tìm kiếm">
                    <button class="btn-search"></button>
                </div>
            </div>
            <div class="header-hotline">
                <a href="tel:0338237724">
                    <span>Đường dây nóng</span>
                    <strong>0338237724</strong>
                </a>
            </div>
            <div class="header-contact">
                <a href="https://www.facebook.com/BenhVienDaKhoaMedlatec/" target="_blank">
                    <span>Liên hệ</span>
                    <strong>Hỗ trợ khách hàng</strong>
                </a>
            </div>
            <div class="header-account">
                <div class="account-not-login">
                    <a href="#" class="action action-register">Đăng ký</a>
                    <a href="#" class="action action-login">Đăng nhập</a>
                </div>
            </div>
            <div class="d-flex">
                <a href="#" class="search-open icon-sm"></a>
                <a href="#" class="menu-open icon-sm"></a>
            </div>
        </div>

        <div class="header-nav">
            <div class="submenu-back">
                <i class="fa-solid fa-angle-left"></i>
                <span>Menu</span>
            </div>
            <a href="#" class="menu-close icon-sm"></a>
            <div class="header-account">
                <div class="account-not-login">
                    <a href="#" class="action action-register">Đăng ký</a>
                    <a href="#" class="action action-login">Đăng nhập</a>
                </div>
            </div>
            <ul class="main-menu">
                <li>
                    <a href="/">Trang chủ</a>
                </li>
                <li>
                    <a href="#">Giới thiệu</a>
                </li>
                <li class="has-submenu">
                    <a href="#">Dịch vụ y tế</a>
                    <i class="fa-solid fa-angle-down submenu-toggle"></i>
                    <ul class="sub-menu">
                        <strong class="menu-title">Dịch vụ y tế</strong>
                        <li>
                            <a href="" target="_blank">Dịch vụ bảo hiểm</a>
                        </li>
                        <li>
                            <a href="" target="_blank">Dịch vụ bảo hiểm</a>
                        </li>
                        <li>
                            <a href="" target="_blank">Dịch vụ bảo hiểm</a>
                        </li>
                        <li>
                            <a href="" target="_blank">Dịch vụ bảo hiểm</a>
                        </li>
                        <li>
                            <a href="" target="_blank">Dịch vụ bảo hiểm</a>
                        </li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="/">Chuyên gia</a>
                    <i class="fa-solid fa-angle-down submenu-toggle"></i>
                    <ul class="sub-menu">
                        <strong class="menu-title">Chuyên gia</strong>
                        <li>
                            <a href="" target="_blank">Dịch vụ bảo hiểm</a>
                        </li>
                        <li>
                            <a href="" target="_blank">Dịch vụ bảo hiểm</a>
                        </li>
                        <li>
                            <a href="" target="_blank">Dịch vụ bảo hiểm</a>
                        </li>
                        <li>
                            <a href="" target="_blank">Dịch vụ bảo hiểm</a>
                        </li>
                        <li>
                            <a href="" target="_blank">Dịch vụ bảo hiểm</a>
                        </li>
                    </ul>
                </li>
                <li class="has-submenu">
                    <a href="#">Tin tức</a>
                    <i class="fa-solid fa-angle-down submenu-toggle"></i>
                    <ul class="sub-menu">
                        <strong class="menu-title">Tin tức</strong>
                        <li>
                            <a href="/tin-tuc-tong-hop">Tin tức tổng hợp</a>
                        </li>
                        @foreach ($menu_post_categories as $item)
                            <li>
                                <a href="">{{ $item->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <div class="header-nav-bottom">
                <div class="header-hotline">
                    <a href="tel:0338237724">
                        <span>Đường dây nóng</span>
                        <strong>0338237724</strong>
                    </a>
                </div>
                <div class="header-contact">
                    <a href="https://www.facebook.com/BenhVienDaKhoaMedlatec/" target="_blank">
                        <span>Liên hệ</span>
                        <strong>Hỗ trợ khách hàng</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>