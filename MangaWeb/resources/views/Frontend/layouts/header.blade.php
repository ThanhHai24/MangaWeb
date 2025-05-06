<div class="container">
  <div class="header-top">
    <div class="logo">
      <a href="/"><h1>PTIT<span>COMIC</span></h1></a>
    </div>
    <div class="search-bar">
      <form action="{{ route('search') }}" method="GET">
        @csrf
        <input type="text" name="search" placeholder="Tìm kiếm truyện..." required>
        <button style="display:none" type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div>  
    <div class="user-actions">
      <a href="#">Đăng nhập</a>
      <a href="#">Đăng ký</a>
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
      <li><a href="#">Truyện Hot</a></li>
      <li><a href="#">Truyện Mới</a></li>
      <li><a href="#">Hoàn Thành</a></li>
      <li><a href="#">Xếp Hạng</a></li>
    </ul>
  </div>
</nav>