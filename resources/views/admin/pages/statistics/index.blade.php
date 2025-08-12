@extends('admin.layout')

@section('content')
<h3>Thống kê tổng quan</h3>

<div class="row g-3">
    <div class="col-md-3">
        <div class="card p-3 bg-light">
            <h6>Tổng lượt xem</h6>
            <p class="fs-4 fw-bold">{{ number_format($totalViews) }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 bg-light">
            <h6>Tổng lượt thích</h6>
            <p class="fs-4 fw-bold">{{ number_format($totalLikes) }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 bg-light">
            <h6>Tổng bình luận</h6>
            <p class="fs-4 fw-bold">{{ number_format($totalComments) }}</p>
        </div>
    </div>
</div>

<div class="row g-3 mt-2">
    <div class="col-md-3">
        <div class="card p-3 bg-light">
            <h6>Phim đang hiển thị</h6>
            <p class="fs-4 fw-bold">{{ $moviesVisible }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 bg-light">
            <h6>Phim đang ẩn</h6>
            <p class="fs-4 fw-bold">{{ $moviesHidden }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 bg-light">
            <h6>Người dùng thường</h6>
            <p class="fs-4 fw-bold">{{ $totalUsers }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 bg-light">
            <h6>Người dùng đang hoạt động</h6>
            <p class="fs-4 fw-bold">{{ $usersActive }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 bg-light">
            <h6>Người dùng bị khóa</h6>
            <p class="fs-4 fw-bold">{{ $usersBlocked }}</p>
        </div>
    </div>
</div>

<hr>

<h4>Top 5 phim được xem nhiều nhất</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tên phim</th>
            <th>Lượt xem</th>
        </tr>
    </thead>
    <tbody>
        @foreach($topViewMovies as $m)
        <tr>
            <td>{{ $m->name_movie }}</td>
            <td>{{ number_format($m->view_count) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h4>Top 5 phim được thích nhiều nhất</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tên phim</th>
            <th>Số lượt thích</th>
        </tr>
    </thead>
    <tbody>
        @foreach($topLikeMovies as $m)
        <tr>
            <td>{{ $m->name_movie }}</td>
            <td>{{ $m->movie_likes_count }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
