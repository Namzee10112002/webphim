@extends('user.layout')

@push('styles')
<style>
    body {
        background-color: #121212;
        color: #fff;
    }
    .auth-container {
        max-width: 500px;
        margin: 50px auto;
        background-color: #1e1e1e;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0px 4px 15px rgba(0,0,0,0.5);
    }
    .auth-toggle {
        cursor: pointer;
        color: #ffc107;
    }
</style>
@endpush

@section('content')
<div class="auth-container">
    <h3 class="text-center text-warning mb-4" id="formTitle">
        {{ $type == 'register' ? 'Đăng ký' : 'Đăng nhập' }}
    </h3>

    {{-- Form Đăng nhập --}}
    <form id="loginForm" method="POST" action="{{ route('login') }}" style="{{ $type == 'login' ? '' : 'display:none;' }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control bg-dark text-light" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mật khẩu</label>
            <input type="password" name="password" class="form-control bg-dark text-light" required>
        </div>
        <button type="submit" class="btn btn-warning w-100">Đăng nhập</button>
        <p class="mt-3 text-center">Chưa có tài khoản? <span class="auth-toggle" data-type="register">Đăng ký ngay</span></p>
    </form>

    {{-- Form Đăng ký --}}
    <form id="registerForm" method="POST" action="{{ route('register') }}" style="{{ $type == 'register' ? '' : 'display:none;' }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Họ và tên</label>
            <input type="text" name="name" class="form-control bg-dark text-light" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control bg-dark text-light" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mật khẩu</label>
            <input type="password" name="password" class="form-control bg-dark text-light" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" class="form-control bg-dark text-light" required>
        </div>
        <button type="submit" class="btn btn-warning w-100">Đăng ký</button>
        <p class="mt-3 text-center">Đã có tài khoản? <span class="auth-toggle" data-type="login">Đăng nhập ngay</span></p>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.auth-toggle').forEach(el => {
        el.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            if (type === 'register') {
                document.getElementById('loginForm').style.display = 'none';
                document.getElementById('registerForm').style.display = 'block';
                document.getElementById('formTitle').innerText = 'Đăng ký';
            } else {
                document.getElementById('loginForm').style.display = 'block';
                document.getElementById('registerForm').style.display = 'none';
                document.getElementById('formTitle').innerText = 'Đăng nhập';
            }
        });
    });
</script>
@endpush
