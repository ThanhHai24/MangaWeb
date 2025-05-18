// Xử lý chức năng theo dõi/hủy theo dõi manga
$(document).ready(function() {
    // Xử lý nút theo dõi
    $('.btn-bookmark').on('click', function(e) {
        e.preventDefault();
        
        const mangaId = $(this).data('manga');
        const bookmarkBtn = $(this);
        
        $.ajax({
            url: '/bookmarks/toggle',
            type: 'POST',
            data: {
                manga_id: mangaId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Cập nhật nút theo trạng thái
                    if (response.bookmarked) {
                        bookmarkBtn.addClass('bookmarked');
                        bookmarkBtn.html('<i class="fas fa-bookmark"></i> Đã theo dõi');
                    } else {
                        bookmarkBtn.removeClass('bookmarked');
                        bookmarkBtn.html('<i class="far fa-bookmark"></i> Theo dõi');
                    }
                    
                    // Hiển thị thông báo
                    // showToast(response.message, 'success');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                
                if (xhr.status === 401) {
                    // Chuyển hướng đến trang đăng nhập
                    window.location.href = response.redirect;
                } else {
                    // Hiển thị lỗi
                    showToast(response.message || 'Đã xảy ra lỗi', 'error');
                }
            }
        });
    });
    
    // Hàm hiển thị thông báo
    function showToast(message, type = 'info') {
        // Kiểm tra xem đã có thư viện thông báo nào chưa
        if (typeof Toastify === 'function') {
            Toastify({
                text: message,
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: type === 'success' ? "#4CAF50" : type === 'error' ? "#F44336" : "#2196F3",
            }).showToast();
        } else {
            // Tạo thông báo đơn giản nếu không có thư viện
            alert(message);
        }
    }
});