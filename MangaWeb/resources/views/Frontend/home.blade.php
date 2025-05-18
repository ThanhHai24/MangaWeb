@extends('Frontend.layouts.main')
@section('content')
 <!-- Truyện Đề Xuất -->
 <section>
  <h2 class="section-title">
    <span>Truyện Đề Xuất</span>
  </h2>

  <div class="swiper mySwiper">
    <div class="swiper-wrapper">
      @foreach ($recommendeds as $recommended )
        @php
          $lastChapter = $recommended->chapters->last();
        @endphp
        <div class="swiper-slide">
          <div class="manga-card">
            <div class="manga-cover">
              <img src="{{$recommended->cover_image}}" alt="{{$recommended->title}}">
              @if ($recommended->is_featured)
                <div class="hot-badge">HOT</div>
              @endif
              @if ($lastChapter)
                <div class="chapter-update"><a style="color : white" href="{{ $recommended -> slug }}/{{ $lastChapter -> slug }}">Chapter {{ $lastChapter->chapter_number }}</a></div>
              @endif
            </div>
            <div class="manga-info">
              <h3 class="manga-title"><a href="/{{ $recommended->slug }}">{{$recommended->title}}</a></h3>
              <div class="manga-meta">
                <!-- <span>7.8</span> -->
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Mũi tên điều hướng -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>
</section>

 @auth
 <section>
  <h2 class="section-title">
    <span>Truyện Đã Đọc</span>
  </h2>
  @if (!$historymangas->count())
    <h3>Không có truyện nào trong lịch sử đọc của bạn.</h3>
  @endif

  <div class="swiper mySwiper">
    <div class="swiper-wrapper">
      @foreach ($historymangas as $historymanga )
        @php
          $lastChapter = $historymanga->chapters->last();
        @endphp
        <div class="swiper-slide">
          <div class="manga-card">
            <div class="manga-cover">
              <img src="{{$historymanga->cover_image}}" alt="{{$historymanga->title}}">
              @if ($historymanga->is_featured)
                <div class="hot-badge">HOT</div>
              @endif
              @if ($lastChapter)
                <div class="chapter-update"><a style="color : white" href="{{ $historymanga -> slug }}/{{ $lastChapter -> slug }}">Chapter {{ $lastChapter->chapter_number }}</a></div>
              @endif
            </div>
            <div class="manga-info">
              <h3 class="manga-title"><a href="/{{ $historymanga->slug }}">{{$historymanga->title}}</a></h3>
              <div class="manga-meta">
                <!-- <span>7.8</span> -->
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Mũi tên điều hướng -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>
</section>
 @endauth
      
      <!-- Truyện Mới Cập Nhật -->
      <section class="latest-updates">
        <h2 class="section-title">
          <span>Truyện Mới Cập Nhật</span>
          <a href="/newest">Xem tất cả</a>
        </h2>
        @foreach ($updatedMangas as $updatedManga)
          <div class="updates-list">
            <div class="update-item">
              <div class="update-thumbnail">
                <img src="{{ $updatedManga -> cover_image }}" alt="Update 1">
              </div>
              <div class="update-info">
                <a href="/{{ $updatedManga -> slug }}"><h3 class="update-title">{{ $updatedManga -> title }}</h3></a>
                <div class="update-chapters">
                  @foreach ($updatedManga->chapters as $updatedChapter )
                    <a href="/{{ $updatedManga -> slug }}/{{ $updatedChapter -> slug }}" class="update-chapter">Chapter {{ $updatedChapter -> chapter_number }}</a>
                  @endforeach
                </div>
                <div class="update-time">{{ $updatedManga -> updated_at }}</div>
              </div>
            </div>
          </div>
        @endforeach
        
        
      </section>
      
      <!-- Truyện Hoàn Thành -->
      <section>
        <h2 class="section-title">
          <span>Truyện Hoàn Thành</span>
          <a href="/finished">Xem tất cả</a>
        </h2>
        
        <div class="manga-grid">
          @foreach ($finishedMangas as $finishedManga )
            @php
              $lastChapter = $finishedManga->chapters->count();
            @endphp
            <div class="manga-card">
            <div class="manga-cover">
              <img src={{$finishedManga -> cover_image}} alt="Completed 1">
              <div class="chapter-update">Hoàn Thành - {{ $lastChapter }} Chapters</div>
            </div>
            <div class="manga-info">
              <a href="{{ $finishedManga -> slug }}"><h3 class="manga-title">{{$finishedManga -> title}}</h3></a>
              <div class="manga-meta">
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </section>
  <!-- Danh Sách Truyện -->
<section>
    <h2 class="section-title">
        <span>Danh Sách truyện</span>
        <a href="/list">Xem tất cả</a>
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
@section('scripts')
<script>
  const swiper = new Swiper(".mySwiper", {
    slidesPerView: 5,
    spaceBetween: 20,
    loop: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
      },
      576: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 3,
      },
      992: {
        slidesPerView: 4,
      },
      1200: {
        slidesPerView: 5,
      }
    }
  });
</script>
@endsection