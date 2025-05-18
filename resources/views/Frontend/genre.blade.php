@extends('Frontend.layouts.main')
@section('content')
    <h1 class="category-title">{{ $category -> name }}</h1>
    <p class="category-description">{{ $category -> description }}</p>
    
    <section>
    <h2 class="section-title">
        <span>Danh Sách truyện</span>
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
@endsection