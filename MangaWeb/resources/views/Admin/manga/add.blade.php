@extends ('Admin.main')
@section('content')
<!-- Manga List Page -->
<div class="page-content" id="manga-list">
<div class="content-section">
    <div class="section-header">
        <h3>Thông tin Manga</h3>
    </div>
    
    <form action="" method="" id="add-manga-form">
        <div class="form-group">
            <label for="manga-title">Tên Manga</label>
            <input type="text" class="form-control" id="manga-title" name="title" required>
        </div>
        <div class="form-group">
            <label for="manga-author">Tác giả</label>
            <input type="text" class="form-control" id="manga-author" name="author" required>
        </div>
        <div class="form-group">
            <label for="manga-cover">Ảnh bìa</label>
            <input type="file" class="form-control" id="manga-cover" name="image" accept="image/*">
        </div>
        <div class="form-group">
            <label for="manga-release-year">Năm xuất bản</label>
            <input type="number" class="form-control" id="manga-release-year" name="release_year">
        </div>
        <div class="form-group">
            <label for="manga-description">Mô tả</label>
            <textarea class="form-control" id="manga-description" name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="manga-categories">Thể loại</label>
            <select class="form-control" id="manga-categories" name="category[]" multiple>
                <!-- Đây là placeholder cho các thể loại -->
                <option value="1">Action</option>
                <option value="2">Adventure</option>
                <option value="3">Comedy</option>
                <option value="4">Drama</option>
                <option value="5">Fantasy</option>
                <option value="6">Horror</option>
                <option value="7">Romance</option>
                <option value="8">Sci-Fi</option>
                <option value="9">Slice of Life</option>
                <option value="10">Sports</option>
            </select>
        </div>
        <div class="form-group">
            <label for="manga-status">Trạng thái</label>
            <select class="form-control" id="manga-status" name="status">
                <option value="ongoing">Đang cập nhật</option>
                <option value="completed">Hoàn thành</option>
                <option value="dropped">Tạm dừng</option>
            </select>
        </div>
        <div class="form-footer">
            <a href="/admin/mangas" class="btn btn-danger">Hủy</a>
            <button type="submit" class="btn btn-primary">Thêm mới</button>
        </div>
    </form>
        </div>
</div>
@endsection

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
@section('scripts')
    
@endsection