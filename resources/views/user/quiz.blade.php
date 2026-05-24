@extends('user.layouts.headers')

@section('pageTitle', 'Kuis Materi')

@section('mainContent')
<div class="max-w-4xl mx-auto h-full flex flex-col pt-4 pb-8">
    
    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="flex items-center justify-between text-sm font-semibold text-slate-600 mb-2">
            <span>Soal {{ $currentQuestion }} dari {{ $totalQuestions }}</span>
            <span class="text-indigo-600">{{ round(($currentQuestion / $totalQuestions) * 100) }}%</span>
        </div>
        <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden shadow-inner">
            <div class="bg-gradient-to-r from-indigo-500 to-violet-600 h-2.5 rounded-full transition-all duration-500 ease-out" style="width: {{ ($currentQuestion / $totalQuestions) * 100 }}%"></div>
        </div>
    </div>

    <!-- Question Card -->
    <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 p-6 sm:p-10 flex-grow flex flex-col mb-6 relative overflow-hidden">
        
        <!-- Decorative bg -->
        <div class="absolute top-0 right-0 w-40 h-40 bg-indigo-50 rounded-bl-full opacity-50 pointer-events-none"></div>
        <div class="absolute -top-4 -right-4 w-20 h-20 bg-violet-100 rounded-full opacity-30 pointer-events-none"></div>

        <!-- Header Controls -->
        <div class="flex justify-between items-center mb-6 relative z-10">
            <div class="inline-flex items-center justify-center h-10 w-10 rounded-xl bg-indigo-50 text-indigo-600 font-bold shadow-sm">
                {{ $currentQuestion }}
            </div>
            
            <a href="{{ route('get.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-red-500 transition-colors px-3 py-1.5 rounded-lg hover:bg-red-50" title="Keluar Kuis">
                <span class="material-symbols-outlined text-[18px] mr-1.5">exit_to_app</span>
                Keluar
            </a>
        </div>

        <div class="relative z-10 flex-grow flex flex-col">
            <!-- The Question -->
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 leading-snug mb-8 sm:mb-10">
                {{ $question->question }}
            </h2>
            
            <!-- Form -->
            <form action="{{ route('quiz.store', $question->id) }}" method="POST" class="mt-auto" id="quizForm">
                @csrf
                <div class="space-y-4">
                    @foreach ($question->answers as $index => $answer)
                    <div class="relative">
                        <input type="radio" name="answer" value="{{ $answer->id }}" id="answer-{{ $answer->id }}" class="peer sr-only" required>
                        <label for="answer-{{ $answer->id }}" class="answer-label flex items-center p-4 sm:p-5 cursor-pointer bg-white border-2 border-slate-200 rounded-2xl hover:bg-slate-50 transition-all duration-200 group">
                            <!-- Custom Radio Button Circle -->
                            <div class="flex-shrink-0 w-6 h-6 rounded-full border-2 border-slate-300 mr-4 flex items-center justify-center group-hover:border-indigo-400 transition-colors bg-white indicator-border">
                                <div class="w-2.5 h-2.5 rounded-full bg-indigo-600 opacity-0 transform scale-50 transition-all duration-200 indicator-dot" id="indicator-{{$answer->id}}"></div>
                            </div>
                            <!-- Answer Text -->
                            <span class="text-base font-medium text-slate-700 answer-text">
                                {{ $answer->choices }}
                            </span>
                        </label>
                    </div>
                    @endforeach
                </div>

                <!-- Navigation Controls -->
                <div class="flex flex-col sm:flex-row items-center justify-between mt-10 pt-6 border-t border-slate-100 gap-4">
                    <div class="w-full sm:w-1/3 flex justify-center sm:justify-start order-2 sm:order-1">
                        @if($currentQuestion > 1)
                        <a href="{{ route('quiz.previous', $currentQuestion) }}" class="inline-flex items-center px-5 py-2.5 rounded-xl text-slate-600 font-semibold hover:bg-slate-100 hover:text-slate-900 transition-colors w-full sm:w-auto justify-center">
                            <span class="material-symbols-outlined text-[20px] mr-2">arrow_back</span>
                            Kembali
                        </a>
                        @else
                        <button type="button" disabled class="inline-flex items-center px-5 py-2.5 rounded-xl text-slate-300 font-semibold cursor-not-allowed w-full sm:w-auto justify-center">
                            <span class="material-symbols-outlined text-[20px] mr-2">arrow_back</span>
                            Kembali
                        </button>
                        @endif
                    </div>
                    
                    <div class="w-full sm:w-2/3 flex justify-center sm:justify-end order-1 sm:order-2">
                        <button type="submit" class="inline-flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-violet-700 transition-all shadow-md shadow-indigo-200 group w-full sm:w-auto">
                            {{ $currentQuestion == $totalQuestions ? 'Selesai & Kumpulkan' : 'Selanjutnya' }}
                            <span class="material-symbols-outlined text-[20px] ml-2 group-hover:translate-x-1 transition-transform">
                                {{ $currentQuestion == $totalQuestions ? 'done_all' : 'arrow_forward' }}
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('input[type="radio"]');
        
        function updateIndicators() {
            radios.forEach(radio => {
                const indicatorDot = document.getElementById('indicator-' + radio.value);
                const label = radio.nextElementSibling;
                const indicatorBorder = label.querySelector('.indicator-border');
                const answerText = label.querySelector('.answer-text');
                
                if (radio.checked) {
                    indicatorDot.classList.remove('opacity-0', 'scale-50', 'bg-indigo-600');
                    indicatorDot.classList.add('opacity-100', 'scale-100', 'bg-white');
                    
                    indicatorBorder.classList.add('border-white', 'bg-indigo-500');
                    indicatorBorder.classList.remove('border-slate-300', 'bg-white');
                    
                    label.classList.add('border-indigo-600', 'bg-indigo-600', 'shadow-md');
                    label.classList.remove('border-slate-200', 'bg-white', 'hover:bg-slate-50');
                    
                    answerText.classList.add('text-white', 'font-semibold');
                    answerText.classList.remove('text-slate-700');
                } else {
                    indicatorDot.classList.add('opacity-0', 'scale-50', 'bg-indigo-600');
                    indicatorDot.classList.remove('opacity-100', 'scale-100', 'bg-white');
                    
                    indicatorBorder.classList.remove('border-white', 'bg-indigo-500');
                    indicatorBorder.classList.add('border-slate-300', 'bg-white');
                    
                    label.classList.remove('border-indigo-600', 'bg-indigo-600', 'shadow-md');
                    label.classList.add('border-slate-200', 'bg-white', 'hover:bg-slate-50');
                    
                    answerText.classList.remove('text-white', 'font-semibold');
                    answerText.classList.add('text-slate-700');
                }
            });
        }
        
        radios.forEach(radio => {
            radio.addEventListener('change', updateIndicators);
        });
        
        updateIndicators();
    });
</script>
@endsection




