@extends('Frontend.layouts.main')
@section('content')
<div class="auth-container profile-container">
        <div class="profile-header">
          <div class="profile-avatar">
            <img src="{{$user -> avatar}}" alt="Ảnh đại diện" class="avatar">
            <div class="avatar-upload">
              <label for="avatar-upload" class="avatar-upload-label">
                <span>Thay đổi</span>
                <input type="file" id="avatar-upload" name="avatar" accept="image/*" class="avatar-upload-input">
                <input type="hidden" id="avatar-upload-hidden" name="avatar-upload-hidden" value="">
              </label>
            </div>
          </div>
          <h1>{{$user -> displayname}}</h1>
          <p>{{$user -> email}}</p>
        </div>
        
        <form action="profile" method="post" class="profile-form">
          <div class="form-group">
            <label for="fullname">Tên tài khoản</label>
            <input type="text" id="username" name="username" class="form-control" value="{{$user -> username}}" disabled>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{$user -> email}}" disabled>
          </div>

          <div class="form-group">
            <label for="fullname">Tên hiển thị</label>
            <input type="text" id="displayname" name="displayname" class="form-control" value="{{$user -> displayname}}" required>
          </div>
          
          <div class="profile-actions">
            <button type="submit" class="btn-auth btn-primary">Lưu thay đổi</button>
          </div>
          @csrf
        </form>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#avatar-upload').on('change', function () {
        var formData = new FormData();
        var file = this.files[0];
        formData.append('file', file);

        $.ajax({
            url: '/uploadavatar',
            processData: false,
            contentType: false,
            dataType: 'json',
            data: formData,
            method: 'POST',
            success: function(result) {
                if (result.success === true) {
                    $('#avatar-upload-hidden').val(result.path);
                    $('.avatar').attr('src', result.path); // cập nhật ảnh preview
                }
            }
        });
    });
});
</script>
@endsection