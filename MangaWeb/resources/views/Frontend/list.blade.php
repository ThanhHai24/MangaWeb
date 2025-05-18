@extends('Frontend.layouts.main')
@section('content')
    
    <div class="sorting-options">
        <button class="sort-button {{ request()->query('sort', 'newest') == 'newest' ? 'active' : '' }}" data-sort="newest">Mới nhất</button>
        <button class="sort-button {{ request()->query('sort') == 'most-viewed' ? 'active' : '' }}" data-sort="most-viewed">Xem nhiều</button>
    </div>
    <section>
    <h2 class="section-title">
        <span>{{ $title }}</span>
        <a href="#">Xem tất cả</a>
    </h2>
    
    <div class="manga-grid">
        @foreach ($mangas as $manga)
            @php
                $lastChapter = $manga->chapters->last();
            @endphp
            <div class="manga-card">
                <div class="manga-cover">
                    <img src="{{$manga->cover_image}}" alt="{{$manga->title}}">
                    @if ($manga->is_featured)
                        <div class="hot-badge">HOT</div>
                    @endif
                    @if ($lastChapter)
                        <div class="chapter-update"><a style="color: white" href="{{ $manga->slug }}/{{ $lastChapter->slug }}">Chapter {{ $lastChapter->chapter_number }}</a></div>
                    @endif
                </div>
                <div class="manga-info">
                    <h3 class="manga-title"><a href="/{{ $manga->slug }}">{{$manga->title}}</a></h3>
                    <div class="manga-meta">
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Phần phân trang -->
    <!-- Phần hiển thị kết quả và phân trang -->
<div class="pagination-container">
    
    <!-- Phân trang với mũi tên tùy chỉnh -->
    <ul class="pagination">
        <!-- Nút Previous -->
        @if ($mangas->onFirstPage())
            <li class="prev disabled"><span></span></li>
        @else
            <li class="prev arrow"><a href="{{ $mangas->previousPageUrl() }}" rel="prev"></a></li>
        @endif
        
        <!-- Các trang -->
        @php
            $start = max($mangas->currentPage() - 2, 1);
            $end = min($start + 4, $mangas->lastPage());
            $start = max(min($start, $mangas->lastPage() - 4), 1);
        @endphp

        @for ($i = $start; $i <= $end; $i++)
            @if ($i == $mangas->currentPage())
                <li class="active"><span>{{ $i }}</span></li>
            @else
                <li><a href="{{ $mangas->url($i) }}">{{ $i }}</a></li>
            @endif
        @endfor
        
        <!-- Nút Next -->
        @if ($mangas->hasMorePages())
            <li class="next arrow"><a href="{{ $mangas->nextPageUrl() }}" rel="next"></a></li>
        @else
            <li class="next disabled"><span></span></li>
        @endif
    </ul>
</div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý sự kiện click trên nút sắp xếp
        const sortButtons = document.querySelectorAll('.sort-button');
        
        sortButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Loại bỏ class active từ tất cả các nút
                sortButtons.forEach(btn => btn.classList.remove('active'));
                
                // Thêm class active cho nút được click
                this.classList.add('active');
                
                // Lấy giá trị sắp xếp
                const sortType = this.getAttribute('data-sort');
                
                // Tạo URL mới với tham số sắp xếp
                const url = new URL(window.location.href);
                url.searchParams.set('sort', sortType);
                
                // Chuyển hướng đến URL mới
                window.location.href = url.toString();
            });
        });
    });
</script>
@endsection