@extends('admin.layout')

@section('content')
    <div class="container">
        <h2>Sửa sản phẩm</h2>
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Mã sản phẩm</label>
                <input type="text" name="code_product" class="form-control" value="{{ $product->code_product }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tên sản phẩm</label>
                <input type="text" name="name_product" class="form-control" value="{{ $product->name_product }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Giá sản phẩm</label>
                <input type="number" name="price_product" class="form-control" value="{{ $product->price }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control">{{ $product->description }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Đơn vị</label>
                <input type="text" name="unit" class="form-control" value="{{ $product->unit }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Link ảnh sản phẩm</label>
                <input type="url" name="image_product" class="form-control" value="{{ $product->image_product }}" required>
                <img src="{{ $product->image_product }}" alt="" width="20%">
            </div>
            <div class="mb-3">
                <label class="form-label">Danh mục</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name_category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nhà cung cấp</label>
                <select name="supplier_id" class="form-select" required>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name_supplier }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Số lượng nhập thêm</label>
                <input type="number" name="quantity_import" class="form-control" min="0"
                    placeholder="Nhập số lượng nếu có nhập thêm">
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
    <hr>
    <h4>Lịch sử nhập hàng</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Số lượng</th>
                <th>Ngày nhập</th>
                <th>Người nhập</th>
            </tr>
        </thead>
        <tbody>
            @foreach($product->importProducts as $import)
                <tr>
                    <td>{{ $import->quantity }}</td>
                    <td>{{ $import->date_import }}</td>
                    <td>{{ $import->user->name ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection