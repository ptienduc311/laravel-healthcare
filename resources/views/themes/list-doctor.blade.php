@extends('layouts.app')

@section('title', 'Đội ngũ chuyên gia')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/css/listdoctor.css ') }}">
@stop

@section('content')
<div id="main-content">
    <div class="header-category" style="background-image: url(https://medlatec.vn/med/images/breadcrumb4.jpg);">
        <div class="container">
            <h1>Đội ngũ chuyên gia</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/">Trang chủ</a>
                </li>
                <li class="active">Đội ngũ chuyên gia</li>
            </ol>
        </div>
    </div>
    <div class="container">
        <div class="teams-list">
            <div class="teams-list-filter">
                <div class="teams-filter-collapse collapsed">
                    <span>Bộ lọc</span>
                    <i class="fa-solid fa-filter"></i>
                </div>
                <div class="teams-filter-content" id="teams-filter">
                    <form action="/doi-ngu-chuyen-gia" method="get">
                        <div class="row">
                            <div class="col-sm-3 type-filter" data-type="specialty_id">
                                <div class="select-btn">
                                    <span>
                                        {{ 
                                            request('specialty_id') && $specialties->contains('id', request('specialty_id')) 
                                                ? $specialties->firstWhere('id', request('specialty_id'))->name 
                                                : 'Chọn chuyên khoa' 
                                        }}
                                    </span>
                                    <i class="fa-solid fa-angle-down"></i>
                                </div>
                                <div class="options-content">
                                    <div class="search">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <input type="text" placeholder="Search" class="search-input">
                                    </div>
                                    <ul class="options">
                                        <li data-id="">Chọn chuyên khoa</li>
                                        @foreach ($specialties as $item)
                                            <li data-id="{{$item->id}}" {{ request('specialty_id') == $item->id ? 'class=selected' : '' }}>
                                                {{$item->name}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" name="specialty_id" id="specialty_id" value="{{ request('specialty_id') ? request('specialty_id') : '' }}">
                            </div>
                            <div class="col-sm-3 type-filter" data-type="acedemic_id">
                                <div class="select-btn">
                                    <span>
                                        {{
                                            request('acedemic_id') && isset($academicTitles[request('acedemic_id')])
                                                ? $academicTitles[request('acedemic_id')]
                                                : 'Chọn học hàm'
                                        }}
                                    </span>
                                    <i class="fa-solid fa-angle-down"></i>
                                </div>
                                <div class="options-content">
                                    <div class="search">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <input type="text" placeholder="Search" class="search-input">
                                    </div>
                                    <ul class="options">
                                        <li data-id="">Chọn học hàm</li>
                                        @foreach ($academicTitles as $id => $name)
                                            <li data-id="{{$id}}" {{ request('acedemic_id') == $id ? 'class=selected' : '' }}>
                                                {{$name}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" name="acedemic_id" id="acedemic_id" value="{{ request('acedemic_id') ? request('acedemic_id') : '' }}">
                            </div>
                            <div class="col-sm-3 type-filter" data-type="degree_id">
                                <div class="select-btn">
                                    <span>
                                        {{
                                            request('degree_id') && isset($degrees[request('degree_id')])
                                                ? $degrees[request('degree_id')]
                                                : 'Chọn học vị'
                                        }}
                                    </span>
                                    <i class="fa-solid fa-angle-down"></i>
                                </div>
                                <div class="options-content">
                                    <div class="search">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <input type="text" placeholder="Search" class="search-input">
                                    </div>
                                    <ul class="options">
                                        <li data-id="">Chọn học vị</li>
                                        @foreach ($degrees as $id => $name)
                                            <li data-id="{{$id}}" {{ request('degree_id') == $id ? 'class=selected' : '' }}>
                                                {{$name}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" name="degree_id" id="degree_id" value="{{ request('degree_id') ? request('degree_id') : '' }}">
                            </div>
                            <div class="col-sm-3 type-filter"></div>
                            <div class="col-sm-2 actions">
                                <button type="submit" class="btn btn-primary btn_TimKiem">Lọc bác sĩ</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if ($doctors->isNotEmpty())
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
                                        <a href="/doi-ngu-chuyen-gia/{{$item->slug_name}}">{{ $item->name }}</a>
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
            @else
                <p class="not-found">Không có dữ liệu về bác sĩ.</p>
            @endif
            {{ $doctors->links('vendor.pagination.custom-pagination') }}
        </div>
    </div>
</div>
@endsection