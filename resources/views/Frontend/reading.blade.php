@extends('Frontend.layouts.main')
@section('content')
<div class="container">
<div class="breadcrumb">
      <a href="/">Trang chủ</a>
      <span class="breadcrumb-separator">»</span>
      <a href="/{{ $manga -> slug }}">{{$manga -> title}}</a>
      <span class="breadcrumb-separator">»</span>
      Chapter {{$chapter -> chapter_number}}
  </div>

  <h1 class="chapter-title">
      {{$manga -> title}} - <span>Chapter {{$chapter -> chapter_number}}</span>
      <span class="chapter-date">Ngày cập nhật: [{{$chapter -> updated_at}}]</span>
  </h1>

  <div class="chapter-navigation">
      <div>
          <i>ℹ</i> Sử dụng mũi tên trái (←) hoặc phải (→) để chuyển chapter
      </div>
  </div>

  <div class="page-navigation">
    <a href="/" class="home-icon"><i class="ri-home-9-fill"></i></a>
    <a href="/{{ $manga -> slug }}" class="list-icon"><i class="ri-list-check"></i></a>
    
    @if($chapter -> chapter_number > 1)
        <a href="/{{ $manga -> slug }}/chapter{{$chapter -> chapter_number - 1}}" class="prev-icon">◀</a>
    @else
        <span class="prev-icon disabled">◀</span>
    @endif
    
    <select class="chapter-select" onchange="location = this.value;">
        @foreach($chapters as $chap)
            <option value="/{{ $manga->slug }}/chapter{{ $chap->chapter_number }}" {{ $chapter->chapter_number == $chap->chapter_number ? 'selected' : '' }}>
                Chapter {{ $chap->chapter_number }}
            </option>
        @endforeach
    </select>
    
    @if($chapter -> chapter_number < $lastChapter -> chapter_number)
        <a href="/{{ $manga -> slug }}/chapter{{$chapter -> chapter_number + 1}}" class="next-icon">▶</a>
    @else
        <span class="next-icon disabled">▶</span>
    @endif
    </div>
    <div class="manga-reader">
        @php
        $images = explode('*', $chapter -> images);
        @endphp
        @foreach ($images as $image)
        <img src="{{ $image }}" alt="Manga Page" class="manga-page">
        @endforeach
    </div>
    <div class="page-navigation">
    
    @if($chapter -> chapter_number > 1)
        <a href="/{{ $manga -> slug }}/chapter{{$chapter -> chapter_number - 1}}" class="prev-icon">◀</a>
    @else
        <span class="prev-icon disabled">◀</span>
    @endif
    
    <select class="chapter-select" onchange="location = this.value;">
        @foreach($chapters as $chap)
            <option value="/{{ $manga->slug }}/chapter{{ $chap->chapter_number }}" {{ $chapter->chapter_number == $chap->chapter_number ? 'selected' : '' }}>
                Chapter {{ $chap->chapter_number }}
            </option>
        @endforeach
    </select>
    
    @if($chapter -> chapter_number < $lastChapter -> chapter_number)
        <a href="/{{ $manga -> slug }}/chapter{{$chapter -> chapter_number + 1}}" class="next-icon">▶</a>
    @else
        <span class="next-icon disabled">▶</span>
    @endif
    </div>
    <div class="comments-section">
        <h2 class="section-title">Bình luận ({{ $comments->count() }})</h2>
        
        @auth
        <div class="comment-form">
            <form action="{{ route('comments.store') }}" method="POST" id="commentForm">
                @csrf
                <input type="hidden" name="commentable_id" value="{{ $manga->id }}">
                <input type="hidden" name="commentable_type" value="App\Models\Chapter">
                <input type="hidden" name="parent_id" id="parent_id" value="">
                <div class="reply-info d-none" id="replyInfo">
                    <p>Đang trả lời bình luận của: <span id="replyToUsername" class="font-weight-bold"></span></p>
                    <button type="button" class="btn-cancel-reply">Hủy</button>
                </div>
                <textarea class="comment-input" name="content" placeholder="Viết bình luận của bạn..." required></textarea>
                <div class="comment-form-actions">
                    <button type="submit" class="btn btn-primary" id="submitCommentBtn">Gửi bình luận</button>
                </div>
            </form>
        </div>
        @else
        <div class="comment-login-prompt">
            <p>Vui lòng <a style="color:#4a90e2" href="{{ route('login') }}">đăng nhập</a> để bình luận</p>
        </div>
        @endauth
        
        <div id="commentsList">
            @foreach($comments as $comment)
                @if(!$comment->parent_id)
                    <div class="comment-item" id="comment-{{ $comment->id }}">
                        <div class="comment-avatar">
                            <img src="{{ $comment->user->avatar ?? 'storage\app\public\avatars\images.png' }}" alt="Avatar">
                        </div>
                        <div class="comment-content">
                            <div class="comment-header">
                                <span class="comment-username">{{ $comment->user->displayname }}</span>
                                <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="comment-text">{{ $comment->content }}</p>
                            <div class="comment-actions">
                                @auth
                                    <button class="btn-reply" data-id="{{ $comment->id }}" data-username="{{ $comment->user->displayname }}">Trả lời </button>
                                    @if(auth()->id() == $comment->user_id || auth()->user()->isAdmin())
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" onclick="return confirm('Bạn có chắc muốn xóa bình luận này?')">Xóa</button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>

                    {{-- Hiển thị các reply --}}
                    @foreach($comment->replies as $reply)
                        <div class="comment-item reply-item" id="comment-{{ $reply->id }}">
                            <div class="comment-avatar">
                                <img src="{{ $reply->user->avatar ?? '/api/placeholder/50/50' }}" alt="Avatar">
                            </div>
                            <div class="comment-content">
                                <div class="comment-header">
                                    <span class="comment-username">{{ $reply->user->displayname }}</span>
                                    <span class="comment-date">{{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="comment-text">{{ $reply->content }}</p>
                                <div class="comment-actions">
                                    @auth
                                        <button class="btn-reply" data-id="{{ $comment->id }}" data-username="{{ $reply->user->displayname }}">Trả lời </button>
                                        @if(auth()->id() == $reply->user_id || auth()->user()->isAdmin())
                                            <form action="{{ route('comments.destroy', $reply->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete" onclick="return confirm('Bạn có chắc muốn xóa bình luận này?')">Xóa</button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('frontend/assets/scripts/comment.js') }}"></script>
@endsection