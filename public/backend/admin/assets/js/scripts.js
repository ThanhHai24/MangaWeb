 // DOM Elements
 const menuItems = document.querySelectorAll('.menu-item');
 const pageContents = document.querySelectorAll('.page-content');
 const addMangaBtn = document.getElementById('add-manga-btn');
 const addChapterBtn = document.getElementById('add-chapter-btn');
 const addCategoryBtn = document.getElementById('add-category-btn');
 const addUserBtn = document.getElementById('add-user-btn');
 
 const addMangaModal = document.getElementById('add-manga-modal');
 const addChapterModal = document.getElementById('add-chapter-modal');
 const addCategoryModal = document.getElementById('add-category-modal');
 const addUserModal = document.getElementById('add-user-modal');
 const deleteConfirmModal = document.getElementById('delete-confirm-modal');
 const UpdateCategoryModal = document.getElementById('update-category-modal')
 
 const closeBtns = document.querySelectorAll('.close, .close-modal');
 const editMangaBtns = document.querySelectorAll('.edit-manga');
 const deleteMangaBtns = document.querySelectorAll('.delete-manga');
 const confirmDeleteBtn = document.getElementById('confirm-delete');
 
 const mangaSelect = document.getElementById('manga-select');
 const chapterListTable = document.getElementById('chapter-list-table');
 const commentFilter = document.getElementById('comment-filter');
 const settingsForm = document.getElementById('settings-form');
 
 // Page Navigation
 menuItems.forEach(item => {
     item.addEventListener('click', function() {
         // Remove active class from all menu items
         menuItems.forEach(i => i.classList.remove('active'));
         // Add active class to clicked menu item
         this.classList.add('active');
         
        //  // Hide all page contents
        //  pageContents.forEach(page => page.classList.remove('active'));
         
        //  // Show the corresponding page content
        //  const pageId = this.getAttribute('data-page');
        //  document.getElementById(pageId).classList.add('active');
     });
 });
 
 // Modal Functions
 function openModal(modal) {
     modal.style.display = 'flex';
     $(modal).find('.select2-multiple').select2({
        placeholder: "Chọn thể loại",
        allowClear: true,
        width: '100%'
    });
 }
 
 function closeModal(modal) {
     modal.style.display = 'none';
 }
 
 // Close buttons for modals
 closeBtns.forEach(btn => {
     btn.addEventListener('click', function() {
         const modal = this.closest('.modal');
         closeModal(modal);
     });
 });
 
 // Close modal when clicking outside
 window.addEventListener('click', function(event) {
     const modals = document.querySelectorAll('.modal');
     modals.forEach(modal => {
         if (event.target === modal) {
             closeModal(modal);
         }
     });
 });
 
 // Open modals
 if (addMangaBtn) {
     addMangaBtn.addEventListener('click', function() {
         openModal(addMangaModal);
     });
 }
 
 if (addChapterBtn) {
     addChapterBtn.addEventListener('click', function() {
         openModal(addChapterModal);
     });
 }
 
 if (addCategoryBtn) {
     addCategoryBtn.addEventListener('click', function() {
         openModal(addCategoryModal);
     });
 }
 if (addUserBtn) {
     addUserBtn.addEventListener('click', function() {
         openModal(addUserModal);
     });
 }
 
//  // Delete buttons
//  deleteMangaBtns.forEach(btn => {
//      btn.addEventListener('click', function() {
//          openModal(deleteConfirmModal);
//          // Store reference to item to delete
//          confirmDeleteBtn.dataset.deleteType = 'manga';
//          confirmDeleteBtn.dataset.deleteId = this.closest('tr').querySelector('td:first-child').textContent;
//      });
//  });
 
//  // Delete confirmation
//  if (confirmDeleteBtn) {
//      confirmDeleteBtn.addEventListener('click', function() {
//          const deleteType = this.dataset.deleteType;
//          const deleteId = this.dataset.deleteId;
         
//          // Handle delete based on type
//          if (deleteType === 'manga') {
//              // Remove the row from the table (in real app, would call API)
//              const row = document.querySelector(`#manga-list-table tr td:first-child:contains(${deleteId})`).closest('tr');
//              if (row) {
//                  row.remove();
//              }
//          }
         
//          // Close the modal
//          closeModal(deleteConfirmModal);
         
//          // Show a success message (could use a toast notification)
//          alert(`Đã xóa ${deleteType} với ID: ${deleteId}`);
//      });
//  }
 
 // Comment filter
 if (commentFilter) {
     commentFilter.addEventListener('change', function() {
         // In a real app, this would filter comments
         alert(`Filter changed to: ${this.options[this.selectedIndex].text}`);
     });
 }
 
 // Settings form
 if (settingsForm) {
     settingsForm.addEventListener('submit', function(e) {
         e.preventDefault();
         // In a real app, this would save settings
         alert('Đã lưu cài đặt thành công!');
     });
 }

 // Small polyfill for the :contains selector used in the delete confirmation
 if (!Element.prototype.matches) {
     Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector;
 }

 if (!Element.prototype.closest) {
     Element.prototype.closest = function(s) {
         var el = this;
         do {
             if (el.matches(s)) return el;
             el = el.parentElement || el.parentNode;
         } while (el !== null && el.nodeType === 1);
         return null;
     };
 }



$(document).ready(function() {
    // Delete category button click handler
    $('.delete-category').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const categoryRow = $(this).closest('tr');
        const categoryId = categoryRow.find('td:first-child').text().trim();
        const categoryName = categoryRow.find('td:nth-child(2)').text().trim();
        
        // Store the category info in the confirm delete button's data attributes
        $('#confirm-delete').data('category-id', categoryId);
        $('#confirm-delete').data('category-row', categoryRow);
        
        // Update the delete confirmation message with the category name
        $('#delete-confirm-modal p').text(`Bạn có chắc chắn muốn xóa thể loại "${categoryName}" không? Hành động này không thể hoàn tác và sẽ xóa thể loại này khỏi tất cả truyện.`);
        
        // Show the delete confirmation modal
        openModal(document.getElementById('delete-confirm-modal'));
    });
    
    // Confirm delete button click handler
    $('#confirm-delete').on('click', function() {
        const categoryId = $(this).data('category-id');
        const categoryRow = $(this).data('category-row');
        
        // Send delete request to server
        $.ajax({
            url: '/admin/categories/delete/' + categoryId,
            method: 'DELETE',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Remove the row from the table
                    categoryRow.remove();
                    
                    // Close the modal
                    closeModal(document.getElementById('delete-confirm-modal'));
                    
                    // Show success message
                    alert('Thể loại đã được xóa thành công!');
                } else {
                    alert('Không thể xóa thể loại: ' + response.message);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Đã xảy ra lỗi khi xóa thể loại.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert(errorMessage);
            }
        });
    });
});

// chapter
$(document).ready(function() {
    // Edit chapter button click handler
    $(document).on('click', '.edit-chapter', function() {
        const chapterRow = $(this).closest('tr');
        const chapterId = $(this).data('id');
        const chapterNumber = chapterRow.find('td:nth-child(1)').text().trim();
        const chapterTitle = chapterRow.find('td:nth-child(2)').text().trim();
        const mangaSlug = window.location.pathname.split('/').pop();
        
        // Populate the edit form with chapter data
        $('#edit-chapter-id').val(chapterId);
        $('#edit-chapter-number').val(chapterNumber);
        $('#edit-chapter-title').val(chapterTitle);
        
        // Set the form action
        $('#edit-chapter-form').attr('action', `/admin/chapters/${chapterId}/update`);
        
        // Fetch and display current images if available
        $.ajax({
            url: `/admin/chapters/${chapterId}/images`,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                const imagesContainer = $('#current-images-container');
                imagesContainer.empty();
                
                if (response.images && response.images.length > 0) {
                    response.images.forEach((image, index) => {
                        const imgElement = $('<div class="image-preview mr-2 mb-2"></div>')
                            .append(`<img src="${image}" alt="Chapter image ${index+1}" style="height: 100px; width: auto; margin: 5px;">`)
                            .append(`<button type="button" class="btn btn-sm btn-danger remove-image" data-image="${image}">Remove</button>`);
                        imagesContainer.append(imgElement);
                    });
                } else {
                    imagesContainer.append('<p>No images available</p>');
                }
            },
            error: function() {
                $('#current-images-container').html('<p>Failed to load current images</p>');
            }
        });
        
        // Open the edit chapter modal
        openModal(document.getElementById('edit-chapter-modal'));
    });
    
    // Delete chapter button click handler
    $(document).on('click', '.delete-chapter', function() {
        const chapterRow = $(this).closest('tr');
        const chapterId = $(this).data('id');
        const chapterNumber = chapterRow.find('td:nth-child(1)').text().trim();
        
        // Store chapter info in delete confirmation modal
        $('#confirm-delete-chapter').data('chapter-id', chapterId);
        $('#confirm-delete-chapter').data('chapter-row', chapterRow);
        
        // Update confirmation message
        $('#delete-confirm-modal p').text(`Bạn có chắc chắn muốn xóa chapter "${chapterNumber}" không? Hành động này không thể hoàn tác.`);
        
        // Open the delete confirmation modal
        openModal(document.getElementById('delete-confirm-modal'));
    });
    
    // Confirm delete button for chapter
    $('#confirm-delete-chapter').on('click', function() {
        const chapterId = $(this).data('chapter-id');
        const chapterRow = $(this).data('chapter-row');
        
        if (!chapterId) return; // No chapter selected
        
        // Send delete request
        $.ajax({
            url: `/admin/chapters/${chapterId}/delete`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Remove row from table
                    chapterRow.remove();
                    closeModal(document.getElementById('delete-confirm-modal'));
                    alert('Chapter đã được xóa thành công!');
                } else {
                    alert('Không thể xóa chapter: ' + response.message);
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi khi xóa chapter.');
            }
        });
    });
    
    // Handle removing individual images in edit mode
    $(document).on('click', '.remove-image', function() {
        const imageUrl = $(this).data('image');
        const imageContainer = $(this).closest('.image-preview');
        
        if (confirm('Bạn có chắc chắn muốn xóa ảnh này?')) {
            const chapterId = $('#edit-chapter-id').val();
            
            $.ajax({
                url: `/admin/chapters/${chapterId}/remove-image`,
                method: 'POST',
                data: { image_url: imageUrl },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        imageContainer.remove();
                    } else {
                        alert('Không thể xóa ảnh: ' + response.message);
                    }
                },
                error: function() {
                    alert('Đã xảy ra lỗi khi xóa ảnh.');
                }
            });
        }
    });
    
    // Handle file uploads in edit form similar to add form
    $('#edit-chapter-images').on('change', function() {
        // Similar handling as your existing file upload code
        // (Implement similar to your existing add chapter form)
    });
    
    // Submit handler for edit chapter form
    $('#edit-chapter-form').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const chapterId = $('#edit-chapter-id').val();
        
        // Add images if any selected
        const fileInput = document.getElementById('edit-chapter-images');
        if (fileInput.files.length > 0) {
            for (let i = 0; i < fileInput.files.length; i++) {
                formData.append('images[]', fileInput.files[i]);
            }
        }
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Update the table row
                    const updatedRow = response.chapter;
                    const rowToUpdate = $(`tr:has(button.edit-chapter[data-id="${chapterId}"])`);
                    
                    rowToUpdate.find('td:nth-child(1)').text(updatedRow.chapter_number);
                    rowToUpdate.find('td:nth-child(2)').text(updatedRow.title);
                    
                    // Close modal and show success message
                    closeModal(document.getElementById('edit-chapter-modal'));
                    alert('Chapter đã được cập nhật thành công!');
                    
                    // Optional: Reload the page to ensure everything is updated
                    // window.location.reload();
                } else {
                    alert('Không thể cập nhật chapter: ' + response.message);
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi khi cập nhật chapter.');
            }
        });
    });
});


