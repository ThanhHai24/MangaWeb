@extends('admin.main')
@section('content')
<div class="page-content" id="comments">
                <div class="content-section">
                    <div class="section-header">
                        <h2>Quản lý bình luận</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID Người dùng</th>
                                <th>Loại</th>
                                <th>Vị trí</th>
                                <th>Nội dung</th>
                                <th>Ngày đăng</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comments as $comment)
                                <tr>
                                <td>{{ $comment -> id }}</td>
                                <td>{{ $comment -> user_id }}</td>
                                <td>{{ $comment -> commentable_type }}</td>
                                <td>{{ $comment -> commentable_id }}</td>
                                <td>{{ $comment -> content }}</td>
                                <td>{{ $comment -> created_at }}</td>
                                <td class="actions">
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </td>
                            </tr>
                            @endforeach
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