<nav class="col-2 sidebar d-flex flex-column p-0">
                <div class="p-3 text-center border-bottom">
                    <h5>Trang quản trị</h5>
                </div>
                <ul class="nav flex-column p-2">
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{route('admin.users.index')}}">Quản lý người dùng</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{route('admin.genres.index')}}">Quản lý danh mục phim</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{route('admin.countries.index')}}">Quản lý quốc gia</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{route('admin.movies.index')}}">Quản lý phim</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="">Quản lý đánh giá</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="">Thống kê</a>
                    </li>
                    <li class="nav-item mt-auto border-top">
                        <a class="nav-link text-danger" href="{{route('logout')}}">Đăng xuất</a>
                    </li>
                </ul>
            </nav>