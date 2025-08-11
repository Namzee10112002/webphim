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
    </style>
@endpush
@section('content')
    <div class="container">
        <h2>Danh sách phim xem sau</h2>

        @if($watchLists->isEmpty())
            <p>Bạn chưa đánh dấu phim nào để xem sau.</p>
        @else
                <div class="row g-5">
                    @foreach($watchLists as $watch)
                        <div class="col-md-3">
                            <div class="card movie-card">
                                <a href="{{ route('movies.show', $watch->movieDetail->movie->id) }}">
                                    <img src="{{ $watch->movieDetail->movie->image_movie }}" class="card-img-top"
                                        alt="Phim {{ $watch->movieDetail->movie->name_movie }}" width="100%" height="250px">
                                </a>
                                <div class="card-body text-white">
                                    @if ($watch->movieDetail->movie->is_series == 0)
                                        <h6 class="card-title">Tên Phim: {{ $watch->movieDetail->movie->name_movie }}</h6>
                                    @else
                                        <h6 class="card-title">Tên Phim: {{ $watch->movieDetail->name_detail }}
                                    @endif
                                        <p class="card-text">Năm phát hành: {{ $watch->movieDetail->movie->year_release }}</p>
                                        <p class="card-text">Thể loại:
                                            {{ $watch->movieDetail->movie->genres->pluck('name_genre')->unique()->join(', ') . "\n" }}
                                        </p>
                                        <p class="card-text">Quốc gia:
                                            {{ $watch->movieDetail->movie->countries->pluck('name_country')->unique()->join(', ') . "\n" }}
                                        </p>
                                        <a href="{{ route('movies.show', $watch->movieDetail->movie->id) }}"
                                            class="btn btn-warning w-100">Xem ngay</a>
                                </div>
                                @if($watch->movieDetail->movie->is_series == 1)
                                    <span class="badge bg-success position-absolute top-0 start-0 m-2">Phim bộ</span>
                                @else
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">Phim lẻ</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
        @endif
    </div>
@endsection