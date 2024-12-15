@extends('teacher.layouts.headers')

@section('teacherContent')
<div class="box-create-materi">
  <form method="POST" action="{{route('store.materi')}}" enctype="multipart/form-data" class="form-materi">
    @csrf
    @method('POST')
      <div class="create-judul-materi">
          Judul Kelas
          <div class=""><input type="text" name="material_title" placeholder="Judul Kelas"></div>
      </div>
      <div class="create-deskripsi-materi">
          Deskripsi Kelas
          <div class=""><textarea name="description" placeholder="Deskripsi Kelas"></textarea></div>
      </div>
      <div class="create-thumbnail-materi">
          Thumbnail Kelas
          <div class=""><input type="file" name="image" required></div>
      </div>
      <div class="sumbit-materi">
        <button class="btn btn-create">Buat Kelas</button>
      </div>
  </form>
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
    <div class="d-flex justify-content-center">
        <form method="POST" action="" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="mb-3">
              <label for="judulMateri" class="form-label">Judul Materi</label>
              <input type="text" class="form-control" name="material_title" id="judulMateri" aria-describedby="emailHelp">
            </div>
            <div class="input-group mb-3">
                <input type="file" class="form-control" name="image" id="inputGroupFile02">
                <label class="input-group-text" for="inputGroupFile02">Upload</label>
              </div>
            <div class="mb-3">
                <textarea id="w3review" name="description" rows="4" cols="50" placeholder="description"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html> --}}