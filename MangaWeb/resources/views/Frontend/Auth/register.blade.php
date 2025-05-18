@extends('Frontend.layouts.main')
@section('content')
<div class="auth-container">
    <div class="auth-header">
        <h1>Đăng ký tài khoản</h1>
        <p>Tạo tài khoản mới</p>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    
    <form action="/register" method="post">
        <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Nhập địa chỉ email" required>
        </div>
        
        <div class="form-group">
        <label for="username">Tên đăng nhập</label>
        <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" placeholder="Nhập tên đăng nhập" required>
        </div>
        
        <div class="form-group">
        <label for="password">Mật khẩu</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu"  minlength="8" pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$" title="Mật khẩu phải có ít nhất 8 ký tự, bao gồm ít nhất 1 chữ hoa và 1 ký tự đặc biệt (!@#$%^&*)"  required>
        </div>
        
        <div class="form-group">
        <label for="confirm-password">Xác nhận mật khẩu</label>
        <input type="password" id="confirm-password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu" required>
        </div>
        
        <div class="terms">
        <input type="checkbox" id="terms" name="terms" required>
        <label for="terms">Tôi đồng ý với các <a href="#">điều khoản và điều kiện</a></label>
        </div>
        
        <button type="submit" class="btn-auth btn-primary">Đăng ký</button>
        
        <div class="auth-footer">
        <p>Đã có tài khoản? <a href="/login">Đăng nhập</a></p>
        </div>
        @csrf
    </form>
</div>
@endsection