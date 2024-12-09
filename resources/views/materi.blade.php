<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <div class="img">
            <img src="{{asset('assets/img/'.$materi->material_image)}}" alt="">
        </div>
        <div class="desc">
            {{$materi->description}}
        </div>
    </div>
    
    <div class="list-group">
      @foreach($subMaterial as $material)
      <a href="{{route('show.materi', $material->id)}}" class="list-group-item list-group-item-action">{{$material->title}}</a>
      @endforeach
    </div>
    <div class="list-group">
      @if (isset($question))
      <a href="{{route('go.quiz', $question)}}" class="list-group-item list-group-item-action">Kuis - {{$materi->material_title}}</a>
      @else
      <a href="{{route('go.quiz', $question)}}" class="list-group-item list-group-item-action">Kuis - {{$materi->material_title}} Sudah diKerjakan</a>
      @endif
          

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>