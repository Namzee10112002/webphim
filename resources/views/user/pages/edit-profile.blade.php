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
<div class="container mt-5">
    <h2>Cập nhật thông tin cá nhân</h2>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf

        <div>
            <label for="name">Tên:</label><br>
            <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $user->name) }}">
            @error('name')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email">Email:</label><br>
            <input class="form-control" type="email" id="email" name="email" value="{{ old('email', $user->email) }}">
            @error('email')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-warning mt-5">Cập nhật</button>
    </form>
</div>
@endsection
