@extends('admin.main')
@section('content')
<!-- Users Page -->
<div class="page-content" id="users">
                <div class="content-section">
                    <div class="section-header">
                        <h2>Quản lý người dùng</h2>
                        <button class="btn btn-primary" id="add-user-btn">Thêm người dùng mới</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên người dùng</th>
                                <th>Email</th>
                                <th>Ngày đăng ký</th>
                                <th>Vai trò</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>admin</td>
                                <td>admin@mangaweb.com</td>
                                <td>01/01/2024</td>
                                <td>Admin</td>
                                <td>Hoạt động</td>
                                <td class="actions">
                                    <button class="btn btn-primary btn-sm edit-user">Sửa</button>
                                    <button class="btn btn-danger btn-sm delete-user">Xóa</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>moderator1</td>
                                <td>mod1@mangaweb.com</td>
                                <td>15/02/2024</td>
                                <td>Moderator</td>
                                <td>Hoạt động</td>
                                <td class="actions">
                                    <button class="btn btn-primary btn-sm edit-user">Sửa</button>
                                    <button class="btn btn-danger btn-sm delete-user">Xóa</button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>user123</td>
                                <td>user123@gmail.com</td>
                                <td>20/03/2024</td>
                                <td>User</td>
                                <td>Hoạt động</td>
                                <td class="actions">
                                    <button class="btn btn-primary btn-sm edit-user">Sửa</button>
                                    <button class="btn btn-danger btn-sm delete-user">Xóa</button>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>mangafan456</td>
                                <td>mangafan456@yahoo.com</td>
                                <td>05/04/2024</td>
                                <td>User</td>
                                <td>Hoạt động</td>
                                <td class="actions">
                                    <button class="btn btn-primary btn-sm edit-user">Sửa</button>
                                    <button class="btn btn-danger btn-sm delete-user">Xóa</button>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>otakuworld</td>
                                <td>otakuworld@gmail.com</td>
                                <td>12/04/2024</td>
                                <td>User</td>
                                <td>Bị khóa</td>
                                <td class="actions">
                                    <button class="btn btn-primary btn-sm edit-user">Sửa</button>
                                    <button class="btn btn-danger btn-sm delete-user">Xóa</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
<!-- Add User Modal -->
<div class="modal" id="add-user-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Thêm người dùng mới</h3>
                <span class="close">&times;</span>
            </div>
            <form id="add-user-form">
                <div class="form-group">
                    <label for="user-name">Tên người dùng</label>
                    <input type="text" class="form-control" id="user-name" required>
                </div>
                <div class="form-group">
                    <label for="user-email">Email</label>
                    <input type="email" class="form-control" id="user-email" required>
                </div>
                <div class="form-group">
                    <label for="user-password">Mật khẩu</label>
                    <input type="password" class="form-control" id="user-password" required>
                </div>
                <div class="form-group">
                    <label for="user-role">Vai trò</label>
                    <select class="form-control" id="user-role">
                        <option value="admin">Admin</option>
                        <option value="moderator">Moderator</option>
                        <option value="user" selected>User</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="user-status">Trạng thái</label>
                    <select class="form-control" id="user-status">
                        <option value="active" selected>Hoạt động</option>
                        <option value="inactive">Không hoạt động</option>
                        <option value="banned">Bị khóa</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger close-modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
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