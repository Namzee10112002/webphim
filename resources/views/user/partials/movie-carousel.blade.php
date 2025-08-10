<div id="{{ $sectionId }}" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        @php
            $moviesPerSlide = 4;
            $chunks = $movies->chunk($moviesPerSlide);
        @endphp

        @foreach($chunks as $index => $chunk)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <div class="row g-5">
                    @foreach($chunk as $i)
                        <div class="col-md-3">
                            <div class="card movie-card">
                                <a href="{{ route('movies.show', $i->id) }}">
                                    <img src="{{ $i->image_movie }}" class="card-img-top" alt="Phim {{ $i->name_movie }}" width="100%" height="250px">
                                </a>
                                <div class="card-body text-white">
                                    <h6 class="card-title">Tên Phim {{ $i->name_movie }}</h6>
                                    <p class="card-text">Năm phát hành: {{ $i->year_release }}</p>
                                    <p class="card-text">Thể loại: {{ $i->genres->pluck('name_genre')->unique()->join(', ') . "\n" }}</p>
                                    <p class="card-text">Quốc gia: {{ $i->countries->pluck('name_country')->unique()->join(', ') . "\n" }}</p>
                                    <p class="card-text">Lượt xem: {{ $i->clicks }}</p>
                                    <a href="{{ route('movies.show', $i->id) }}" class="detail-btn btn btn-warning w-100 position-absolute ">Xem ngay</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#{{ $sectionId }}" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#{{ $sectionId }}" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>
