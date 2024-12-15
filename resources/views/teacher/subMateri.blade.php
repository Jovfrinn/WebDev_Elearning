@extends('teacher.layouts.headers')

@section("teacherContent")

<div class="section-subMateri">
  <div class="namaKelas">
    {{$material->material_title}}
  </div>
  <hr>
  <div class="button-add">
    <a href="{{route('show.join', $idMateri)}}" class="btn btn-add-question">Lihat yang bergabung</a>
    <a href="{{route('add.subMateri',$idMateri)}}" class="btn materi ms-5"><span class="material-symbols-outlined me-1">
      note_add
      </span> Buat Materi</a>
    <a href="{{route('add.quiz',$idMateri)}}" class="btn quiz ms-5"><span class="material-symbols-outlined me-1">
      quiz
      </span> Buat Quiz</a>
  </div>
  <div class="section-list-subMateri">
    <ul class="list">
      <?php $nomor = 1; ?>
      @foreach ($subMateri as $materi)
      <li class="content-subMateri mx-auto">
        <div class="logoAndName ms-3">
          <span class="material-symbols-outlined">
            smart_display
            </span>
            <div class="name-subMateri ms-3">
              {{$materi->title}}
            </div>
        </div>
        <div class="action me-4">
         
          <a href="{{route('delete.subMateri', $materi->id)}}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus materi ini?')">Hapus Materi</a>
        </div>
      </li>
      @endforeach
      @if (isset($question))
      <li class="content-subMateri mx-auto">
        <div class="logoAndName ms-3">
          <span class="material-symbols-outlined">
            quiz
            </span>
            <div class="name-subMateri ms-3">
              <a href="{{route('go.quiz', $question)}}">Kuis - {{$material->material_title}}</a>
            </div>
        </div>
        <div class="number me-4"></div>
      </li>
      @endif
    </ul>
  </div>
</div>

@endsection

{{-- <div class="subMateri">
    <a href="{{route('add.subMateri',$idMateri)}}" class="btn btn-primary ms-5">buat materi</a>
    <a href="{{route('add.quiz',$idMateri)}}" class="btn btn-primary ms-5">buat materi</a>
    @foreach ($subMateri as $materi)
    <ul>
        <li>Judul Materi : {{$materi->title}}</li>
    </ul>
    @endforeach

  </div> --}}