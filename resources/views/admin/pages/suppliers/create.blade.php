@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Tạo nhà cung cấp</h2>
    <form action="{{ route('admin.suppliers.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Tên nhà cung cấp</label>
            <input type="text" name="name_supplier" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Tạo</button>
    </form>
</div>
@endsection
