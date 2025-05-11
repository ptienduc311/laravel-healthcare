@extends('layouts.app')

@section('title', 'Tin tức tổng hợp')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/css/news.css ') }}">
@stop

@section('content')
<div id="main-content">
    <div class="header-category" style="background-image: url(https://medlatec.vn/med/images/breadcrumb4.jpg);">
        <div class="container">
            <h1>Tin tức</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/">Trang chủ</a>
                </li>
                <li class="active">Tin tổng hợp</li>
            </ol>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                @foreach($post_categories as $category)
                    <div class="{{ $loop->first ? 'featured-news ' : '' }}cat-news">
                        <div class="block-title">
                            <h2>{{ $category->name }}</h2>
                            @if (!$category->posts->isEmpty())
                                <a href="{{ $category->slug }}" class="action">Xem thêm</a>
                            @endif
                        </div>
                
                        <div class="block-content">
                            @if ($category->posts->isEmpty())
                                <p class="error">Chưa có bài viết nào</p>
                            @else
                                @php $first = true; @endphp
                
                                @foreach($category->posts as $post)
                                    @if ($first)
                                        <div class="blog-lag">
                                            <div class="post-item">
                                                <div class="post-item-info">
                                                    <div class="post-item-photo">
                                                        <a href="/tin-tuc/{{ $post->slug }}-{{ $post->id }}" class="post-image-container">
                                                            <img src="{{ Storage::url($post->image?->src) }}" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="post-item-details">
                                                        <h3 class="post-item-title">
                                                            <a href="/tin-tuc/{{ $post->slug }}-{{ $post->id }}">{{ $post->title }}</a>
                                                        </h3>
                                                        <div class="post-item-excerpt">
                                                            {{ $post->description }}
                                                        </div>
                                                        <div class="post-item-date">
                                                            <i class="fa-regular fa-clock"></i>
                                                            {{ date('d/m/Y', $post->created_date_int) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                
                                        <div class="blog-small">
                                        @php $first = false; @endphp
                                    @else
                                        <div class="post-item post-item-list">
                                            <div class="post-item-info">
                                                <div class="post-item-photo">
                                                    <a href="/tin-tuc/{{ $post->slug }}-{{ $post->id }}" class="post-image-container">
                                                        <img src="{{ Storage::url($post->image?->src) }}" alt="">
                                                    </a>
                                                </div>
                                                <div class="post-item-details">
                                                    <h3 class="post-item-title">
                                                        <a href="/tin-tuc/{{ $post->slug }}-{{ $post->id }}">{{ $post->title }}</a>
                                                    </h3>
                                                    <div class="post-item-date">
                                                        <i class="fa-regular fa-clock"></i>
                                                        {{ date('d/m/Y', $post->created_date_int) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                
                                    @if ($loop->last)
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            @include('inc_themes.sidebar')
        </div>
    </div>
</div>
@endsection