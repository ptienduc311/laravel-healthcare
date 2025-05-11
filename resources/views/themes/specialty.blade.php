@extends('layouts.app')

@section('title', "Chuyên khoa y tế")

@section('content')
<div id="main-content">
    <div class="header-category" style="background-image: url(https://medlatec.vn/med/images/breadcrumb4.jpg);">
        <div class="container">
            <h1>Các chuyên khoa y tế</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/">Trang chủ</a>
                </li>
                <li class="active">Chuyên khoa y tế</li>
            </ol>
        </div>
    </div>
    <div class="container">
        <div class="services-list">
            <div class="service-items">
                @foreach ($specialties as $item)
                    <div class="service-item">
                        <div class="service-item-info">
                            <div class="service-item-photo">
                                <div class="service-item-image">
                                    <img src="{{ $item->thumb }}" alt="Ảnh {{ $item->name }}">
                                </div>
                                <div class="service-item-icon">
                                    <img src="{{ $item->icon }}" alt="Ảnh icon {{ $item->name }}" loading="lazy" class="base">
                                    <img src="{{ $item->icon }}" alt="Ảnh icon {{ $item->name }}" loading="lazy" class="hover">
                                </div>
                            </div>
                            <div class="service-item-details">
                                <a href="/chuyen-khoa/{{ $item->slug }}" class="service-item-title">
                                    {{ $item->name }}
                                </a>
                                <div class="service-item-excerpt">
                                    {{ $item->description }}
                                </div>
                                <div class="service-item-actions">
                                    <a href="/chuyen-khoa/{{ $item->slug }}" class="see-detail">
                                        <span>Xem chi tiết</span>
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection