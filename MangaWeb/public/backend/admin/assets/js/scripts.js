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
 
 // Delete buttons
 deleteMangaBtns.forEach(btn => {
     btn.addEventListener('click', function() {
         openModal(deleteConfirmModal);
         // Store reference to item to delete
         confirmDeleteBtn.dataset.deleteType = 'manga';
         confirmDeleteBtn.dataset.deleteId = this.closest('tr').querySelector('td:first-child').textContent;
     });
 });
 
 // Delete confirmation
 if (confirmDeleteBtn) {
     confirmDeleteBtn.addEventListener('click', function() {
         const deleteType = this.dataset.deleteType;
         const deleteId = this.dataset.deleteId;
         
         // Handle delete based on type
         if (deleteType === 'manga') {
             // Remove the row from the table (in real app, would call API)
             const row = document.querySelector(`#manga-list-table tr td:first-child:contains(${deleteId})`).closest('tr');
             if (row) {
                 row.remove();
             }
         }
         
         // Close the modal
         closeModal(deleteConfirmModal);
         
         // Show a success message (could use a toast notification)
         alert(`Đã xóa ${deleteType} với ID: ${deleteId}`);
     });
 }
 
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