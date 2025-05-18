@extends('admin.main')
@section('content')
<div class="page-content" id="settings">
                <div class="content-section">
                    <div class="section-header">
                        <h2>Cài đặt hệ thống</h2>
                    </div>
                    <form id="settings-form">
                        <div class="form-group">
                            <label for="site-name">Tên trang web</label>
                            <input type="text" class="form-control" id="site-name" value="Manga Web">
                        </div>
                        <div class="form-group">
                            <label for="site-description">Mô tả trang web</label>
                            <textarea class="form-control" id="site-description">Trang web đọc truyện manga online lớn nhất Việt Nam</textarea>
                        </div>
                        <div class="form-group">
                            <label for="items-per-page">Số truyện hiển thị trên mỗi trang</label>
                            <input type="number" class="form-control" id="items-per-page" value="20">
                        </div>
                        <div class="form-group">
                            <label for="allow-comments">Cho phép bình luận</label>
                            <select class="form-control" id="allow-comments">
                                <option value="1" selected>Có</option>
                                <option value="0">Không</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="auto-approve-comments">Tự động duyệt bình luận</label>
                            <select class="form-control" id="auto-approve-comments">
                                <option value="1">Có</option>
                                <option value="0" selected>Không</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="maintenance-mode">Chế độ bảo trì</label>
                            <select class="form-control" id="maintenance-mode">
                                <option value="1">Bật</option>
                                <option value="0" selected>Tắt</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu cài đặt</button>
                    </form>
                </div>
            </div>
@endsection
@section('modal')
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