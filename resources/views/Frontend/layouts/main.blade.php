<!DOCTYPE html>
<html lang="vi">
<head>
  @include('Frontend.layouts.head')
</head>
<body>
  <header>
    @include('Frontend.layouts.header')
  </header>
  
  <main class="main-content">
    <div class="container">
        @yield('content')
    </div>
  </main>
  
  <footer>
    @include('Frontend.layouts.footer')
  </footer>

  <script>
    // JavaScript để xử lý tìm kiếm
    document.querySelector('.search-bar input').addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        alert('Đang tìm kiếm: ' + this.value);
        this.value = '';
      }
    });
    
    // JavaScript để xử lý dropdown menu trên thiết bị di động
    document.addEventListener('DOMContentLoaded', function() {
      const navItems = document.querySelectorAll('.main-nav li');
      
      if (window.innerWidth <= 768) {
        navItems.forEach(item => {
          if (item.querySelector('.dropdown')) {
            const link = item.querySelector('a');
            link.addEventListener('click', function(e) {
              e.preventDefault();
              const dropdown = this.parentNode.querySelector('.dropdown');
              dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            });
          }
        });
      }
    });
  </script>
</body>
</html>
