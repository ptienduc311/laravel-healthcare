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
                    <form action="" method="get">
                        <div class="row">
                            <div class="col-sm-3 type-filter">
                                <div class="select-btn">
                                    <span>Select Country</span>
                                    <i class="fa-solid fa-angle-down"></i>
                                </div>
                                <div class="options-content">
                                    <div class="search">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <input type="text" placeholder="Search" class="search-input">
                                    </div>
                                    <ul class="options">
                                        <li>VietNam</li>
                                        <li>Mỹ</li>
                                        <li>Đức</li>
                                        <li>Pháp</li>
                                        <li>Trung Quốc</li>
                                        <li>Anh</li>
                                        <li>Hà Lan</li>
                                        <li>Bỉ</li>
                                        <li>VietNam</li>
                                        <li>Mỹ</li>
                                        <li>Đức</li>
                                        <li>Pháp</li>
                                        <li>Trung Quốc</li>
                                        <li>Anh</li>
                                        <li>Hà Lan</li>
                                        <li>Bỉ</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-3 type-filter">
                                <div class="select-btn">
                                    <span>Select Country</span>
                                    <i class="fa-solid fa-angle-down"></i>
                                </div>
                                <div class="options-content">
                                    <div class="search">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <input type="text" placeholder="Search" class="search-input">
                                    </div>
                                    <ul class="options">
                                        <li>VietNam</li>
                                        <li>Mỹ</li>
                                        <li>Đức</li>
                                        <li>Pháp</li>
                                        <li>Trung Quốc</li>
                                        <li>Anh</li>
                                        <li>Hà Lan</li>
                                        <li>Bỉ</li>
                                        <li>VietNam</li>
                                        <li>Mỹ</li>
                                        <li>Đức</li>
                                        <li>Pháp</li>
                                        <li>Trung Quốc</li>
                                        <li>Anh</li>
                                        <li>Hà Lan</li>
                                        <li>Bỉ</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-3 type-filter">
                                <div class="select-btn">
                                    <span>Select Country</span>
                                    <i class="fa-solid fa-angle-down"></i>
                                </div>
                                <div class="options-content">
                                    <div class="search">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <input type="text" placeholder="Search" class="search-input">
                                    </div>
                                    <ul class="options">
                                        <li>VietNam</li>
                                        <li>Mỹ</li>
                                        <li>Đức</li>
                                        <li>Pháp</li>
                                        <li>Trung Quốc</li>
                                        <li>Anh</li>
                                        <li>Hà Lan</li>
                                        <li>Bỉ</li>
                                        <li>VietNam</li>
                                        <li>Mỹ</li>
                                        <li>Đức</li>
                                        <li>Pháp</li>
                                        <li>Trung Quốc</li>
                                        <li>Anh</li>
                                        <li>Hà Lan</li>
                                        <li>Bỉ</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-3 type-filter">
                                <div class="select-btn">
                                    <span>Select Country</span>
                                    <i class="fa-solid fa-angle-down"></i>
                                </div>
                                <div class="options-content">
                                    <div class="search">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <input type="text" placeholder="Search" class="search-input">
                                    </div>
                                    <ul class="options">
                                        <li>VietNam</li>
                                        <li>Mỹ</li>
                                        <li>Đức</li>
                                        <li>Pháp</li>
                                        <li>Trung Quốc</li>
                                        <li>Anh</li>
                                        <li>Hà Lan</li>
                                        <li>Bỉ</li>
                                        <li>VietNam</li>
                                        <li>Mỹ</li>
                                        <li>Đức</li>
                                        <li>Pháp</li>
                                        <li>Trung Quốc</li>
                                        <li>Anh</li>
                                        <li>Hà Lan</li>
                                        <li>Bỉ</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-2 actions">
                                <button type="submit" class="btn btn-primary btn_TimKiem">Tìm kiếm bác sĩ</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="team-items">
                <div class="team-item">
                    <div class="team-item-info">
                        <div class="team-item-photo">
                            <a href="" class="avatar-doctor">
                                <img src="https://medlatec.vn/media/1555/catalog/thaytri-removebg-preview.png?size=256" alt="">
                            </a>
                            <span class="circle"></span>
                        </div>
                        <div class="team-item-details">
                            <h3 class="team-item-name">
                                <a href="">TTND.GS.AHLĐ.BSCC Nguyễn Anh Trí</a>
                            </h3>
                            <div class="team-item-special">
                                <a href="">Chuyên khoa - Xét nghiệm</a>
                            </div>
                            <div class="team-item-review">
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                            </div>
                            <div class="team-item-book">
                                <a href="">Đặt lịch khám</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="team-item">
                    <div class="team-item-info">
                        <div class="team-item-photo">
                            <a href="" class="avatar-doctor">
                                <img src="https://medlatec.vn/media/1555/catalog/thaytri-removebg-preview.png?size=256" alt="">
                            </a>
                            <span class="circle"></span>
                        </div>
                        <div class="team-item-details">
                            <h3 class="team-item-name">
                                <a href="">TTND.GS.AHLĐ.BSCC Nguyễn Anh Trí</a>
                            </h3>
                            <div class="team-item-special">
                                <a href="">Chuyên khoa - Xét nghiệm</a>
                            </div>
                            <div class="team-item-review">
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                            </div>
                            <div class="team-item-book">
                                <a href="">Đặt lịch khám</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="team-item">
                    <div class="team-item-info">
                        <div class="team-item-photo">
                            <a href="" class="avatar-doctor">
                                <img src="https://medlatec.vn/media/1555/catalog/thaytri-removebg-preview.png?size=256" alt="">
                            </a>
                            <span class="circle"></span>
                        </div>
                        <div class="team-item-details">
                            <h3 class="team-item-name">
                                <a href="">TTND.GS.AHLĐ.BSCC Nguyễn Anh Trí</a>
                            </h3>
                            <div class="team-item-special">
                                <a href="">Chuyên khoa - Xét nghiệm</a>
                            </div>
                            <div class="team-item-review">
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                            </div>
                            <div class="team-item-book">
                                <a href="">Đặt lịch khám</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="team-item">
                    <div class="team-item-info">
                        <div class="team-item-photo">
                            <a href="" class="avatar-doctor">
                                <img src="https://medlatec.vn/media/1555/catalog/thaytri-removebg-preview.png?size=256" alt="">
                            </a>
                            <span class="circle"></span>
                        </div>
                        <div class="team-item-details">
                            <h3 class="team-item-name">
                                <a href="">TTND.GS.AHLĐ.BSCC Nguyễn Anh Trí</a>
                            </h3>
                            <div class="team-item-special">
                                <a href="">Chuyên khoa - Xét nghiệm</a>
                            </div>
                            <div class="team-item-review">
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                            </div>
                            <div class="team-item-book">
                                <a href="">Đặt lịch khám</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navigation">
                <ul class="pagination">
                    <li class="disabled page-item">
                        <a href="#" class="previous page-link" title="Trước">
                            <i class="fa-solid fa-angle-left"></i>
                        </a>
                    </li>
                    <li class="page-item active">
                        <a href="" class="page-link" title="Trang 1">1</a>
                    </li>
                    <li class="page-item">
                        <a href="" class="page-link" title="Trang 2">2</a>
                    </li>
                    <li class="page-item">
                        <a href="" class="page-link" title="Trang 3">3</a>
                    </li>
                    <li class="page-item">
                        <a href="" class="page-link" title="Trang 4">4</a>
                    </li>
                    <li class="page-item">
                        <a href="" class="next page-link" title="Trước">
                            <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection