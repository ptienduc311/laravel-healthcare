@extends('layouts.app')

@section('title', 'Tìm kiếm bác sĩ')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/css/listdoctor.css ') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/news.css ') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/search.css ') }}">
@stop

@section('content')
<div id="main-content">
    <div class="header-category" style="background-image: url(https://medlatec.vn/med/images/breadcrumb4.jpg);">
        <div class="container">
            <h1>Tìm kiếm</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/">Trang chủ</a>
                </li>
                <li class="active">Kết quả tìm kiếm: {{ $keyword }}</li>
            </ol>
        </div>
    </div>
    <div class="container">
        @if ($total != 0)
            <h2 class="search-wrapper-title">Hiển thị {{ $total }} kết quả theo từ khóa <span style="display: inline-block;">“{{ $keyword }}”</span></h2>
        @else
            <h2 class="search-wrapper-title">Không có kết quả theo từ khóa “ {{ $keyword }}”</h2>
        @endif
        <div class="row">
            <div class="col-xs-12 col-lg-8">
                <div class="search-wrapper">
                    @if ($total != 0)
                        <ul class="search-nav-filter">
                            <li><a href="/tim-kiem-bai-viet?keyword={{ $keyword }}">Bài viết ({{ $total_post }})</a></li>
                            <li class="active"><a href="/tim-kiem-bac-si?keyword={{ $keyword }}">Bác sĩ ({{ $total_doctor }})</a></li>
                        </ul>
                        <div class="team-items">
                            @foreach ($doctors as $item)
                                <div class="team-item">
                                    <div class="team-item-info">
                                        <div class="team-item-photo">
                                            <a href="/doi-ngu-chuyen-gia/{{$item->slug_name}}" class="avatar-doctor">
                                                <img src="{{ $item->avatar_url }}" alt="Ảnh {{$item->name}}">
                                            </a>
                                            <span class="circle"></span>
                                        </div>
                                        <div class="team-item-details">
                                            <h3 class="team-item-name">
                                                <a href="/doi-ngu-chuyen-gia/{{$item->slug_name}}">{{$item->name}}</a>
                                            </h3>
                                            <div class="team-item-special">
                                                <a href="">Chuyên khoa - {{ $item->specialty?->name }}</a>
                                            </div>
                                            <div class="team-item-review">
                                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                            </div>
                                            <div class="team-item-book">
                                                <a href="/doi-ngu-chuyen-gia/{{$item->slug_name}}#book-doctor">Đặt lịch khám</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $doctors->links('vendor.pagination.custom-pagination') }}
                    @else
                        <div class="search-empty">
                            <img loading="lazy" src="{{ asset('assets/images/search-empty.png') }}" alt="Not found">
                            <p>Không có kết quả theo từ khóa “{{ $keyword }}”</p>
                        </div>
                    @endif
                </div>
            </div>
            @include('inc_themes.sidebar')
        </div>
    </div>
</div>
@endsection