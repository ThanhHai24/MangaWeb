@extends('admin.main')
@section('content')
<div class="page-content" id="chapters">
    <div class="content-section">
        <div class="section-header">
            <h2>Quản lý Chapter</h2>
            <button class="btn btn-primary" id="add-chapter-btn">Thêm Chapter mới</button>
        </div>
        <div class="form-group">
            <label for="manga-select">Manga</label>
            <input class="form-control" id="manga-select" value="{{ $manga->title }}" readonly>
            </input>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Chapter</th>
                    <th>Tiêu đề</th>
                    <th>Ngày đăng</th>
                    <th>Lượt xem</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="chapter-list-table">
                @foreach ($chapters as $chapter )
                    <tr>
                        <td>{{ $chapter -> chapter_number }}</td>
                        <td>{{ $chapter -> title }}</td>
                        <td>{{ $chapter -> created_at }}</td>
                        <td>{{ $chapter -> views }}</td>
                        <td class="actions">
                            <button class="btn btn-primary btn-sm edit-chapter" data-id="{{ $chapter -> id }}">Sửa</button>
                            <button class="btn btn-danger btn-sm delete-chapter" data-id="{{ $chapter -> id }}">Xóa</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('modal')
<!-- Add Chapter Modal -->
<div class="modal" id="add-chapter-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Thêm Chapter mới</h3>
                <span class="close">&times;</span>
            </div>
            <form action="/admin/mangas/{{ $manga -> slug }}" method="POST" enctype="multipart/form-data" id="add-chapter-form">
                <input type="hidden" name="manga_id" value="{{ $manga->id }}">
                <div class="form-group">
                    <label for="chapter-manga">Manga</label>
                    <input class="form-control" id="manga-select" value="{{ $manga->title }}" readonly>
                </div>
                <div class="form-group">
                    <label for="chapter-number">Số Chapter</label>
                    <input type="text" name="chapter_number" class="form-control" id="chapter-number" required>
                </div>
                <div class="form-group">
                    <label for="chapter-title">Tiêu đề Chapter</label>
                    <input type="text" name="title" class="form-control" id="chapter-title">
                </div>
                <div class="form-group">
                    <label for="chapter-images">Tải lên ảnh</label>
                    <input type="file" class="form-control" id="chapter-images" multiple>
                    <div id="input-file-imgs"></div>
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
                <button type="button" class="btn btn-danger" id="confirm-delete-chapter">Xóa</button>
            </div>
        </div>
    </div>
<!-- Edit Chapter Modal -->
<div class="modal" id="edit-chapter-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Sửa Chapter</h3>
            <span class="close">&times;</span>
        </div>
        <form method="POST" enctype="multipart/form-data" id="edit-chapter-form">
            @method('PUT')
            <input type="hidden" name="manga_id" value="{{ $manga->id }}">
            <input type="hidden" name="chapter_id" id="edit-chapter-id">
            <div class="form-group">
                <label for="edit-manga-select">Manga</label>
                <input class="form-control" id="edit-manga-select" value="{{ $manga->title }}" readonly>
            </div>
            <div class="form-group">
                <label for="edit-chapter-number">Số Chapter</label>
                <input type="text" name="chapter_number" class="form-control" id="edit-chapter-number" required>
            </div>
            <div class="form-group">
                <label for="edit-chapter-title">Tiêu đề Chapter</label>
                <input type="text" name="title" class="form-control" id="edit-chapter-title">
            </div>
            <div class="form-group">
                <label for="edit-chapter-images">Thay đổi ảnh (để trống nếu không thay đổi)</label>
                <input type="file" class="form-control" id="edit-chapter-images" multiple>
                <div id="edit-input-file-imgs"></div>
                <div id="current-images-preview" class="mt-2">
                    <p>Ảnh hiện tại:</p>
                    <div id="current-images-container" class="d-flex flex-wrap"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger close-modal">Hủy</button>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </div>
            @csrf
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('backend\admin\assets\js\ajax.js') }}"></script>
@endsection