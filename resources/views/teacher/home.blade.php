@if (!auth()->user()->is_verified)
<h1 class="text-center d-flex align-items-center justify-content-center" style="height: 100v;widhth: 100%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff;">Akun Anda belum diverifikasi. Silakan tunggu persetujuan admin.</h1>
@else

@extends('teacher.layouts.headers')

@section('teacherContent')
<div class="daftar-materi">
  <div class="tambah-materi-pengajar">
    <a href="{{route('add.materi')}}" class="btn tambah-materi">Tambah Kelas +</a>
    VORTEX
  </div>
  @if($materials->isEmpty())
  <div class="list-materi-pengajar">
    <div class="b d-flex justify-content-center">
      Materi Tidak Ditemukan
  </div>
  @else
  @foreach ($materials as $material)
  <div class="list-materi-pengajar">
    <div class="b">
      <div class="h">
        <div class="img-materi-teacher">
          <img src="{{asset('assets/img/'.$material->material_image)}}" alt="">
        </div>
        <div class="judulTanggal ms-3">
          <div class="nama-materi">
            <a href="{{route('get.subMateri', $material->id)}}">
              {{$material->material_title}}
            </a>
          </div>
          <div class="tanggal-materi">{{$material->created_at->format('d F Y')}}</div>
        </div>
      </div>
      <div class="b">
        <div class="ngapus">
          <a class="btn btn-danger"><i class="bi bi-trash"></i>Hapus</a>
        </div>
      </div>
    </div>
  </div>
  @endforeach
  @endif
</div>
@endsection
@endif


























{{-- 
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    @if (!auth()->user()->is_verified)
    <p>Akun Anda belum diverifikasi. Silakan tunggu persetujuan admin.</p>
    @else
    <h1>Ini adalah halaman guru</h1>
    <p>Akun Anda telah diverifikasi!</p>
    <a href="{{route('add.materi')}}" class="btn btn-primary ms-5">buat materi</a>

    @foreach ($materials as $material)
    <ul>
        <li><img src="{{asset('assets/img/'.$material->material_image)}}" width="80px" height="80px" alt=""></li>
        <li><a href="{{route('get.subMateri', $material->id)}}">Judul Materi : {{$material->material_title}}</a></li>
        <li>Description : {{$material->description}}</li>
    </ul>
    @endforeach
    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html> --}}