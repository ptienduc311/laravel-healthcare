<div id="footer">
    <div class="container">
        <div class="header-footer">
            <a href="/" class="footer-logo row">
                <div class="img col-md-3">
                    <img src="{{ asset('assets/images/logo-big.png') }}" alt="Logo Health Care">
                </div>
                <div class="slogan col-md-9">
                    <p class="first"><span>HealthCare</span> - Sức khỏe của bạn, ưu tiên của chúng tôi</p>
                    <p class="second">Đặt niềm tin - Nhận chăm sóc tận tâm</p>
                </div>
            </a>
        </div>
        <div class="body-footer row">
            <div class="col-md-4">
                <h2 class="title">Liên hệ</h2>
                <ul class="info-contact">
                    <li>
                        <i class="fa-solid fa-location-dot"></i>
                        <span>{{ $site->address ?? 'Đang cập nhật' }}</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-phone"></i>
                        <span>{{ collect([$site?->phone, $site?->hotline])->filter()->implode(' - '); }}</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope"></i>
                        <span>{{ $site->email ?? 'Đang cập nhật' }}</span>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <h2 class="title">Danh mục</h2>
                <ul class="post-category">
                    <li>
                        <a href="/tin-tuc-tong-hop">Tin tức tổng hợp</a>
                    </li>
                    @foreach ($menu_post_categories as $item)
                        <li>
                            <a href="/{{ $item->slug }}">{{ $item->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-4">
                <h2 class="title">Liên kết</h2>
                <ul class="link">
                    <li>
                        <a href="{{ $site->link_facebook ? $site->link_facebook : '/' }}">
                            <img src="{{ asset('assets/images/facebook.svg') }}" alt="">
                        </a>
                    </li>
                    <li>
                        <a href="{{ $site->link_youtube ? $site->link_youtube : '/' }}">
                            <img src="{{ asset('assets/images/youtube.svg') }}" alt="">
                        </a>
                    </li>
                    <li>
                        <a href="{{ $site->link_zalo ? $site->link_zalo : '/' }}">
                            <img src="{{ asset('assets/images/zalo.svg') }}" alt="">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="end-footer">
            <div class="copyright">
                Copyright 2025 © Phòng khám HealthCare
            </div>
        </div>
    </div>
</div>