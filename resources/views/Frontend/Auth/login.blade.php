@extends('Frontend.layouts.main')
@section('content')
<div class="auth-container">
    <div class="auth-header">
        <h1>Đăng nhập</h1>
        <p>Vui lòng nhập thông tin đăng nhập của bạn</p>
    </div>
    
    <form action="{{ route('login') }}" method="post">
        <div class="form-group">
           <label for="username">Tên đăng nhập</label>
            <div class="col-md-6">
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        
        <div class="form-group">
        <label for="password">Mật khẩu</label>
        <div class="col-md-6">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        </div>
        
        <div class="remember-me">
        <div class="col-md-6 offset-md-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    Ghi nhớ đăng nhập
                </label>
            </div>
        </div>
        </div>
        
        <button type="submit" class="btn-auth btn-primary">Đăng nhập</button>
        
        <div class="auth-links">
        <a class="btn-auth btn-link" href="{{ route('password.request') }}">
            Quên mật khẩu?
        </a>
        </div>
        
        <div class="auth-footer">
        <p>Chưa có tài khoản? <a href="{{ route('register') }}">
            Đăng ký ngay
        </a></p>
        </div>
        @csrf
    </form>
</div>
@endsection