<div class="col-xs-12 col-md-4">
    <div class="sidebar-hotline" style="background-image: url({{ asset('assets/images/bg-after.png') }});">
        <div class="hotline">
            <div class="icon">
                <i class="fa-solid fa-phone-volume"></i>
            </div>
            <div class="text">
                <span>Hotline</span>
                <strong>{{ $site->hotline ?? '' }}</strong>
            </div>
        </div>
        <p>Liên hệ ngay với số hotline của HealthCare để được phục vụ và sử dụng các dịch vụ khám, chữa bệnh hiện đại & cao cấp nhất.</p>
        <a href="tel:{{ $site->hotline ?? '' }}" class="btn btn-primary">Liên hệ với chúng tôi</a>
    </div>
    <div class="sidebar-banner">
        <a href="/">
            <img src="{{ asset('assets/images/slider3.png') }}" alt="Banner 1">
        </a>
    </div>
    <div class="sidebar-banner">
        <a href="/">
            <img src="{{ asset('assets/images/slider4.jpg') }}" alt="Banner 2">
        </a>
    </div>
    @if (isset($list_lastest_news) && $list_lastest_news->isNotEmpty())
        <div class="latest-news">
            <div class="block-title">
                <h2>Tin mới nhất</h2>
            </div>
            <div class="block-content">
                @foreach ($list_lastest_news as $item)
                    <div class="post-item post-item-list">
                        <div class="post-item-info">
                            <div class="post-item-photo">
                                <a href="/tin-tuc/{{ $item->slug }}-{{ $item->id }}" class="post-image-container">
                                    <img src="{{ Storage::url($item->image?->src) }}" alt="Ảnh {{$item->title}}">
                                </a>
                            </div>
                            <div class="post-item-details">
                                <div class="post-item-date">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ date('d/m/Y', $item->created_date_int) }}
                                </div>
                                <h3 class="post-item-title">
                                    <a href="/tin-tuc/{{ $item->slug }}-{{ $item->id }}">
                                        {{ $item->title }}
                                    </a>
                                </h3>
                                <div class="post-item-excerpt">
                                    {{ $item->description }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if (isset($list_featured_news) && $list_featured_news->isNotEmpty())
        <div class="latest-news">
            <div class="block-title">
                <h2>Tin nổi bật</h2>
            </div>
            <div class="block-content">
                @foreach ($list_featured_news as $item)
                    <div class="post-item post-item-list">
                        <div class="post-item-info">
                            <div class="post-item-photo">
                                <a href="/tin-tuc/{{ $item->slug }}-{{ $item->id }}" class="post-image-container">
                                    <img src="{{ Storage::url($item->image?->src) }}" alt="Ảnh {{$item->title}}">
                                </a>
                            </div>
                            <div class="post-item-details">
                                <div class="post-item-date">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ date('d/m/Y', $item->created_date_int) }}
                                </div>
                                <h3 class="post-item-title">
                                    <a href="/tin-tuc/{{ $item->slug }}-{{ $item->id }}">
                                        {{ $item->title }}
                                    </a>
                                </h3>
                                <div class="post-item-excerpt">
                                    {{ $item->description }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>