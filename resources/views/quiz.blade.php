{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
</head>
<body>
    <h1>{{ $question->pertanyaan }}</h1>

    <form action="{{ route('quiz.store', $question->id) }}" method="POST">
        @csrf
        @foreach ($question->answers as $answer)
            <div>
                <input type="radio" name="answer" value="{{ $answer->id }}" id="answer-{{ $answer->id }}">
                <label for="answer-{{ $answer->id }}">{{ $answer->opsi }}</label>
            </div>
        @endforeach

        <button type="submit">Next</button>
    </form>
</body>
</html>
 --}}



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Afacad:ital,wght@0,400..700;1,400..700&family=Host+Grotesk:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!--=============== CSS ===============-->
  <link rel="stylesheet" href="{{asset('assets/css/qstyle.css')}}">
</head>
<body>

  <section class="containers">
    <div class="Btop">
      <div class="material-title">
        <span class="material-symbols-outlined me-2">
          library_books
          </span>
          End - Materi Terakhir
      </div>
      <div class="jumlahSoal">
        <div class="keluar">
          <a href="">
            <span class="material-symbols-outlined">
              exit_to_app
              </span>
          </a>
        </div>
          <div class="jumlah mb-2 ms-2">{{$currentQuestion}}/ {{$totalQuestions}}</div>
      </div>
    </div>

    <div class="soal text-center">
      {{ $question->question }}
    </div>
    
    <form action="{{ route('quiz.store', $question->id) }}" method="POST">
      @csrf
    <div class="jawaban row mx-auto g-4">
      @foreach ($question->answers as $answer)
      
        <input type="radio" name="answer" value="{{ $answer->id }}" id="answer-{{ $answer->id }}" style="display: none">
        <label for="answer-{{ $answer->id }}" id="options" class="options col-md-5 mx-auto p-4 text-center">{{ $answer->choices }}</label>
        @endforeach

        <div class="prevNext mx-auto">
          <div class="prev">
            @if($currentQuestion > 1)
            <a href="{{ route('quiz.previous', $currentQuestion) }}" class="btn prev-btn">
                Kembali
            </a>
            @else
            <button disabled class="btn prev-btn">
              Kembali
          </button>
            @endif
          </div>
          <div class="next">
            <button type="submit" class="btn next-btn">Lanjut</button>
          </div>
        </div>
      </div>
    </form>

    
  </section>





  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <script>
    const options = document.querySelectorAll('#options');


    options.forEach(option => {
            option.addEventListener('click', function () {
                options.forEach(b => b.classList.remove('active'));

                this.classList.toggle('active');
            });
        });
  </script>
</body>
</html>




