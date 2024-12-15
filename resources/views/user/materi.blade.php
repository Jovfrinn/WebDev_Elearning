@extends('user.layouts.headers')

@section('mainContent')
<div class="list-video-materi mx-auto mt-4">
  <div class="detail-materi">
    <div class="image-materi">
      <img src="{{asset('assets/img/'.$materi->material_image)}}" alt="">
    </div>
    <div class="section-descriptionMateri">
      <div class="title-materi">{{$materi->material_title}}</div>
      <div class="description-materi">     {{$materi->description}}</div>
    </div>
  </div>
  <div class="start-video">
    <div class="mulai">Daftar Pembelajaran</div>
  </div>
  <div class="list-video">
    <ul class="list">
      <?php $nomor = 1; ?>
      @foreach($subMaterial as $material)
      <li class="video-materi">
        <div class="wrapper-video">
          {{-- <div class="chekbox">
            <input type="checkbox" name="" id="" />
          </div> --}}
          <div class="garis ms-2 me-2">|</div>
          <div class="logo">
            <i class="bi bi-play-btn me-2"></i>
          </div>
          <div class="nama-subMateri">
            <a href="{{route('show.materi', $material->id)}}">{{$material->title}}</a>
          </div>
        </div>
        <div class="no-video">{{$nomor++}}</div>
      </li>
      @endforeach
      @if (isset($question))
      <li class="video-materi">
        <div class="wrapper-video">
          <div class="garis ms-2 me-2">|</div>

          <div class="logo">
            <i class="bi bi-question-circle me-2"></i>
          </div>
          <div class="nama-subMateri">
            <a href="{{route('go.quiz', $question)}}">Kuis - {{$material->title}}</a>
          </div>
        </div>
        <div class="no-video">Kuis</div>
      </li>
      @endif
    </ul>
  </div>
</div>

@endsection






