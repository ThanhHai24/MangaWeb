$(document).ready(function() {
    // Xử lý nút Reply
    $(document).on('click', '.btn-reply', function() {
        const commentId = $(this).data('id');
        const username = $(this).data('username');
        // Cập nhật form
        $('#parent_id').val(commentId);
        $('#replyToUsername').text(username);
        $('#replyInfo').removeClass('d-none');
        
        // Cuộn đến form comment
        $('html, body').animate({
            scrollTop: $("#commentForm").offset().top - 100
        }, 500);
        
        // Focus vào textarea
        $('.comment-input').focus();
    });
    
    // Hủy Reply
    $(document).on('click', '.btn-cancel-reply', function() {
        $('#parent_id').val('');
        $('#replyInfo').addClass('d-none');
    });
    
    // Xử lý Ajax submission cho form comment (tùy chọn)
    $('#commentForm').submit(function(e) {
        e.preventDefault();
        
        const form = $(this);
        const url = form.attr('action');
        
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    // Reload trang để hiển thị comment mới
                    // Hoặc thêm comment vào DOM nếu muốn không reload trang
                    location.reload();
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert('Có lỗi xảy ra khi gửi bình luận');
            }
        });
    });
});