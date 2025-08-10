@extends('user.layout')
@push('styles')
    <style>
        body {
            background-color: #121212;
            color: #f8f9fa;
        }
    </style>
@endpush
@section('content')
    <div class="container my-4">
        <div class="row">
            <!-- Article -->
            <div class="col-md-9">
                <img src="{{ $movie->image_movie }}" width="40%" height="400px" alt="{{ $movie->name_movie }}">
                <h2>{{ $movie->name_movie }}</h2>
                <p>{{ $movie->description }}</p>

                <h5>Danh sách tập phim:</h5>
                <div class="d-flex flex-wrap">
                    @foreach($episodes as $ep)
                        <a href="{{ route('movies.watch', [$movie->id, $ep->id]) }}" class="btn btn-outline-warning m-1">
                            Tập {{ $ep->orders }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Aside -->
            <div class="col-md-3">
                <div class="p-3 bg-dark text-white rounded">
                    <h5>Thông tin phim</h5>
                    <p><strong>Thể loại:</strong> {{ $movie->genres->pluck('name_genre')->unique()->join(', ') }}</p>
                    <p><strong>Quốc gia:</strong> {{ $movie->countries->pluck('name_country')->unique()->join(', ') }}</p>
                    <p><strong>Năm:</strong> {{ $movie->year_release }}</p>
                    <p><strong>Đạo diễn:</strong> {{ $movie->director }}</p>
                    <p><strong>Diễn viên:</strong> {{ $movie->actor }}</p>
                    <p><strong>Thời lượng:</strong> {{ $movie->duration }}</p>
                    <p><strong>Lượt xem:</strong> {{ $movie->clicks }}</p>
                    <form action="{{ route('movies.like', $movie->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button id="btn-like" data-id="{{ $movie->id }}">
                            @if($userCheckLike)
                                ❤️ Đã thích (<span id="like-count">{{ $movie->movie_likes_count }}</span>)
                            @else
                                ❤️ Thích (<span id="like-count">{{ $movie->movie_likes_count }}</span>)
                            @endif
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#btn-like').click(function () {
            var movieId = $(this).data('id');

            $.ajax({
                url: '/movie/' + movieId + '/like',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (res) {
                   if (res.clear==1) {
                        $('#btn-like').html('❤️ Thích (<span id="like-count">' + res.movie_likes_count + '</span>)');
                    } else {
                        $('#btn-like').html('❤️ Đã thích (<span id="like-count">' + res.movie_likes_count + '</span>)');
                    }
                }
            });
        });
    </script>
@endpush