<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-warning" href="{{ url('/') }}">
            <i class="fa-solid fa-film"></i> CinemaHub
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Trang chủ</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="genreDropdown" role="button"
                        data-bs-toggle="dropdown">
                        Thể loại
                    </a>
                    <ul class="dropdown-menu">
                        @foreach($genres as $genre)
                            <li>
                                <a class="dropdown-item" href="{{ route('movies.index', ['genres[]' => $genre->id]) }}">
                                    {{ $genre->name_genre }}
                                </a>

                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('movies.index')}}">Danh sách phim</a>
                </li>
            </ul>

            {{-- Search --}}
            {{-- <form class="d-flex me-3" role="search">
                <input class="form-control me-2 bg-dark text-light border-secondary" type="search"
                    placeholder="Tìm tên phim...">
                <button class="btn btn-outline-warning" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form> --}}

            {{-- User section --}}
            @if(Auth::check())
                <div class="dropdown">
                    <a class="btn btn-outline-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-user"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Thông tin cá nhân</a></li>
                        <li><a class="dropdown-item" href="{{ route('watchlist.index') }}">Xem sau</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout')}}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('auth', ['type' => 'login']) }}" class="btn btn-outline-light me-2">Đăng nhập</a>
                <a href="{{ route('auth', ['type' => 'register']) }}" class="btn btn-warning">Đăng ký</a>

            @endif
        </div>
    </div>
</nav>