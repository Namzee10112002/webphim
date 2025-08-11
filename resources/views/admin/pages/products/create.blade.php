@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Tạo sản phẩm</h2>
    <form action="{{ route('admin.products.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Mã sản phẩm</label>
        <input type="text" name="code_product" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Tên sản phẩm</label>
        <input type="text" name="name_product" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Giá sản phẩm</label>
        <input type="number" name="price_product" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Đơn vị</label>
        <input type="text" name="unit" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Link ảnh sản phẩm</label>
        <input type="url" name="image_product" class="form-control" required>
    </div>
        <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <select name="category_id" class="form-select" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name_category }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nhà cung cấp</label>
            <select name="supplier_id" class="form-select" required>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name_supplier }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tạo</button>
    </form>
</div>
@endsection
