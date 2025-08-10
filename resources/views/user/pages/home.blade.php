@extends('user.layout')

@push('styles')
<style>
    body {
        background-color: #121212;
        color: #f8f9fa;
    }
    .movie-card {
        background-color: #1e1e1e;
        border: none;
        transition: transform 0.2s;
        height: 750px;
        position: relative;
    }
    .movie-card:hover {
        transform: scale(1.05);
    }
    .movie-card img {
        height: 450px;
        object-fit: cover;
    }
    .section-title {
        border-left: 5px solid #ffc107;
        padding-left: 10px;
    }
    .detail-btn{
        position: absolute;
        bottom: 20px;
        left:   0;
    }
</style>
@endpush

@section('content')

{{-- Banner Slide --}}
<div id="mainCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://i.ytimg.com/vi/Yz96EBNwMGw/maxresdefault.jpg" class="d-block w-100" alt="Banner">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Phim Hot</h5>
                    <p>Mô tả ngắn gọn về phim hot</p>
                </div>
            </div>

            <div class="carousel-item active">
                <img src="https://i.ytimg.com/vi/IkaP0KJWTsQ/maxresdefault.jpg" class="d-block w-100" alt="Banner">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Phim Hot</h5>
                    <p>Mô tả ngắn gọn về phim hot</p>
                </div>
            </div>

            <div class="carousel-item active">
                <img src="https://www.elle.vn/wp-content/uploads/2022/12/27/509986/Phim-hai-han-hay-nhat-moi-thoi-dai.jpg" class="d-block w-100" alt="Banner">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Phim Hot</h5>
                    <p>Mô tả ngắn gọn về phim hot</p>
                </div>
            </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<div class="container">

    {{-- Section: Phim mới --}}
    <h4 class="section-title mb-3">Phim Mới Thêm</h4>
    @include('user.partials.movie-carousel', ['sectionId' => 'newMovies', 'movies' => $latestMovies])

    {{-- Section: Phim nhiều lượt xem --}}
    <h4 class="section-title mt-5 mb-3">Phim Nhiều Lượt Xem</h4>
    @include('user.partials.movie-carousel', ['sectionId' => 'mostViewed', 'movies' => $mostViewedMovies])

</div>
@endsection
