@extends('admin.main')
@section('content')
<div class="page-content" id="comments">
                <div class="content-section">
                    <div class="section-header">
                        <h2>Quản lý bình luận</h2>
                    </div>
                    <div class="form-group">
                        <label for="comment-filter">Lọc theo trạng thái</label>
                        <select class="form-control" id="comment-filter">
                            <option value="all">Tất cả</option>
                            <option value="approved">Đã duyệt</option>
                            <option value="pending">Chờ duyệt</option>
                            <option value="spam">Spam</option>
                        </select>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Người dùng</th>
                                <th>Manga</th>
                                <th>Chapter</th>
                                <th>Nội dung</th>
                                <th>Ngày đăng</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>user123</td>
                                <td>One Piece</td>
                                <td>Chapter 1088</td>
                                <td>Chapter này quá hay! Không thể đợi đến chapter tiếp theo...</td>
                                <td>12/04/2025</td>
                                <td>Đã duyệt</td>
                                <td class="actions">
                                    <button class="btn btn-primary btn-sm">Duyệt</button>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>mangafan456</td>
                                <td>Naruto</td>
                                <td>Chapter 700</td>
                                <td>Kết thúc thật xúc động!</td>
                                <td>11/04/2025</td>
                                <td>Đã duyệt</td>
                                <td class="actions">
                                    <button class="btn btn-primary btn-sm">Duyệt</button>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>otakuworld</td>
                                <td>Bleach</td>
                                <td>Chapter 686</td>
                                <td>Tôi nghĩ rằng kết thúc này chưa thực sự hoàn thiện...</td>
                                <td>10/04/2025</td>
                                <td>Chờ duyệt</td>
                                <td class="actions">
                                    <button class="btn btn-primary btn-sm">Duyệt</button>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>newreader</td>
                                <td>Attack on Titan</td>
                                <td>Chapter 139</td>
                                <td>Truyện này gây sốc quá! Tôi không ngờ lại kết thúc như vậy...</td>
                                <td>09/04/2025</td>
                                <td>Chờ duyệt</td>
                                <td class="actions">
                                    <button class="btn btn-primary btn-sm">Duyệt</button>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>animegeek</td>
                                <td>My Hero Academia</td>
                                <td>Chapter 425</td>
                                <td>Nhân vật chính thật tuyệt vời!</td>
                                <td>08/04/2025</td>
                                <td>Spam</td>
                                <td class="actions">
                                    <button class="btn btn-primary btn-sm">Duyệt</button>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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