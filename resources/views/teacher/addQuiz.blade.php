@extends('teacher.layouts.headers') 

@section('pageTitle', 'Buat Kuis Baru')

@section('teacherContent')  
<div class="max-w-5xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Buat Kuis Baru</h2>
            <p class="text-sm text-slate-500 mt-1">Tambahkan pertanyaan dan pilihan jawaban untuk mengevaluasi peserta.</p>
        </div>
        <a href="{{ route('get.subMateri', $idMaterial) }}" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-full transition-colors tooltip" title="Kembali">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
    </div>

    <!-- Main Form -->
    <form id="quizForm" action="{{route('store.quiz')}}" method="POST">
        @csrf
        <input type="hidden" name="idMaterial" value="{{$idMaterial}}">

        <div id="questionsContainer" class="space-y-6">
            <!-- Initial Question Section -->
            <div class="question-section bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 p-6 sm:p-8" data-question-index="0">
                <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center">
                        <span class="bg-emerald-100 text-emerald-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm">1</span>
                        Pertanyaan
                    </h3>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Teks Pertanyaan</label>
                    <input type="text" name="questions[]" required placeholder="Tuliskan pertanyaan di sini..."
                        class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors text-slate-800 placeholder-slate-400">
                </div>

                <div class="answers-container space-y-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilihan Jawaban</label>
                    <div class="answer-group space-y-3">
                        <!-- Answer 1 -->
                        <div class="form-group flex items-center gap-3">
                            <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 bg-slate-50 border border-slate-200 rounded-xl">
                                <input type="radio" name="correct_answers[0][]" value="0" class="w-5 h-5 text-emerald-600 focus:ring-emerald-500 border-slate-300 tooltip" title="Tandai sebagai jawaban benar">
                            </div>
                            <input type="text" name="answers[0][]" required placeholder="Pilihan jawaban 1"
                                class="flex-1 block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors text-slate-800">
                        </div>
                        
                        <!-- Answer 2 -->
                        <div class="form-group flex items-center gap-3">
                            <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 bg-slate-50 border border-slate-200 rounded-xl">
                                <input type="radio" name="correct_answers[0][]" value="0" class="w-5 h-5 text-emerald-600 focus:ring-emerald-500 border-slate-300 tooltip" title="Tandai sebagai jawaban benar">
                            </div>
                            <input type="text" name="answers[0][]" required placeholder="Pilihan jawaban 2"
                                class="flex-1 block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors text-slate-800">
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-50">
                    <button type="button" class="add-answer-btn inline-flex items-center px-4 py-2 text-sm font-medium text-emerald-600 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-[18px] mr-1 pointer-events-none">add</span>
                        Tambah Pilihan Jawaban
                    </button>
                </div>
            </div>
        </div>

        <!-- Global Actions -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <button type="button" id="addQuestionBtn" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-slate-200 bg-white text-slate-700 font-medium rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                <span class="material-symbols-outlined mr-2">add_box</span>
                Tambah Pertanyaan Baru
            </button>
            
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-emerald-600 text-white font-medium rounded-xl hover:bg-emerald-700 transition-colors shadow-md shadow-emerald-200">
                <span class="material-symbols-outlined mr-2">save</span>
                Simpan Kuis
            </button>
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
            // Match button or its child icon
            if (e.target.classList.contains('add-answer-btn') || e.target.parentElement.classList.contains('add-answer-btn')) {
                const btn = e.target.classList.contains('add-answer-btn') ? e.target : e.target.parentElement;
                const questionSection = btn.closest('.question-section');
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
            questionSection.classList.add('question-section', 'bg-white', 'rounded-2xl', 'shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]', 'border', 'border-slate-100', 'p-6', 'sm:p-8', 'mt-6');
            questionSection.dataset.questionIndex = index;
            
            questionSection.innerHTML = `
                <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center">
                        <span class="bg-emerald-100 text-emerald-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm">${index + 1}</span>
                        Pertanyaan
                    </h3>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Teks Pertanyaan</label>
                    <input type="text" name="questions[]" required placeholder="Tuliskan pertanyaan di sini..."
                        class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors text-slate-800 placeholder-slate-400">
                </div>

                <div class="answers-container space-y-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilihan Jawaban</label>
                    <div class="answer-group space-y-3">
                        <div class="form-group flex items-center gap-3">
                            <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 bg-slate-50 border border-slate-200 rounded-xl">
                                <input type="radio" name="correct_answers[${index}][]" value="0" class="w-5 h-5 text-emerald-600 focus:ring-emerald-500 border-slate-300 tooltip" title="Tandai sebagai jawaban benar">
                            </div>
                            <input type="text" name="answers[${index}][]" required placeholder="Pilihan jawaban 1"
                                class="flex-1 block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors text-slate-800">
                        </div>
                        <div class="form-group flex items-center gap-3">
                            <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 bg-slate-50 border border-slate-200 rounded-xl">
                                <input type="radio" name="correct_answers[${index}][]" value="1" class="w-5 h-5 text-emerald-600 focus:ring-emerald-500 border-slate-300 tooltip" title="Tandai sebagai jawaban benar">
                            </div>
                            <input type="text" name="answers[${index}][]" required placeholder="Pilihan jawaban 2"
                                class="flex-1 block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors text-slate-800">
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-50">
                    <button type="button" class="add-answer-btn inline-flex items-center px-4 py-2 text-sm font-medium text-emerald-600 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-[18px] mr-1 pointer-events-none">add</span>
                        Tambah Pilihan Jawaban
                    </button>
                </div>
            `;
            return questionSection;
        }
    
        function createAnswerInput(questionIndex, answerIndex) {
            const answerGroup = document.createElement('div');
            answerGroup.classList.add('form-group', 'flex', 'items-center', 'gap-3');
            
            answerGroup.innerHTML = `
                <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 bg-slate-50 border border-slate-200 rounded-xl">
                    <input type="radio" name="correct_answers[${questionIndex}][]" value="${answerIndex - 1}" class="w-5 h-5 text-emerald-600 focus:ring-emerald-500 border-slate-300 tooltip" title="Tandai sebagai jawaban benar">
                </div>
                <input type="text" name="answers[${questionIndex}][]" required placeholder="Pilihan jawaban ${answerIndex}"
                    class="flex-1 block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors text-slate-800">
            `;
            return answerGroup;
        }
    });
</script>
@endsection