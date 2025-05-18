@extends('Frontend.layouts.main')
@section('content')
<div class="container">
    <div class="manga-detail">
        @php
            $lastChapter = $chapters->last();
            $isBookmarked = false;
            if(Auth::check()) {
                $isBookmarked = Auth::user()->bookmarks()->where('manga_id', $manga->id)->exists();
            }
        @endphp 
        <div class="manga-detail-cover">
            <img src="{{ $manga -> cover_image }}" alt="Bìa truyện">
        </div>
        <div class="manga-info">
            <h1 class="manga-title-detail">{{$manga -> title}}</h1>
            <div class="manga-author">Tác giả: {{$manga -> author}}</div>
            <div class="manga-status">{{$manga -> status}}</div>
            
            <div class="manga-description">
            {{$manga -> description}}
            </div>

            <div class="manga-genres">
                @foreach($manga->categories as $category)
                    <a href="/the-loai/{{ $category -> slug }}"><span class="genre-tag">{{ $category->name }}</span></a>
                @endforeach
            </div>

            <div class="manga-stats">
                <div class="stat-item">
                    <span class="stat-icon">👁️</span>
                    <span>{{$manga -> views}} lượt xem</span>
                </div>
                <div class="stat-item">
                    <span class="stat-icon">📑</span>
                    <span>{{ $lastChapter?->chapter_number ?? 0 }} chương</span>
                </div>
            </div>
            
            <div class="buttons">
                @if ($manga)
                    <a href="/{{ $manga->slug }}/chapter1" class="btn btn-primary">Đọc từ đầu</a>
                @else
                    <button class="btn btn-primary" disabled>Đọc từ đầu</button>
                @endif

                @if ($manga && $lastChapter && $lastChapter->slug)
                    <a href="/{{ $manga->slug }}/{{ $lastChapter->slug }}" class="btn btn-secondary">Đọc chương mới nhất</a>
                @else
                    <button class="btn btn-secondary" disabled>Đọc chương mới nhất</button>
                @endif

                <button class="btn btn-outline btn-bookmark {{ $isBookmarked ? 'bookmarked' : '' }}" data-manga="{{ $manga->id }}">
                    @if($isBookmarked)
                        <i class="fas fa-bookmark"></i> Đã theo dõi
                    @else
                        <i class="far fa-bookmark"></i> Theo dõi
                    @endif
                </button>
            </div>
        </div>
    </div>

    <div class="chapter-list">
        <h2 class="section-title">Danh sách chương</h2>
        @foreach ($chapters as $chapter)
            <a href="{{ $manga -> slug }}/{{ $chapter -> slug }}">
            <div class="chapter-item">
                <div class="chapter-info">
                    <h3>Chương {{$chapter -> chapter_number}}: {{ $chapter -> content }}</h3>
                    <span class="chapter-date">Cập nhật: {{$chapter -> updated_at}}</span>
                </div>
                <div class="chapter-views">
                    <span>{{$chapter -> views}} lượt xem</span>
                </div>
            </div>
            </a>
        @endforeach
    </div>

    <div class="comments-section">
        <h2 class="section-title">Bình luận ({{ $comments->count() }})</h2>
        
        @auth
        <div class="comment-form">
            <form action="{{ route('comments.store') }}" method="POST" id="commentForm">
                @csrf
                <input type="hidden" name="commentable_id" value="{{ $manga->id }}">
                <input type="hidden" name="commentable_type" value="App\Models\Manga">
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
                            <img src="{{ $comment->user->avatar ?? '/api/placeholder/50/50' }}" alt="Avatar">
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
                                        <button class="btn-reply" data-id="{{ $comment->id }}" data-username="{{ $reply->user->displayname }}">Trả lời</button>
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
<script src="{{ asset('frontend/assets/scripts/bookmark.js') }}"></script>
@endsection