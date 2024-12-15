@extends('teacher.layouts.headers') 

@section('teacherContent')  
<div class="container">
    <h1 class="mt-4">Create New Quiz</h1>
    <hr>
    <form id="quizForm" action="{{route('store.quiz')}}" method="POST">
        @csrf
        
        <input type="hidden" name="idMaterial" value="{{$idMaterial}}">

        <div id="questionsContainer">
            <div class="question-section" data-question-index="0">
                <h3>Pertanyaan 1</h3>
                <div class="form-group">
                    <label>Pertanyaan</label>
                    <input type="text" class="form-control" name="questions[]" required placeholder="Pertanyaan">
                </div>

                <div class="answers-container">
                    <div class="answer-group">
                        <div class="form-group">
                            <label>Jawaban 1</label>
                            <div class="input-group d-flex align-items-center">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <input type="radio" name="correct_answers[0][]" value="0">
                                        <small class="ml-1 ms-1">Jawaban Benar</small>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="answers[0][]" required placeholder="Jawaban 1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jawaban 2</label>
                            <div class="input-group d-flex align-items-center">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <input type="radio" name="correct_answers[0][]" value="0">
                                        <small class="ml-1 ms-1">Jawaban Benar</small>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="answers[0][]" required placeholder="Jawaban 2">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn add-answer-btn mt-4">
                    <span class="material-symbols-outlined">
                    add
                    </span>
                    Tambah Jawaban</button>
            </div>
        </div>

        <div class="mt-3 d-flex justify-content-between">
            <button type="button" id="addQuestionBtn" class="btn btn-add-question">
                <span class="material-symbols-outlined">
                    add
                    </span>
                Tambah Pertanyaan</button>
            <button type="submit" class="btn btn-save">
                <span class="material-symbols-outlined me-2">
                    save
                    </span>
                Save Quiz</button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let questionIndex = 0;
        const questionsContainer = document.getElementById('questionsContainer');
        const addQuestionBtn = document.getElementById('addQuestionBtn');
    
        addQuestionBtn.addEventListener('click', function() {
            questionIndex++;
            const newQuestionSection = createQuestionSection(questionIndex);
            questionsContainer.appendChild(newQuestionSection);
        });
    
        questionsContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-answer-btn')) {
                const questionSection = e.target.closest('.question-section');
                const answersContainer = questionSection.querySelector('.answers-container');
                const currentAnswerCount = answersContainer.querySelectorAll('.answer-group > .form-group').length;
                const newAnswerGroup = createAnswerInput(
                    questionSection.dataset.questionIndex, 
                    currentAnswerCount + 1
                );
                answersContainer.querySelector('.answer-group').appendChild(newAnswerGroup);
            }
        });
    
        function createQuestionSection(index) {
            const questionSection = document.createElement('div');
            questionSection.classList.add('question-section');
            questionSection.dataset.questionIndex = index;
            questionSection.innerHTML = `
                <h3>Pertanyaan ${index + 1}</h3>
                <div class="form-group">
                    <label>Pertanyaan</label>
                    <input type="text" class="form-control" name="questions[]" required placeholder="Pertanyaan">
                </div>

                <div class="answers-container">
                    <div class="answer-group">
                        <div class="form-group">
                            <label>Jawaban 1</label>
                            <div class="input-group d-flex align-items-center">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <input type="radio" name="correct_answers[${index}][]" value="0">
                                        <small class="ml-1 ms-1">Jawaban Benar</small>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="answers[${index}][]" required placeholder="Jawaban 1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jawaban 2</label>
                            <div class="input-group d-flex align-items-center">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <input type="radio" name="correct_answers[${index}][]" value="0">
                                        <small class="ml-1 ms-1">Jawaban Benar</small>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="answers[${index}][]" required placeholder="Jawaban 2">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn add-answer-btn mt-4">
                    <span class="material-symbols-outlined">
                    add
                    </span>
                    Tambah Jawaban</button>
            `;
            return questionSection;
        }
    
        function createAnswerInput(questionIndex, answerIndex) {
            const answerGroup = document.createElement('div');
            answerGroup.classList.add('form-group');
            answerGroup.innerHTML = `
                <label>Answer ${answerIndex}</label>
                <div class="input-group d-flex align-items-center">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <input type="radio" name="correct_answers[${questionIndex}][]" value="${answerIndex - 1}">
                                        <small class="ml-1 ms-1">Jawaban Benar</small>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="answers[${questionIndex}][]" required placeholder="Jawaban ${answerIndex}">
                            </div>
            `;
            return answerGroup;
        }
    });
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
    
    <div class="container">
        <h1>Create New Quiz</h1>
        
        <form id="quizForm" action="{{route('store.quiz')}}" method="POST">
            @csrf
            
            <input type="hidden" name="idMaterial" value="{{$idMaterial}}">
    
            <div id="questionsContainer">
                <div class="question-section" data-question-index="0">
                    <h3>Question 1</h3>
                    <div class="form-group">
                        <label>Question Text</label>
                        <input type="text" class="form-control" name="questions[]" required>
                    </div>
    
                    <div class="answers-container">
                        <div class="answer-group">
                            <div class="form-group">
                                <label>Answer 1</label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="radio" name="correct_answers[0][]" value="0">
                                            {{-- <small class="ml-1">Correct</small> --}}
                                        {{-- </div>
                                    </div>
                                    <input type="text" class="form-control" name="answers[0][]" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Answer 2</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="answers[0][]" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="radio" name="correct_answers[0][]" value="1">
                                            <small class="ml-1">Correct</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <button type="button" class="btn btn-secondary add-answer-btn">Add Answer</button>
                </div>
            </div>
    
            <div class="mt-3">
                <button type="button" id="addQuestionBtn" class="btn btn-primary">Add Question</button>
                <button type="submit" class="btn btn-success">Save Quiz</button>
            </div>
        </form>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let questionIndex = 0;
            const questionsContainer = document.getElementById('questionsContainer');
            const addQuestionBtn = document.getElementById('addQuestionBtn');
        
            addQuestionBtn.addEventListener('click', function() {
                questionIndex++;
                const newQuestionSection = createQuestionSection(questionIndex);
                questionsContainer.appendChild(newQuestionSection);
            });
        
            questionsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('add-answer-btn')) {
                    const questionSection = e.target.closest('.question-section');
                    const answersContainer = questionSection.querySelector('.answers-container');
                    const currentAnswerCount = answersContainer.querySelectorAll('.answer-group > .form-group').length;
                    const newAnswerGroup = createAnswerInput(
                        questionSection.dataset.questionIndex, 
                        currentAnswerCount + 1
                    );
                    answersContainer.querySelector('.answer-group').appendChild(newAnswerGroup);
                }
            });
        
            function createQuestionSection(index) {
                const questionSection = document.createElement('div');
                questionSection.classList.add('question-section');
                questionSection.dataset.questionIndex = index;
                questionSection.innerHTML = `
                    <h3>Question ${index + 1}</h3>
                    <div class="form-group">
                        <label>Question Text</label>
                        <input type="text" class="form-control" name="questions[]" required>
                    </div>
                    <div class="answers-container">
                        <div class="answer-group">
                            <div class="form-group">
                                <label>Answer 1</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="answers[${index}][]" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="radio" name="correct_answers[${index}][]" value="0">
                                            <small class="ml-1">Correct</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Answer 2</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="answers[${index}][]" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <input type="radio" name="correct_answers[${index}][]" value="1">
                                            <small class="ml-1">Correct</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary add-answer-btn">Add Answer</button>
                `;
                return questionSection;
            }
        
            function createAnswerInput(questionIndex, answerIndex) {
                const answerGroup = document.createElement('div');
                answerGroup.classList.add('form-group');
                answerGroup.innerHTML = `
                    <label>Answer ${answerIndex}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="answers[${questionIndex}][]" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <input type="radio" name="correct_answers[${questionIndex}][]" value="${answerIndex - 1}">
                                <small class="ml-1">Correct</small>
                            </div>
                        </div>
                    </div>
                `;
                return answerGroup;
            }
        });
        </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html> --}}