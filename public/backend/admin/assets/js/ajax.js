$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#manga-cover').on('change',()=>{
    var formData = new FormData();
    var file = $('#manga-cover')[0].files[0]
    formData.append('file',file)
    $.ajax({
        url : '/upload',
        processData: false,//illega invocation
        dataType: 'json',
        data: formData,
        method: 'POST',
        contentType: false,// khong hien o preview
        success: function(result){
            if(result.success == true)
            {
                // html = '';
                // html+= '<img src="'+result.path+'" alt="">';
                // $('#input-file-img').html(html)
                $('#manga-cover-hidden').val(result.path)
            }
        }
    })
})

$('#chapter-images').on('change',()=>{
    var formData = new FormData()
    var files = $('#chapter-images')[0].files
    for (let index = 0; index < files.length; index++) {
        formData.append('files[]',files[index])
    }
    $.ajax({
        url:'/uploads',
        method: 'POST',
        dataType: 'JSON',
        data: formData,
        contentType: false,
        processData: false,
        success:function(result){
            if(result.success === true)
            {
                let html = '';
                for (let index = 0; index < result.paths.length; index++) {
                    html += '<input type="hidden" value="'+result.paths[index]+'" class="product-images" name="images[]">';
                }
                // Thêm vào thay vì ghi đè
                $('#input-file-imgs').append(html);
                
                // Tùy chọn: hiển thị số lượng ảnh đã upload
                console.log('Tổng số ảnh đã upload: ' + $('.product-images').length);
            }
        }
    })
})

$('#edit-manga-form #manga-cover').on('change', function() {
    var formData = new FormData();
    var file = $(this)[0].files[0];
    formData.append('file', file);
    
    $.ajax({
        url: '/upload',
        processData: false,
        dataType: 'json',
        data: formData,
        method: 'POST',
        contentType: false,
        success: function(result) {
            if(result.success == true) {
                $('#edit-manga-form #manga-cover-hidden').val(result.path);
                $('#current-cover-preview').attr('src', result.path);
            }
        }
    });
});

// Update the current cover preview when loading manga data
function updateCoverPreview(imagePath) {
    if (imagePath) {
        $('#current-cover-preview').attr('src', imagePath);
    }
}

$(document).ready(function() {
    // Edit manga button click handler (existing code)
    $('.edit-manga').on('click', function() {
        const mangaId = $(this).closest('tr').find('td:first-child').text().trim();
        const mangaSlug = $(this).closest('tr').attr('href').split('/').pop();
        
        // Fetch manga data via AJAX
        $.ajax({
            url: '/admin/mangas/' + mangaSlug + '/edit',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const manga = response.manga;

                    // Populate form fields with manga data
                    $('#edit-manga-form').attr('action', '/admin/mangas/' + mangaSlug + '/update');
                    $('#edit-manga-form #manga-title').val(manga.title);
                    $('#edit-manga-form #manga-author').val(manga.author);
                    $('#edit-manga-form #manga-cover-hidden').val(manga.cover_image);
                    $('#edit-manga-form #current-cover-preview').attr('src', manga.cover_image);
                    $('#edit-manga-form #manga-description').val(manga.description);
                    $('#edit-manga-form #manga-status').val(manga.status);
                    
                    // Clear and update selected categories
                    $('#edit-manga-form #manga-categories').val(null).trigger('change');
                    if (manga.categories && manga.categories.length > 0) {
                        const categoryIds = manga.categories.map(category => category.id);
                        $('#edit-manga-form #manga-categories').val(categoryIds).trigger('change');
                    }
                    
                    // Update button text
                    $('#edit-manga-form .btn-primary').text('Cập nhật');
                    
                    // Open the modal
                    openModal(document.getElementById('edit-manga-modal'));
                } else {
                    alert('Không thể tải thông tin manga.');
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi khi tải thông tin manga.');
            }
        });
    });
    
    // Delete manga button click handler
    $('.delete-manga').on('click', function(e) {
        e.stopPropagation();
        const mangaRow = $(this).closest('tr');
        const mangaId = mangaRow.find('td:first-child').text().trim();
        const mangaSlug = mangaRow.attr('href').split('/').pop();
        const mangaTitle = mangaRow.find('td:nth-child(3)').text().trim();
        
        // Store the manga info in the confirm delete button's data attributes
        $('#confirm-delete-manga').data('manga-id', mangaId);
        $('#confirm-delete-manga').data('manga-slug', mangaSlug);
        $('#confirm-delete-manga').data('manga-row', mangaRow);
        
        // Update the delete confirmation message with the manga title
        $('#delete-confirm-modal p').text(`Bạn có chắc chắn muốn xóa manga "${mangaTitle}" không? Hành động này không thể hoàn tác.`);
        
        // Show the delete confirmation modal
        openModal(document.getElementById('delete-confirm-modal'));
    });
    
    // Confirm delete button click handler
    $('#confirm-delete-manga').on('click', function() {
        const mangaSlug = $(this).data('manga-slug');
        const mangaRow = $(this).data('manga-row');
        
        // Send delete request to server
        $.ajax({
            url: '/admin/mangas/' + mangaSlug + '/delete',
            method: 'DELETE',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Remove the row from the table
                    mangaRow.remove();
                    
                    // Close the modal
                    closeModal(document.getElementById('delete-confirm-modal'));
                    
                    // Show success message
                    alert('Manga đã được xóa thành công!');
                } else {
                    alert('Không thể xóa manga: ' + response.message);
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi khi xóa manga.');
            }
        });
    });
});
