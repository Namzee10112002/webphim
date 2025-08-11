@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Tạo Promotion</h2>
    <form action="{{ route('admin.promotions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Tên promotion</label>
            <input type="text" name="name_promotion" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Giá trị (%)</label>
            <input type="number" name="value" class="form-control" min="1" max="99" required>
        </div>
        <button type="submit" class="btn btn-primary">Tạo</button>
    </form>
</div>
@endsection
