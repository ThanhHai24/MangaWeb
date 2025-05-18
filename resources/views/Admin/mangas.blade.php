@extends ('Admin.main')
@section('admin-search')
<div class="page-content" id="categories">
    <div class="content-section">
        <div class="section-header">
            <h2>Tìm kiếm</h2>
        </div>
        <form action="{{ route('manga-search') }}" method="GET" id="search-form">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Nhập từ khóa tìm kiếm..." aria-label="Tìm kiếm" name="search" required>
                <button class="search-button" type="submit">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    Tìm kiếm
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('content')
<!-- Manga List Page -->
<div class="page-content" id="manga-list">
                <div class="content-section">
                    <div class="section-header">
                        <h2>Danh sách Manga</h2>
                        <button class="btn btn-primary" id="add-manga-btn">Thêm Manga mới</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ảnh bìa</th>
                                <th>Tên Manga</th>
                                <th>Tác giả</th>
                                <th>Năm xuất bản</th>
                                <th>Lượt xem</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="manga-list-table">
                            @foreach ($mangas as $manga)
                                <tr class="mangalist" href="/admin/mangas/{{ $manga->slug }}">
                                    <td>{{ $manga->id }}</td>
                                    <td><img src="{{ asset($manga->cover_image) }}" alt="Manga cover"></a></td>
                                    <td><a href="/admin/mangas/{{ $manga -> slug }}" style="color:black">{{ $manga->title }}</a></td>
                                    <td>{{ $manga->author }}</td>
                                    <td>{{ $manga->release_year }}</td>
                                    <td>{{ $manga->views }}</td>
                                    <td>{{ $manga->status }}</td>
                                    <td style="white-space: nowrap;">
                                        <button class="btn btn-primary btn-sm edit-manga" id="edit-manga-btn">Sửa</button>
                                        <button class="btn btn-danger btn-sm delete-manga">Xóa</button>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
@endsection
@section('modal')
<!-- Add Manga Modal -->
<div class="modal" id="add-manga-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Thêm Manga mới</h3>
            <span class="close">&times;</span>
        </div>
        <form action="{{ asset('admin/mangas/insert') }}" method="POST" id="add-manga-form">
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
                <input type="hidden" id="manga-cover-hidden" name="cover_image">
            </div>
            <div class="form-group">
                <label for="hot">Truyện HOT    <input type="checkbox" class="" id="hot" name="hot"></label>
            </div>
            <div class="form-group">
                <label for="manga-description">Mô tả</label>
                <textarea class="form-control" id="manga-description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="manga-categories">Thể loại</label>
                <select class="form-control select2-multiple" id="manga-categories" name="category[]" multiple>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ isset($manga) && $manga->categories->contains($category->id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="manga-status">Trạng thái</label>
                <select class="form-control" id="manga-status" name="status">
                    <option value="Đang Cập Nhật">Đang cập nhật</option>
                    <option value="Hoàn Thành">Hoàn thành</option>
                    <option value="Tạm Dừng">Tạm dừng</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger close-modal">Hủy</button>
                <button type="submit" class="btn btn-primary">Thêm</button>
            </div>
            @csrf
        </form>
    </div>
</div>
<!-- Edit Manga Modal -->
<div class="modal" id="edit-manga-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Sửa thông tin Manga</h3>
            <span class="close">&times;</span>
        </div>
        <form action="" method="POST" id="edit-manga-form">
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
                <input type="hidden" id="manga-cover-hidden" name="cover_image">
                <div class="current-cover mt-2">
                    <p>Ảnh bìa hiện tại:</p>
                    <img id="current-cover-preview" src="" alt="Cover image" style="max-width: 150px;">
                </div>
            </div>
            <div class="form-group">
                <label for="hot">Truyện HOT    <input type="checkbox" class="" id="hot" name="hot"></label>
            </div>
            <div class="form-group">
                <label for="manga-description">Mô tả</label>
                <textarea class="form-control" id="manga-description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="manga-categories">Thể loại</label>
                <select class="form-control select2-multiple" id="manga-categories" name="category[]" multiple>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="manga-status">Trạng thái</label>
                <select class="form-control" id="manga-status" name="status">
                    <option value="Đang Cập Nhật">Đang cập nhật</option>
                    <option value="Hoàn Thành">Hoàn thành</option>
                    <option value="Tạm Dừng">Tạm dừng</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger close-modal">Hủy</button>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </div>
            @csrf
            @method('PUT')
        </form>
    </div>
</div>>

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
            <button type="button" class="btn btn-danger" id="confirm-delete-manga">Xóa</button>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('backend\admin\assets\js\ajax.js') }}"></script>
@endsection