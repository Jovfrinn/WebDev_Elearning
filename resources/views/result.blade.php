<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:ital,wght@0,400..700;1,400..700&family=Andika:ital,wght@0,400;0,700;1,400;1,700&family=Host+Grotesk:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/qstyle.css')}}">

</head>
<body>
    <section class="containers">
    <div class="results-card">
        <h2 class="results-title">Hasil Kuis Akhir Materi AI</h2>
        <div class="results-grid">
            <div>
                <div>Total Benar</div>
                <div class="score-box">{{ $correctAnswers }}</div>
            </div>
            <div>
                <div>Total soal</div>
                <div class="score-box">{{ $totalQuestions }}</div>
            </div>
        </div>
        <div>
            <div>SCOR</div>
            <div class="score-box">{{ round(($correctAnswers / $totalQuestions) * 100, 2) }}%</div>
        </div>
    </div>

    <h3 class="detail-title">Detail Jawaban</h3>

    @foreach ($answerData as $answer)
    @if ($answer->correctAnswer == 0) 
    <div class="detail-sectionX">
        <div class="result-question">
            <div class="soall">
                Soal :
            </div>
            <div class="question">
                {{$answer->question->question}}
            </div>
        </div>
        <hr>
        <div class="result-answer">
            <div class="jawaban">Jawaban :</div>
            <div class="answer">
                {{$answer->choices}}
            </div>
        </div>
        <div class="resultX">
            <span class="material-symbols-outlined">
            close
            </span>
            Salah
        </div>
    </div>
    @else
    <div class="detail-sectionC">
        <div class="result-question">
            <div class="soall">
                Soal :
            </div>
            <div class="question">
               {{$answer->question->question}}
            </div>
        </div>
        <hr>
        <div class="result-answer">
            <div class="jawaban">Jawaban :</div>
            <div class="answer">
                {{$answer->choices}}
            </div>
        </div>
        <div class="resultC">
            <span class="material-symbols-outlined">
            check
            </span>
            Benar
        </div>
    </div>
    @endif
    @endforeach
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
