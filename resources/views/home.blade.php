<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="row mx-auto mt-5">
        @foreach ($material as $materi)
        <div class="col-md-4">
            <div class="card" style="width: 18rem;">
                <img src="{{asset('assets/img/'.$materi['material_image'])}}" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">{{$materi['material_title']}}</h5>
                  <p class="card-text">{{$materi['description']}}</p>
                    <a href="{{route('join.class',$materi['id'])}}" class="btn btn-primary">Masuk</a>
                  </div>
              </div>
        </div>

        @endforeach
    </div>

<hr>
    <div>yang anda join</div>
<hr>


<div class="row mx-auto mt-5">

@if(isset($materialUser))
@foreach ($materialUser as $item)  

  <div class="col-md-4">
      <div class="card" style="width: 18rem;">
          <img src="{{asset('assets/img/'.$item['material_image'])}}" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">{{$item['material_title']}}</h5>
            <p class="card-text">{{$item['description']}}</p>
              <a href="{{route('join.class',$item['id'])}}" class="btn btn-primary">Masuk</a>
            </div>
        </div>
  </div>
  @endforeach
  @endif
  </div>
 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>