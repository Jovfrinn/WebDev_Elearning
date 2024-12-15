@extends('teacher.layouts.headers')

@section('teacherContent')
<div class="box-create-materi">
  <div class="section-dropzone">
  <div class="create-judul-video my-2">Masukan video pembelajaran anda</div>
  <form action="{{ route('store.video') }}" class="dropzone" id="video-dropzone" enctype="multipart/form-data">
    @csrf
</form>
</div>
  <form method="POST" action="{{route('store.subMateri')}}" enctype="multipart/form-data" class="form-materi">
    @csrf
    <input type="hidden" name="idMaterial" value="{{$idMaterial}}">
      <div class="create-judul-video">
          Judul Materi
          <div class="judul-video"><input type="text" name="title" placeholder="Judul Materi"></div>
      </div>
      {{-- <div class="create-thumbnail-video">
          Masukan video pembelajaran anda
          <div class=""><input type="file" name="video"></div>
      </div> --}}
      <div class="create-deskripsi-video">
          Penjelasan Materi
          <div class="description"><textarea name="description" placeholder="Penjelasan Materi"></textarea></div>
      </div>
      <div class="sumbit-materi mx-auto">
        <button class="btn btn-create mx-auto">Buat Materi</button>
      </div>
  </form>
</div>
@endsection


@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script>
  // Konfigurasi Dropzone
  Dropzone.options.videoDropzone = {
      paramName: "file", // Nama parameter yang dikirim
      maxFilesize: 500, // Maksimum ukuran file (MB)
      acceptedFiles: ".mp4,.avi,.mkv,.webm", // Jenis file yang diizinkan
      headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
      },
      success: function(file, response) {
          console.log('Video uploaded successfully:', response.file);
          alert('Video uploaded successfully!');
      },
      error: function(file, response) {
          console.error('Error uploading video:', response);
          alert('Error uploading video. Ensure the file is within 500MB and in the allowed formats.');
      }
  };
</script>

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
    <div class="d-flex justify-content-center">
    <form method="POST" action="{{route('store.subMateri')}}" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="mb-3">
          <label for="judulMateri" class="form-label">Judul</label>
          <input type="text" class="form-control" name="title" id="judulMateri" aria-describedby="emailHelp">
        </div>
        <div class="input-group mb-3">
            <input type="file" class="form-control" name="video" accept="video/*" id="inputGroupFile02">
            <label class="input-group-text" for="inputGroupFile02">Upload</label>
          </div>
        <div class="mb-3">
            <textarea id="w3review" name="description" rows="4" cols="50" placeholder="description"></textarea>
        </div>
        <input type="hidden" name="idMaterial" value="{{$idMaterial}}">
        
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html> --}}