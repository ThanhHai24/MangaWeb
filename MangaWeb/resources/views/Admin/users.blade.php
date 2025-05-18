@extends('admin.main')
@section('content')
<div class="page-content" id="categories">
    <div class="content-section">
        <div class="section-header">
            <h2>Tìm kiếm</h2>
        </div>
        <form action="{{ route('user-search') }}" method="GET" id="search-form">
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
<!-- Users Page -->
<div class="page-content" id="users">
                <div class="content-section">
                    <div class="section-header">
                        <h2>Quản lý người dùng</h2>
                        <button class="btn btn-primary" id="add-user-btn">Thêm người dùng mới</button>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Avatar</th>
                                <th>Tên người dùng</th>
                                <th>Email</th>
                                <th>Ngày đăng ký</th>
                                <th>Vai trò</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user )
                            <tr>
                                <td>{{ $user -> id }}</td>
                                <td>
                                    @if ($user -> avatar)
                                        <img src="{{$user->avatar }}" alt="Avatar" class="avatar">
                                    @else
                                        <img src="{{ asset('images/default-avatar.png') }}" alt="Default Avatar" class="avatar">
                                    @endif
                                </td>
                                <td>{{ $user -> username }}</td>
                                <td>{{ $user -> email }}</td>
                                <td>{{ $user -> created_at }}</td>
                                <td>{{ $user -> role }}</td>
                                <td>{{ $user -> status }}</td>
                                <td class="actions">
                                    <button class="btn btn-primary btn-sm edit-user">Sửa</button>
                                    <button class="btn btn-danger btn-sm delete-user">Xóa</button>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>

@endsection
@section('modal')
    <!-- Add User Modal -->
<div class="modal" id="add-user-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Thêm người dùng mới</h3>
                <span class="close">&times;</span>
            </div>
            <form action="/admin/users/add" method="POST" id="add-user-form">
                <div class="form-group">
                    <label for="user-name">Tên người dùng</label>
                    <input type="text" class="form-control" id="user-name" name="username" required>
                </div>
                <div class="form-group">
                    <label for="user-email">Email</label>
                    <input type="email" class="form-control" id="user-email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="user-password">Mật khẩu</label>
                    <input type="password" class="form-control" id="user-password" name="password" minlength="8" pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$" title="Mật khẩu phải có ít nhất 8 ký tự, bao gồm ít nhất 1 chữ hoa và 1 ký tự đặc biệt (!@#$%^&*)" required>
                </div>
                <div class="form-group">
                    <label for="user-role">Vai trò</label>
                    <select class="form-control" id="user-role" name="role">
                        <option value="admin">Admin</option>
                        <option value="moderator">Moderator</option>
                        <option value="user" selected>User</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="user-status">Trạng thái</label>
                    <select class="form-control" id="user-status" name="status">
                        <option value="Active" selected>Hoạt động</option>
                        <option value="Inactive">Không hoạt động</option>
                        <option value="Banned">Bị khóa</option>
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
    <!-- Edit User Modal -->
     <div class="modal" id="edit-user-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Sửa thông tin người dùng</h3>
                <span class="close">&times;</span>
            </div>
            <form action="" method="POST" id="edit-user-form">
                <div class="form-group">
                    <label for="edit-user-name">Tên người dùng</label>
                    <input type="text" class="form-control" id="edit-user-name" name="username" disabled>
                </div>
                <div class="form-group">
                    <label for="edit-user-email">Email</label>
                    <input type="email" class="form-control" id="edit-user-email" name="email" disabled>
                </div>
                <div class="form-group">
                    <label for="edit-user-password">Mật khẩu (để trống nếu không thay đổi)</label>
                    <input type="password" class="form-control" id="edit-user-password" name="password" minlength="8" pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$" title="Mật khẩu phải có ít nhất 8 ký tự, bao gồm ít nhất 1 chữ hoa và 1 ký tự đặc biệt (!@#$%^&*)">
                </div>
                <div class="form-group">
                    <label for="edit-user-role">Vai trò</label>
                    <select class="form-control" id="edit-user-role" name="role">
                        <option value="admin">Admin</option>
                        <option value="moderator">Moderator</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit-user-status">Trạng thái</label>
                    <select class="form-control" id="edit-user-status" name="status">
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Không hoạt động</option>
                        <option value="banned">Bị khóa</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger close-modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
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
                <button type="button" class="btn btn-danger" id="confirm-delete-user">Xóa</button>
            </div>
        </div>
    </div>  
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
    // Edit user button click handler
    $('.edit-user').on('click', function() {
        const userRow = $(this).closest('tr');
        const userId = userRow.find('td:first-child').text().trim();
        
        // Fetch user data via AJAX
        $.ajax({
            url: `/admin/users/${userId}/edit`,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const user = response.user;
                    
                    // Populate the edit form with user data
                    $('#edit-user-form').attr('action', `/admin/users/${userId}/update`);
                    $('#edit-user-name').val(user.username);
                    $('#edit-user-email').val(user.email);
                    $('#edit-user-password').val(''); // Clear password field
                    $('#edit-user-role').val(user.role);
                    $('#edit-user-status').val(user.status);
                    
                    // Open the edit user modal
                    openModal(document.getElementById('edit-user-modal'));
                } else {
                    alert('Không thể tải thông tin người dùng: ' + response.message);
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi khi tải thông tin người dùng.');
            }
        });
    });
    
    // Submit handler for edit user form
    $('#edit-user-form').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const userId = $(this).attr('action').split('/').pop();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Close the modal
                    closeModal(document.getElementById('edit-user-modal'));
                    
                    // Show success message
                    alert('Thông tin người dùng đã được cập nhật thành công!');
                    
                    // Reload the page to show updated user data
                    window.location.reload();
                } else {
                    alert('Không thể cập nhật thông tin người dùng: ' + response.message);
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi khi cập nhật thông tin người dùng.');
            }
        });
    });
    
    // Delete user button click handler
    $('.delete-user').on('click', function() {
        const userRow = $(this).closest('tr');
        const userId = userRow.find('td:first-child').text().trim();
        const userName = userRow.find('td:nth-child(3)').text().trim();
        
        // Store the user info in the confirm delete button's data attributes
        $('#confirm-delete-user').data('user-id', userId);
        $('#confirm-delete-user').data('user-row', userRow);
        
        // Update the delete confirmation message with the user name
        $('#delete-confirm-modal p').text(`Bạn có chắc chắn muốn xóa người dùng "${userName}" không? Hành động này không thể hoàn tác.`);
        
        // Show the delete confirmation modal
        openModal(document.getElementById('delete-confirm-modal'));
    });
    
    // Confirm delete button click handler
    $('#confirm-delete-user').on('click', function() {
        const userId = $(this).data('user-id');
        const userRow = $(this).data('user-row');
        
        if (!userId) return; // No user selected
        
        // Send delete request to server
        $.ajax({
            url: `/admin/users/${userId}/delete`,
            method: 'DELETE',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Remove the row from the table
                    userRow.remove();
                    
                    // Close the modal
                    closeModal(document.getElementById('delete-confirm-modal'));
                    
                    // Show success message
                    alert('Người dùng đã được xóa thành công!');
                } else {
                    alert('Không thể xóa người dùng: ' + response.message);
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi khi xóa người dùng.');
            }
        });
    });
});
</script>
@endsection