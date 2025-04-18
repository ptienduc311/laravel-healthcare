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
                <div class="featured-news cat-news">
                    <div class="block-title">
                        <h2>Tin tức nổi bật</h2>
                        <a href="" class="action">Xem thêm</a>
                    </div>
                    <div class="block-content">
                        <div class="blog-lag">
                            <div class="post-item">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-excerpt">
                                            Người phụ nữ có biểu hiện sốt cao, rét run, kèm theo đó là tiểu buốt, tiểu rắt… nên đến viện khám. Bác sĩ tại Bệnh viện Đa khoa MEDLATEC phát hiện người này mắc các triệu chứng rất điển hình của bệnh nhiễm khuẩn huyết.
                                        </div>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="blog-small">
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cat-news">
                    <div class="block-title">
                        <h2>Tin tức nổi bật</h2>
                        <a href="" class="action">Xem thêm</a>
                    </div>
                    <div class="block-content">
                        <div class="blog-lag">
                            <div class="post-item">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-excerpt">
                                            Người phụ nữ có biểu hiện sốt cao, rét run, kèm theo đó là tiểu buốt, tiểu rắt… nên đến viện khám. Bác sĩ tại Bệnh viện Đa khoa MEDLATEC phát hiện người này mắc các triệu chứng rất điển hình của bệnh nhiễm khuẩn huyết.
                                        </div>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="blog-small">
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cat-news">
                    <div class="block-title">
                        <h2>Tin tức nổi bật</h2>
                        <a href="" class="action">Xem thêm</a>
                    </div>
                    <div class="block-content">
                        <div class="blog-lag">
                            <div class="post-item">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-excerpt">
                                            Người phụ nữ có biểu hiện sốt cao, rét run, kèm theo đó là tiểu buốt, tiểu rắt… nên đến viện khám. Bác sĩ tại Bệnh viện Đa khoa MEDLATEC phát hiện người này mắc các triệu chứng rất điển hình của bệnh nhiễm khuẩn huyết.
                                        </div>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="blog-small">
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cat-news">
                    <div class="block-title">
                        <h2>Tin tức nổi bật</h2>
                        <a href="" class="action">Xem thêm</a>
                    </div>
                    <div class="block-content">
                        <div class="blog-lag">
                            <div class="post-item">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-excerpt">
                                            Người phụ nữ có biểu hiện sốt cao, rét run, kèm theo đó là tiểu buốt, tiểu rắt… nên đến viện khám. Bác sĩ tại Bệnh viện Đa khoa MEDLATEC phát hiện người này mắc các triệu chứng rất điển hình của bệnh nhiễm khuẩn huyết.
                                        </div>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="blog-small">
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cat-news">
                    <div class="block-title">
                        <h2>Tin tức nổi bật</h2>
                        <a href="" class="action">Xem thêm</a>
                    </div>
                    <div class="block-content">
                        <div class="blog-lag">
                            <div class="post-item">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-excerpt">
                                            Người phụ nữ có biểu hiện sốt cao, rét run, kèm theo đó là tiểu buốt, tiểu rắt… nên đến viện khám. Bác sĩ tại Bệnh viện Đa khoa MEDLATEC phát hiện người này mắc các triệu chứng rất điển hình của bệnh nhiễm khuẩn huyết.
                                        </div>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="blog-small">
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-item post-item-list">
                                <div class="post-item-info">
                                    <div class="post-item-photo">
                                        <a href="" class="post-image-container">
                                            <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                        </a>
                                    </div>
                                    <div class="post-item-details">
                                        <h3 class="post-item-title">
                                            <a href="">
                                                Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                            </a>
                                        </h3>
                                        <div class="post-item-date">
                                            <i class="fa-regular fa-clock"></i>
                                            Thứ Bảy, 29 tháng 3, 2025
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="sidebar-hotline" style="background-image: url(https://medlatec.vn/med/images/contactsidebar.png);">
                    <div class="hotline">
                        <div class="icon">
                            <i class="fa-solid fa-phone-volume"></i>
                        </div>
                        <div class="text">
                            <span>Hotline</span>
                            <strong>1900565656</strong>
                        </div>
                    </div>
                    <p>Liên hệ ngay với số hotline của MEDLATEC để được phục vụ và sử dụng các dịch vụ khám, chữa bệnh hiện đại & cao cấp nhất.</p>
                    <a href="tel:1900565656" class="btn btn-primary">Liên hệ với chúng tôi</a>
                </div>
                <div class="sidebar-banner">
                    <a href="" target="_blank">
                        <img src="https://medlatec.vn/media/41099/catalog/B%e1%bb%99+banner+2025_C%e1%bb%99t+ph%e1%ba%a3i.jpg?size=2048" alt="">
                    </a>
                </div>
                <div class="sidebar-banner">
                    <a href="" target="_blank">
                        <img src="https://medlatec.vn/media/41099/catalog/B%e1%bb%99+banner+2025_C%e1%bb%99t+ph%e1%ba%a3i.jpg?size=2048" alt="">
                    </a>
                </div>
                <div class="latest-news">
                    <div class="block-title">
                        <h2>Tin tức nổi bật</h2>
                        <a href="" class="action">Xem thêm</a>
                    </div>
                    <div class="block-content">
                        <div class="post-item post-item-list">
                            <div class="post-item-info">
                                <div class="post-item-photo">
                                    <a href="" class="post-image-container">
                                        <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                    </a>
                                </div>
                                <div class="post-item-details">
                                    <div class="post-item-date">
                                        <i class="fa-regular fa-clock"></i>
                                        Thứ Bảy, 29 tháng 3, 2025
                                    </div>
                                    <h3 class="post-item-title">
                                        <a href="">
                                            Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                        </a>
                                    </h3>
                                    <div class="post-item-excerpt">
                                        Người phụ nữ có biểu hiện sốt cao, rét run, kèm theo đó là tiểu buốt, tiểu rắt… nên đến viện khám. Bác sĩ tại Bệnh viện Đa khoa MEDLATEC phát hiện người này...
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="post-item post-item-list">
                            <div class="post-item-info">
                                <div class="post-item-photo">
                                    <a href="" class="post-image-container">
                                        <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                    </a>
                                </div>
                                <div class="post-item-details">
                                    <div class="post-item-date">
                                        <i class="fa-regular fa-clock"></i>
                                        Thứ Bảy, 29 tháng 3, 2025
                                    </div>
                                    <h3 class="post-item-title">
                                        <a href="">
                                            Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                        </a>
                                    </h3>
                                    <div class="post-item-excerpt">
                                        Người phụ nữ có biểu hiện sốt cao, rét run, kèm theo đó là tiểu buốt, tiểu rắt… nên đến viện khám. Bác sĩ tại Bệnh viện Đa khoa MEDLATEC phát hiện người này...
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="post-item post-item-list">
                            <div class="post-item-info">
                                <div class="post-item-photo">
                                    <a href="" class="post-image-container">
                                        <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                    </a>
                                </div>
                                <div class="post-item-details">
                                    <div class="post-item-date">
                                        <i class="fa-regular fa-clock"></i>
                                        Thứ Bảy, 29 tháng 3, 2025
                                    </div>
                                    <h3 class="post-item-title">
                                        <a href="">
                                            Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                        </a>
                                    </h3>
                                    <div class="post-item-excerpt">
                                        Người phụ nữ có biểu hiện sốt cao, rét run, kèm theo đó là tiểu buốt, tiểu rắt… nên đến viện khám. Bác sĩ tại Bệnh viện Đa khoa MEDLATEC phát hiện người này...
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="post-item post-item-list">
                            <div class="post-item-info">
                                <div class="post-item-photo">
                                    <a href="" class="post-image-container">
                                        <img src="https://medlatec.vn/media/47676/content/nhiem-khuan-huyet-medlatec.jpg?size=1024" alt="">
                                    </a>
                                </div>
                                <div class="post-item-details">
                                    <div class="post-item-date">
                                        <i class="fa-regular fa-clock"></i>
                                        Thứ Bảy, 29 tháng 3, 2025
                                    </div>
                                    <h3 class="post-item-title">
                                        <a href="">
                                            Sốt cao, tiểu rắt… người phụ nữ đến MEDLATEC khám phát hi...
                                        </a>
                                    </h3>
                                    <div class="post-item-excerpt">
                                        Người phụ nữ có biểu hiện sốt cao, rét run, kèm theo đó là tiểu buốt, tiểu rắt… nên đến viện khám. Bác sĩ tại Bệnh viện Đa khoa MEDLATEC phát hiện người này...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection