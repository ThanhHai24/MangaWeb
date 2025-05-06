@extends('Frontend.layouts.main')
@section('content')
 <!-- Truyện Đề Xuất -->
 <section>
        <h2 class="section-title">
          <span>Truyện Đề Xuất</span>
          <a href="#">Xem tất cả</a>
        </h2>
        
        <div class="manga-grid">
          @foreach ($mangas as $manga )
            <div class="manga-card">
              <div class="manga-cover">
                <img src="{{$manga -> cover_image}}" alt="Truyện 1">
                <div class="hot-badge">HOT</div>
                <div class="chapter-update">Chapter 215</div>
              </div>
              <div class="manga-info">
                <h3 class="manga-title"><a href="/{{ $manga -> slug }}">{{$manga -> title}}</a></h3>
                <div class="manga-meta">
                  <span>7.8</span>
                  <!-- <span>Action, Cultivation</span> -->
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </section>
      
      <!-- Truyện Mới Cập Nhật -->
      <section class="latest-updates">
        <h2 class="section-title">
          <span>Truyện Mới Cập Nhật</span>
          <a href="#">Xem tất cả</a>
        </h2>
        @foreach ($updatedMangas as $updatedManga)
          <div class="updates-list">
            <div class="update-item">
              <div class="update-thumbnail">
                <img src="{{ $updatedManga -> cover_image }}" alt="Update 1">
              </div>
              <div class="update-info">
                <a href="/{{ $manga -> slug }}"><h3 class="update-title">{{ $updatedManga -> title }}</h3></a>
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
          <a href="#">Xem tất cả</a>
        </h2>
        
        <div class="manga-grid">
          <div class="manga-card">
            <div class="manga-cover">
              <img src="/api/placeholder/180/240" alt="Completed 1">
              <div class="chapter-update">Hoàn Thành - 420 Chapters</div>
            </div>
            <div class="manga-info">
              <h3 class="manga-title">Thông Thiên Đại Đạo</h3>
              <div class="manga-meta">
                <span>9.4</span>
                <span>Cultivation, Fantasy</span>
              </div>
            </div>
          </div>
        </div>
      </section>
@endsection