<div class="sidebar">
    <div class="sidebar-header">
        <h3>Manga Admin</h3>
        <p>Quản lý nội dung</p>
    </div>
    <div class="sidebar-menu">
        <ul>
        <ul>
    <a href="/admin">
        <li class="menu-item {{ Request::is('admin') ? 'active' : '' }}" data-page="dashboard">Dashboard</li>
    </a>
    <a href="/admin/mangas">
        <li class="menu-item {{ Request::is('admin/mangas*') ? 'active' : '' }}" data-page="manga-list">Danh sách Manga</li>
    </a>
    <a href="/admin/categories">
        <li class="menu-item {{ Request::is('admin/categories*') ? 'active' : '' }}" data-page="categories">Thể loại</li>
    </a>
    <a href="/admin/users">
        <li class="menu-item {{ Request::is('admin/users*') ? 'active' : '' }}" data-page="users">Người dùng</li>
    </a>
    <a href="/admin/comments">
        <li class="menu-item {{ Request::is('admin/comments*') ? 'active' : '' }}" data-page="comments">Bình luận</li>
    </a>
    
</ul>
        </ul>
    </div>
</div>