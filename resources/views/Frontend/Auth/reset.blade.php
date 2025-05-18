@extends('Frontend.layouts.main')
@section('content')
<div class="auth-container">
    <div class="auth-header">
        <h1>Đặt lại mật khẩu</h1>
        <p>Tạo mật khẩu mới cho tài khoản của bạn</p>
    </div>
    
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form action="{{ route('password.update') }}" method="post">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ $email ?? old('email') }}" required readonly>
        </div>
        
        <div class="form-group">
            <label for="password">Mật khẩu mới</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu mới" required minlength="8">
        </div>
        
        <div class="form-group">
            <label for="password_confirmation">Xác nhận mật khẩu</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu mới" required minlength="8">
        </div>
        
        <button type="submit" class="btn-auth btn-primary">Đặt lại mật khẩu</button>
        
        <div class="auth-footer">
            <p><a href="{{ route('login') }}">Quay lại đăng nhập</a></p>
        </div>
    </form>
</div>
@endsection