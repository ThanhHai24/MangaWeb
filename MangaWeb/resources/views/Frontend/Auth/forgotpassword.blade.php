@extends('Frontend.layouts.main')
@section('content')
<div class="auth-container">
    <div class="auth-header">
        <h1>Quên mật khẩu</h1>
        <p>Nhập email của bạn để khôi phục mật khẩu</p>
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
    
    <form action="{{ route('password.email') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Nhập địa chỉ email" required value="{{ old('email') }}">
        </div>
        
        <button type="submit" class="btn-auth btn-primary">Gửi yêu cầu đặt lại mật khẩu</button>
        
        <div class="auth-footer">
            <p>Đã nhớ mật khẩu? <a href="{{ route('login') }}">Quay lại đăng nhập</a></p>
        </div>
    </form>
</div>
@endsection