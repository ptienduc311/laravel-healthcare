@extends('layouts.app')

@section('title', 'Tìm kiếm bài viết')
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
                            <li class="active"><a href="/tim-kiem-bai-viet?keyword={{ $keyword }}">Bài viết ({{ $total_post }})</a></li>
                            <li><a href="/tim-kiem-bac-si?keyword={{ $keyword }}">Bác sĩ ({{ $total_doctor }})</a></li>
                        </ul>
                        <div class="post-list">
                            @foreach ($posts as $item)
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
                        {{ $posts->links('vendor.pagination.custom-pagination') }}
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