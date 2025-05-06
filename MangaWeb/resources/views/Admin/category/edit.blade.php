@extends('admin.main')
@section('content')
<div class="page-content" id="categories">
    <div class="content-section" id="edit-category-section">
        <div class="section-header">
            <h2>Sửa thể loại</h2>
        </div>
        <form action="{{ asset('admin/categories/update') }}" method="post">
            <input type="hidden" name="id" value="{{ $category->id }}">
            <div class="edit-form">
                <div class="form-group">
                    <label for="category-name">Tên thể loại</label>
                    <input type="text" id="category-name" class="form-control" placeholder="Nhập tên thể loại" name="name" value="{{ $category -> name }}">
                </div>
                <div class="form-group">
                    <label for="category-description">Mô tả</label>
                    <input type="text" id="category-description" class="form-control" placeholder="Nhập mô tả thể loại" name="description" value="{{ $category -> description }}">
                </div>
                <div class="form-actions">
                    <button class="btn btn-success" type="submit" id="save-category-btn">Lưu</button>
                    <button class="btn btn-secondary" id="cancel-edit-btn">Hủy</button>
                </div>
            </div>
            @csrf
        </form>
    </div>
</div>
@endsection
@section('modal')