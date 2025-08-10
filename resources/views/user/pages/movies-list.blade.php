@extends('user.layout')

@push('styles')
<style>
    body{
        background-color: #121212;
    }
    .filter-aside {
        background: #1e1e1e;
        color: #fff;
        padding: 15px;
        border-radius: 8px;
    }
    .movie-card {
        background: #2a2a2a;
        border-radius: 8px;
        padding: 10px;
        color: #fff;
        height: 700px;
    }
    .movie-card img {
        border-radius: 5px;
        width: 100%;
        height: 450px;
    }

</style>
@endpush

@section('content')
<div class="container my-4">
    <div class="row">
        <!-- Aside Filter -->
        <div class="col-md-3">
            <form method="GET" action="{{ route('movies.index') }}" class="filter-aside">

                <!-- Search by name -->
                <div class="mb-3">
                    <label class="form-label">Tìm kiếm theo tên</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control">
                </div>

                <!-- Year range -->
                <div class="mb-3">
                    <label class="form-label">Năm phát hành</label>
                    <input type="number" name="year_min" value="{{ request('year_min', $minYear) }}" min="{{ $minYear }}" max="{{ $maxYear }}" class="form-control mb-2">
                    <input type="number" name="year_max" value="{{ request('year_max', $maxYear) }}" min="{{ $minYear }}" max="{{ $maxYear }}" class="form-control">
                </div>

                <!-- Genres -->
                <div class="mb-3">
                    <label class="form-label">Thể loại</label>
                    @foreach($genres as $genre)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                {{ in_array($genre->id, (array)request('genres')) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $genre->name_genre }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- Countries -->
                <div class="mb-3">
                    <label class="form-label">Quốc gia</label>
                    @foreach($countries as $country)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="countries[]" value="{{ $country->id }}"
                                {{ in_array($country->id, (array)request('countries')) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $country->name_country }}</label>
                        </div>
                    @endforeach
                </div>
<!-- Loại phim -->
                    <div class="mb-3">
                        <label class="form-label">Loại phim</label>
                        <select name="is_series" class="form-select">
                            <option value="">Tất cả</option>
                            <option value="0" {{ request('is_series') === '0' ? 'selected' : '' }}>Phim lẻ</option>
                            <option value="1" {{ request('is_series') === '1' ? 'selected' : '' }}>Phim bộ</option>
                        </select>
                    </div>

                <button type="submit" class="btn btn-warning w-100">Lọc</button>
            </form>
        </div>

        <!-- Movies List -->
        <div class="col-md-9">
            <div class="row g-3">
                @foreach($movies as $movie)
                    <div class="col-md-4">
                        <div class="movie-card">
                            <a href="{{ route('movies.show', $movie->id) }}">
                                <img src="{{ $movie->image_movie }}" alt="{{ $movie->title }}">
                            </a>
                            <h6 class="mt-2">{{ $movie->name_movie }}</h6>
                            <p class="card-text">Thể loại: {{ $movie->genres->pluck('name_genre')->unique()->join(', ') . "\n" }}</p>
                            <p class="card-text">Quốc gia: {{ $movie->countries->pluck('name_country')->unique()->join(', ') . "\n" }}</p>
                            <p>Phát hành: {{ $movie->year_release }}</p>
                            <p>Lượt xem: {{ $movie->clicks }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-3">
                {{ $movies->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
