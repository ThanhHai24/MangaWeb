@extends('Frontend.layouts.main')
@section('content')
<div class="container">
    <div class="manga-detail">
        @php
            $lastChapter = $chapters->last();
        @endphp 
        <div class="manga-detail-cover">
            <img src="{{ $manga -> cover_image }}" alt="Bìa truyện">
        </div>
        <div class="manga-info">
            <h1 class="manga-title">{{$manga -> title}}</h1>
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
                    <span class="stat-icon">⭐</span>
                    <span>4.9/5 (25.6K đánh giá)</span>
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

                <button class="btn btn-outline">Theo dõi</button>
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
        <h2 class="section-title">Bình luận (142)</h2>
        
        <div class="comment-form">
            <textarea class="comment-input" placeholder="Viết bình luận của bạn..."></textarea>
            <button class="btn btn-primary">Gửi bình luận</button>
        </div>
        
        <div class="comment-item">
            <div class="comment-avatar">
                <img src="/api/placeholder/50/50" alt="Avatar">
            </div>
            <div class="comment-content">
                <div class="comment-header">
                    <span class="comment-username">OnePieceFan123</span>
                    <span class="comment-date">2 giờ trước</span>
                </div>
                <p class="comment-text">Chương mới thật tuyệt vời! Không thể chờ đến tuần sau để xem Luffy sẽ làm gì tiếp theo. Theo tôi, One Piece đang đi đến hồi kết rồi.</p>
            </div>
        </div>
        
        <div class="comment-item">
            <div class="comment-avatar">
                <img src="/api/placeholder/50/50" alt="Avatar">
            </div>
            <div class="comment-content">
                <div class="comment-header">
                    <span class="comment-username">ZoroFanclub</span>
                    <span class="comment-date">5 giờ trước</span>
                </div>
                <p class="comment-text">Zoro đã bị lạc đường bao nhiêu lần trong arc này rồi nhỉ? 😂 Mình đếm được ít nhất 7 lần. Mong là sớm được thấy trận chiến giữa Zoro và Mihawk!</p>
            </div>
        </div>
        
        <div class="comment-item">
            <div class="comment-avatar">
                <img src="/api/placeholder/50/50" alt="Avatar">
            </div>
            <div class="comment-content">
                <div class="comment-header">
                    <span class="comment-username">SanjiLover</span>
                    <span class="comment-date">8 giờ trước</span>
                </div>
                <p class="comment-text">Bữa tiệc cuối cùng của băng Mũ Rơm làm tôi rất xúc động. Sanji thật sự là đầu bếp tuyệt vời nhất! Không biết liệu họ có tìm thấy All Blue không?</p>
            </div>
        </div>
    </div>
</div>
@endsection