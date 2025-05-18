<div class="container">
  <div class="header-top">
    <div class="logo">
      <a href="/"><h1>PTIT<span>Manga</span></h1></a>
    </div>
    <div class="search-bar">
      <form action="{{ route('search') }}" method="GET">
        @csrf
        <input type="text" name="search" placeholder="Tìm kiếm truyện..." required>
        <button style="display:none" type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div>  
    <div class="user-actions">
      @auth
        <div class="dropdown-container-account" id="accountDropdown">
          <div class="user-avatar-account">
            <img src="{{ Auth::user()->avatar ?? 'storage\avatars\images.png' }}" alt="Avatar">
            <span class="username-account">Tài khoản</span>
            <i class="ri-arrow-down-s-fill dropdown-arrow-account"></i>
          </div>
          <div class="dropdown-account">
            <div class="dropdown-content-account">
              <a href="/profile"><i class="fa fa-user"></i> Thông tin tài khoản</a>
              <a href="/change-password"><i class="fa fa-key"></i> Đổi mật khẩu</a>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-button-account"><i class="fa fa-sign-out"></i> Đăng xuất</button>
              </form>
            </div>
          </div>
        </div>
      @else
        <a href="/login">Đăng nhập</a>
        <a href="/register">Đăng ký</a>
      @endauth
    </div>
  </div>
</div>

<nav class="main-nav">
  <div class="container">
    <ul>
      <li><a href="/">Trang chủ</a></li>
      <li class="dropdown-container">
        <a href="#">Thể loại</a>
        <div class="dropdown">
          <div class="dropdown-content">
            @foreach ($categories as $category)
            <a href="/the-loai/{{ $category -> slug }}">{{ $category -> name }}</a>
            @endforeach
          </div>
        </div>
      </li>
      <li><a href="/hot">Truyện Hot</a></li>
      <li><a href="/newest">Truyện Mới</a></li>
      <li><a href="/finished">Hoàn Thành</a></li>
      <li><a href="/bookmarks">Đang theo dõi</a></li>
    </ul>
  </div>
</nav>