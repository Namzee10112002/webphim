<footer class="bg-dark text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row">
            {{-- Logo + mô tả --}}
            <div class="col-md-4">
                <h5 class="text-warning"><i class="fa-solid fa-film"></i> CinemaHub</h5>
                <p>Xem phim online chất lượng cao, cập nhật nhanh chóng các bộ phim mới nhất.</p>
            </div>

            {{-- Liên kết nhanh --}}
            <div class="col-md-4">
                <h6 class="text-warning">Liên kết nhanh</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}" class="text-light text-decoration-none">Trang chủ</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Thể loại</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Danh sách phim</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Liên hệ</a></li>
                </ul>
            </div>

            {{-- Mạng xã hội --}}
            <div class="col-md-4">
                <h6 class="text-warning">Theo dõi chúng tôi</h6>
                <div class="d-flex gap-3">
                    <a href="#" class="text-light fs-4"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-light fs-4"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-light fs-4"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>

        <hr class="border-secondary my-3">

        <p class="mb-0 text-center small">&copy; 2025 CinemaHub. All rights reserved.</p>
    </div>
</footer>
