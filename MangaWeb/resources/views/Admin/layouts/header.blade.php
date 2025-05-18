<div class="header">
    <div class="user-info">
        @auth
            <img src="{{ asset(Auth::user() -> avatar) }}" alt="Admin User">
            <span>{{ Auth::user()->username }}</span>
            <!-- Hoặc bất kỳ thông tin nào khác của user -->
        @endauth
        
    </div>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn">Đăng xuất</button>
    </form>
</div>