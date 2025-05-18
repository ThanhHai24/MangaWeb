@extends('Frontend.layouts.main')
@section('content')
<div class="auth-container">
    <div class="auth-header">
        <h1>Đổi mật khẩu</h1>
        <p>Thay đổi mật khẩu của bạn</p>
    </div>
    
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form action="{{ route('password.change') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="current-password">Mật khẩu hiện tại</label>
            <input type="password" id="current-password" name="current-password" class="form-control" placeholder="Nhập mật khẩu hiện tại" required>
        </div>
        
        <div class="form-group">
            <label for="new-password">Mật khẩu mới</label>
            <input type="password" id="new-password" name="new-password" class="form-control" placeholder="Nhập mật khẩu mới" required minlength="8">
        </div>
        
        <div class="form-group">
            <label for="new-password_confirmation">Xác nhận mật khẩu mới</label>
            <input type="password" id="new-password_confirmation" name="new-password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu mới" required minlength="8">
        </div>
        
        <button type="submit" class="btn-auth btn-primary">Đổi mật khẩu</button>
        
        <div class="auth-footer">
            <p><a href="{{ route('profile') }}">Quay lại trang cá nhân</a></p>
        </div>
    </form>
</div>
@endsection