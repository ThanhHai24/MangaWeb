@extends('Frontend.layouts.main')
@section('content')
    <div class="sorting-options">
        <button class="sort-button active" data-sort="newest">Mới nhất</button>
        <button class="sort-button" data-sort="recently-updated">Mới cập nhật</button>
        <button class="sort-button" data-sort="most-viewed">Xem nhiều</button>
    </div>
    <section>
        <h2 class="section-title">
          <span>Danh sách truyện</span>
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
@endsection