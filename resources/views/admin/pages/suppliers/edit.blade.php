@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Sửa nhà cung cấp</h2>
    <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Tên nhà cung cấp</label>
            <input type="text" name="name_supplier" class="form-control" value="{{ $supplier->name_supplier }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection
