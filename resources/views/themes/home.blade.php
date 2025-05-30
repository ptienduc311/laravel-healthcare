@extends('layouts.app')

@section('title', 'HealthCare')

@section('content')
<div id="main-content">
    <div class="container">
        <div class="swiper swiperSlider">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="{{asset('assets/images/slider1.png')}} " />
                </div>
                <div class="swiper-slide">
                    <img src="{{asset('assets/images/slider2.png')}} " />
                </div>
                <div class="swiper-slide">
                    <img src="{{asset('assets/images/slider3.png')}} " />
                </div>
                <div class="swiper-slide">
                    <img src="{{asset('assets/images/slider4.jpg')}} " />
                </div>
            </div>
            <div class="swiper-pagination"></div>

            <div class="swiper-button-prev slick-arrow">
                <i class="fa-solid fa-angle-left"></i>
            </div>
            <div class="swiper-button-next slick-arrow">
                <i class="fa-solid fa-angle-right"></i>
            </div>
        </div>

        <div class="media-news">
            <div class="media-title">
                <h2>Tin tức y khoa</h2>
            </div>
                <div class="swiper swiperPost">
                    <div class="swiper-wrapper list-posts">
                        @foreach ($posts as $item)
                            <div class="swiper-slide post-item">
                                <div class="post-item-photo">
                                    <a href="/tin-tuc/{{ $item->slug }}-{{ $item->id }}" class="post-image-container">
                                        <img src="{{ Storage::url($item->image?->src) }}" alt="Ảnh {{$item->title}}">
                                    </a>
                                </div>
                                <div class="post-detail">
                                    <div class="post-title">
                                        <a href="/tin-tuc/{{ $item->slug }}-{{ $item->id }}">
                                            {{ $item->title }}
                                        </a>
                                    </div>
                                    <div class="post-description">
                                        {{ $item->description }}
                                    </div>
                                    <div class="post-action">
                                        <a href="/tin-tuc/{{ $item->slug }}-{{ $item->id }}" class="see-detail">
                                            <span>Xem chi tiết</span>
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>               
                        @endforeach
                    </div>
                    @if (count($posts) > 4)
                        <div class="navigation-button swiper-button-next active">
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="navigation-button swiper-button-prev">
                            <i class="fa-solid fa-angle-left"></i>
                        </div>
                        <div class="swiper-pagination"></div>
                    @endif

                </div>
            <div class="view-more-posts">
                <a href="/tin-tuc-tong-hop">Xem thêm</a>
            </div>
        </div>

        <div class="featured-doctor">
            <div class="media-title">
                <h2>Bác sĩ nổi bật</h2>
            </div>
            <div class="swiper slideDoctor">
                <ul class="swiper-wrapper list-featured-doctor">
                    @foreach ($doctors as $item)
                        <li class="swiper-slide item-info">
                            <a href="/doi-ngu-chuyen-gia/{{$item->slug_name}}" class="link-doctor">
                                <div class="avatar-doctor">
                                    <img src="{{ $item->avatar_url }}" alt="Ảnh {{$item->name}}">
                                </div>
                                <div class="info-nurse">
                                    <span class="name">{{$item->name}}</span>
                                    <span class="specialty-doctor">{{$item->specialty?->name}}</span>
                                </div>
                            </a>
                        </li>     
                    @endforeach
                </ul>
                @if (count($doctors) > 4)
                    <div class="navigation-button swiper-button-next active">
                        <i class="fa-solid fa-angle-right"></i>
                    </div>
                    <div class="navigation-button swiper-button-prev">
                        <i class="fa-solid fa-angle-left"></i>
                    </div>
                @endif
            </div>
        </div>

        {{-- <div class="services">
            <div class="media-title">
                <h2>Các dịch vụ y tế HealthCare cung cấp</h2>
            </div>
            <div class="service-items">
                <div class="service-item">
                    <div class="service-item-info">
                        <div class="service-item-photo">
                            <div class="service-item-image">
                                <img src="https://medlatec.vn/media/23252/file/kham-suc-khoe-doanh-nghiep-medlatec-68.jpg"
                                    alt="">
                            </div>
                            <div class="service-item-icon">
                                <img src="{{asset('assets/images/service1-1.png')}}" alt="" class="base">
                                <img src="{{asset('assets/images/service1-2.png')}}" alt="" class="hover">
                            </div>
                        </div>
                        <div class="service-item-details">
                            <h3 class="service-item-title"> Khám sức khỏe cho doanh nghiệp </h3>
                            <div class="service-item-excerpt">
                                Tiết kiệm thời gian, chi phí, không cần xếp hạng chờ đợi, tránh lây nhiễm chéo.
                                Theo dõi kết quả chủ động qua website, app My Medlatec, SMS
                            </div>
                            <div class="service-item-actions">
                                <a href="/dich-vu/kham-suc-khoe-dinh-ky-doanh-nghiep#formKhamVaTuVan"
                                    class="action action-book">Đặt lịch</a>
                                <a href="/dich-vu/kham-suc-khoe-dinh-ky-doanh-nghiep"
                                    class="action action-view">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="service-item">
                    <div class="service-item-info">
                        <div class="service-item-photo">
                            <div class="service-item-image">
                                <img src="https://medlatec.vn/media/23252/file/kham-suc-khoe-doanh-nghiep-medlatec-68.jpg"
                                    alt="">
                            </div>
                            <div class="service-item-icon">
                                <img src="{{asset('assets/images/service1-1.png')}}" alt="" class="base">
                                <img src="{{asset('assets/images/service1-2.png')}}" alt="" class="hover">
                            </div>
                        </div>
                        <div class="service-item-details">
                            <h3 class="service-item-title"> Khám sức khỏe cho doanh nghiệp </h3>
                            <div class="service-item-excerpt">
                                Tiết kiệm thời gian, chi phí, không cần xếp hạng chờ đợi, tránh lây nhiễm chéo.
                                Theo dõi kết quả chủ động qua website, app My Medlatec, SMS
                            </div>
                            <div class="service-item-actions">
                                <a href="/dich-vu/kham-suc-khoe-dinh-ky-doanh-nghiep#formKhamVaTuVan"
                                    class="action action-book">Đặt lịch</a>
                                <a href="/dich-vu/kham-suc-khoe-dinh-ky-doanh-nghiep"
                                    class="action action-view">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="service-item">
                    <div class="service-item-info">
                        <div class="service-item-photo">
                            <div class="service-item-image">
                                <img src="https://medlatec.vn/media/23252/file/kham-suc-khoe-doanh-nghiep-medlatec-68.jpg"
                                    alt="">
                            </div>
                            <div class="service-item-icon">
                                <img src="{{asset('assets/images/service1-1.png')}}" alt="" class="base">
                                <img src="{{asset('assets/images/service1-2.png')}}" alt="" class="hover">
                            </div>
                        </div>
                        <div class="service-item-details">
                            <h3 class="service-item-title"> Khám sức khỏe cho doanh nghiệp </h3>
                            <div class="service-item-excerpt">
                                Tiết kiệm thời gian, chi phí, không cần xếp hạng chờ đợi, tránh lây nhiễm chéo.
                                Theo dõi kết quả chủ động qua website, app My Medlatec, SMS
                            </div>
                            <div class="service-item-actions">
                                <a href="/dich-vu/kham-suc-khoe-dinh-ky-doanh-nghiep#formKhamVaTuVan"
                                    class="action action-book">Đặt lịch</a>
                                <a href="/dich-vu/kham-suc-khoe-dinh-ky-doanh-nghiep"
                                    class="action action-view">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="specialty">
            <div class="media-title">
                <h2>Các chuyên khoa y tế tại HealthCare</h2>
            </div>
            <div class="specialty-items">
                @foreach ($specialties as $item)
                    <div class="specialty-item">
                        <a href="/chuyen-khoa/{{ $item->slug }}">
                            <div class="specialty-item-photo">
                                <img src="{{ $item->icon }}" alt="Ảnh {{ $item->name }}">
                            </div>
                        </a>
                        <div class="specialty-item-name">
                            <a href="/chuyen-khoa/{{ $item->slug }}">
                                <span>{{ $item->name }}</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection