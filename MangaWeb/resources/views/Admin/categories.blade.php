@extends('admin.main')
@section('content')
<div class="page-content" id="categories">
    <div class="content-section">
        <div class="section-header">
            <h2>Thể loại</h2>
            <button class="btn btn-primary" id="add-category-btn">Thêm thể loại mới</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên thể loại</th>
                    <th>Mô tả</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td>{{ $category -> id }}</td>
                    <td>{{ $category -> name }}</td>
                    <td style="max-width: 400px;">{{$category -> description}}</td>
                    <td class="actions">
                        <a href="{{ asset('admin/categories/edit/' . $category->id) }}"><button class="btn btn-primary btn-sm edit-category" id="update-category-btn">Sửa</button></a>
                        <button class="btn btn-danger btn-sm delete-category">Xóa</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('modal')
<!-- Add Category Modal -->
<div class="modal" id="add-category-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Thêm thể loại mới</h3>
            <span class="close">&times;</span>
        </div>
        <form action="/admin/categories/import" method="POST" id="add-category-form">
            <div class="form-group">
                <label for="category-name">Tên thể loại</label>
                <input type="text" class="form-control" id="category-name" name="name" required>
            </div>
            <div class="form-group">
                <label for="category-description">Mô tả</label>
                <textarea class="form-control" id="category-description" name="description"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger close-modal">Hủy</button>
                <button type="submit" class="btn btn-primary">Thêm</button>
            </div>
            @csrf
        </form>
    </div>
</div>  
<!-- Delete Confirmation Modal -->
<div class="modal" id="delete-confirm-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Xác nhận xóa</h3>
            <span class="close">&times;</span>
        </div>
        <p>Bạn có chắc chắn muốn xóa mục này không? Hành động này không thể hoàn tác.</p>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary close-modal">Hủy</button>
            <button type="button" class="btn btn-danger" id="confirm-delete">Xóa</button>
        </div>
    </div>
</div>
@endsection