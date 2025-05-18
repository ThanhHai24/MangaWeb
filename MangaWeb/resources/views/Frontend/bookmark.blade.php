@extends('Frontend.layouts.main')
@section('content')
    <section>
        <h2 class="section-title">
          <span>{{ $title}}</span>
        </h2>
        
        <div class="manga-grid">
          @foreach ($mangas as $manga )
            @php
              $lastChapter = $manga->chapters->last();
            @endphp
            <div class="manga-card">
              <div class="manga-cover">
                <img src="{{$manga -> cover_image}}" alt="Truyện 1">
                @if ($manga->is_featured)
                    <div class="hot-badge">HOT</div>
                @endif
                 @if ($lastChapter)
                  <div class="chapter-update"><a style="color : white" href="{{ $manga -> slug }}/{{ $lastChapter -> slug }}">Chapter {{ $lastChapter->chapter_number }}</a></div>
                @endif
              </div>
              <div class="manga-info">
                <h3 class="manga-title"><a href="/{{ $manga -> slug }}">{{$manga -> title}}</a></h3>
                <div class="manga-meta">
                  <!-- <span>Action, Cultivation</span> -->
                </div>
              </div>
            </div>
          @endforeach
        </div>
    </section>
@endsection