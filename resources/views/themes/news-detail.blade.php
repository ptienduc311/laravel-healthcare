@extends('layouts.app')

@section('title', $post->title) {{-- Truyền biến --}}
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/css/news.css ') }}">
@stop

@section('content')
<div id="main-content">
    <div class="header-category" style="background-image: url('{{ $post->image_id && $post->image()->exists() ? Storage::url($post->image->src) : 'https://medlatec.vn/med/images/breadcrumb4.jpg' }}');">
        <div class="container">
            <h1>Tin tức</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/">Trang chủ</a>
                </li>
                <li>
                    <a href="/{{ $post->category?->slug }}">{{ $post->category?->name }}</a>
                </li>
                <li class="active">{{ $post->title }}</li>
            </ol>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <div class="block-post-single">
                    <h1 class="post-title">{{ $post->title }}</h1>
                    <div class="post-item-date">
                        <i class="fa-regular fa-clock"></i>{{ date('d/m/Y', $post->created_date_int) }}
                    </div>
                    <div class="post-description">{{ $post->description }}</div>
                    <div class="post-content">
                        {!! $post->content !!}
                    </div>
                </div>
                <div class="related-news">
                    <h2>Tin cùng chuyên mục</h2>
                    <div class="post-list">
                        @foreach ($list_related_news as $item)
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
            </div>
            @include('inc_themes.sidebar')
        </div>
    </div>
</div>
@endsection