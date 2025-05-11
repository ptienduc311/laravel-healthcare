<div id="header">
    <div class="container">
        <div class="header-content">
            <div class="header-logo">
                <a href="/" title="Health Care">
                    <img src="{{asset('assets/images/logo.png')}}" alt="HealthCare">
                </a>
            </div>
            <div class="header-search">
                <a href="#" class="search-close">
                    <i class="fa-solid fa-xmark"></i>
                </a>
                <div class="search-form">
                    <input type="text" id="keyword" class="form-control" value="{{ request('keyword') }}" placeholder="Tìm kiếm">
                    <button class="btn-search" id="btn_search"></button>
                </div>
            </div>
            <div class="header-hotline">
                <a href="tel:{{ $site->hotline }}">
                    <span>Đường dây nóng</span>
                    <strong>{{ $site->hotline }}</strong>
                </a>
            </div>
            <div class="header-contact">
                <a href="{{ $site->link_facebook ? $site->link_facebook : '/' }}" target="_blank">
                    <span>Liên hệ</span>
                    <strong>Hỗ trợ khách hàng</strong>
                </a>
            </div>
            <div class="header-account">
                <div class="account-not-login">
                    <a href="/register" class="action action-register">Đăng ký</a>
                    <a href="/login" class="action action-login">Đăng nhập</a>
                </div>
            </div>
            <div class="d-flex">
                <a class="search-open icon-sm"></a>
                <a class="menu-open icon-sm"></a>
            </div>
        </div>

        <div class="header-nav">
            <div class="submenu-back">
                <i class="fa-solid fa-angle-left"></i>
                <span>Menu</span>
            </div>
            <a class="menu-close icon-sm"></a>
            <div class="header-account">
                <div class="account-not-login">
                    <a href="/register" class="action action-register">Đăng ký</a>
                    <a href="/login" class="action action-login">Đăng nhập</a>
                </div>
            </div>
            <ul class="main-menu">
                <li>
                    <a href="/">Trang chủ</a>
                </li>
                <li>
                    <a href="/gioi-thieu">Giới thiệu</a>
                </li>
                <li>
                    <a href="/chuyen-khoa">Chuyên khoa</a>
                </li>
                <li>
                    <a href="/doi-ngu-chuyen-gia">Đội ngũ chuyên gia</a>
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
                                <a href="/{{ $item->slug }}">{{ $item->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li>
                    <a href="/dat-lich-kham">Đặt lịch khám</a>
                </li>
                <li>
                    <a href="/tra-cuu-lich-hen">Tra cứu lịch hẹn</a>
                </li>
                {{-- <li class="has-submenu">
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
                </li> --}}
            </ul>
            <div class="header-nav-bottom">
                <div class="header-hotline">
                    <a href="tel:{{ $site->hotline }}">
                        <span>Đường dây nóng</span>
                        <strong>{{ $site->hotline }}</strong>
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