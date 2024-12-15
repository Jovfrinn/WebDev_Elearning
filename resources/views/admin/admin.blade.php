@extends('admin.layouts.headers')

@section('teacherContent')
<div class="container">
  <div class="header-main">
    <span>Selamat datang, Di halaman utama Guru</span>
    <span class="vortex">EduVortex</span>
    <hr />
  </div>
  <div class="row mt-5">
    <div class="col-md-4 all-card pb-5">
      <div class="card-info">
        <div class="logo-card-info">
          <i class="bi bi-people-fill"></i>
        </div>
        <h4>{{$student}} Peserta</h4>
        <a href="{{route('get.student')}}">lihat detail</a>
      </div>
    </div>
    <div class="col-md-4 all-card pb-5">
      <div class="card-info">
        <div class="logo-card-info">
          <i class="bi bi-journal-text"></i>
        </div>
        <h4>{{$material}} Materi</h4>
        <a href="{{route('get.materi')}}">lihat detail</a>
      </div>
    </div>
    <div class="col-md-4 all-card pb-5">
      <div class="card-info">
        <div class="logo-card-info">
          <i class="bi bi-person-workspace"></i>
        </div>
        <h4>{{$teacher}} Pengajar</h4>
        <a href="{{route('get.teachers')}}">lihat detail</a>
      </div>
    </div>
    {{-- <div class="col-md-12 all-card pb-5">
      <div class="card-info-large">
        <div class="logo-card-info-large">
          <i class="bi bi-people-fill"></i>
        </div>
        <h4>100 Peserta</h4>
        <a href="">lihat detail</a>
      </div>
    </div> --}}
  </div>
</div>
@endsection




{{-- <!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
 
    <div class="row mx-auto">
        <div class="card col-md-4 mx-auto" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">{{$student}}</h5>
              <h6 class="card-subtitle mb-2 text-body-secondary">Peserta</h6>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              <a href="#" class="card-link">Card link</a>
              <a href="#" class="card-link">Another link</a>
            </div>
          </div>
        <div class="card col-md-4 mx-auto" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">{{$material}}</h5>
              <h6 class="card-subtitle mb-2 text-body-secondary">Materi</h6>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              <a href="#" class="card-link">Card link</a>
              <a href="#" class="card-link">Another link</a>
            </div>
          </div>
        <div class="card col-md-4 mx-auto" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">{{$teacher}}</h5>
              <h6 class="card-subtitle mb-2 text-body-secondary">Pengajar</h6>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              <a href="#" class="card-link">Card link</a>
              <a href="#" class="card-link">Another link</a>
            </div>
          </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html> --}}