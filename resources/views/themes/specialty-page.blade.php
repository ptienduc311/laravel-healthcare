@extends('layouts.app')

@section('title', $specialty->name)
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/css/news.css ') }}">
@stop

@section('content')
<div id="main-content">
    <div class="header-category" style="background-image: url(https://medlatec.vn/med/images/breadcrumb4.jpg);">
        <div class="container">
            <h1>Các chuyên khoa y tế</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/">Trang chủ</a>
                </li>
                <li>
                    <a href="/chuyen-khoa">Chuyên khoa y tế</a>
                </li>
                <li class="active">Chuyên khoa {{ $specialty->name }}</li>
            </ol>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <h1 class="page-title">{{ $specialty->name }}</h1>
                <div class="info-specialty">
                    @if ($page_specialty || $services->isNotEmpty())
                        @if ($page_specialty)
                            <div class="description">
                                {{ $page_specialty->description }}
                            </div>
                            <div class="img-description">
                                @if ($page_specialty->image_id)
                                    <img src="{{ $page_specialty->thumb }}" alt="Ảnh mô tả {{ $specialty->name }}">
                                @endif
                            </div>
                            <h2 class="main-title">Cơ sở vật chất - Trang thiết bị</h2>
                            <div class="specialist-material-desc">
                                {!! $page_specialty->content !!}
                            </div>
                        @endif
                        
                        @if ($services->isNotEmpty())
                            <h2 class="main-title">Dịch vụ chính</h2>
                            <div class="specialist-service-list row">
                                @foreach ($services as $item)
                                    <div class="specialist-service-item col-lg-6">
                                        <h3>{{ $item->name }}</h3>
                                        <p>{{ $item->description }}</p>
                                    </div>
                                @endforeach

                            </div>
                        @endif
                    @else
                        <h3 class="error">Đang cập nhật trang chuyên khoa <b>{{ $specialty->name }}</b>.</h3>
                    @endif
                </div>
                <div class="list-doctor-specialty">
                    <h2 class="title-cat">Đội ngũ bác sĩ chuyên khoa</h2>
                    <div class="swiper slideDoctorSpecial">
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
                        @if (count($doctors) >= 3)
                            <div class="navigation-button swiper-button-next active">
                                <i class="fa-solid fa-angle-right"></i>
                            </div>
                            <div class="navigation-button swiper-button-prev">
                                <i class="fa-solid fa-angle-left"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @include('inc_themes.sidebar')
        </div>
    </div>
</div>
@endsection