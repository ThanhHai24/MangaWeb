@extends('Frontend.layouts.main')
@section('content')
<div class="container">
<div class="breadcrumb">
      <a href="/">Trang chủ</a>
      <span class="breadcrumb-separator">»</span>
      <a href="#">Thể loại</a>
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
    
    <a href="#" class="follow-button">
        <i class="ri-heart-3-fill"></i> Theo dõi
    </a>
</div>
  <div class="manga-reader">
    @php
      $images = explode('*', $chapter -> images);
    @endphp
    @foreach ($images as $image)
      <img src="{{ $image }}" alt="Manga Page" class="manga-page">
    @endforeach
    
</div>
</div>
@endsection