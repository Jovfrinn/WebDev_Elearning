@extends('user.layouts.headers')

@section('pageTitle', 'Hasil Kuis')

@section('mainContent')
<div class="max-w-4xl mx-auto pt-4 pb-8 space-y-8">
    
    <!-- Hero Score Card -->
    <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden relative">
        <!-- Decorative bg -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-indigo-400/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-violet-400/10 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="p-8 sm:p-10 relative z-10 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 mb-2">Hasil Kuis Akhir Materi</h2>
            <p class="text-slate-500 mb-8">Kerja bagus! Berikut adalah ringkasan hasil dari evaluasi Anda.</p>
            
            <!-- Score Display -->
            <div class="inline-flex flex-col items-center justify-center p-8 bg-gradient-to-br from-indigo-50 to-violet-50 rounded-full border-4 border-white shadow-[0_0_20px_rgba(79,70,229,0.15)] mb-8 h-48 w-48">
                <span class="text-sm font-semibold text-indigo-600 uppercase tracking-widest mb-1">Skor</span>
                <span class="text-5xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-600">
                    {{ $score }}%
                </span>
            </div>
            
            <!-- Stats -->
            <div class="grid grid-cols-2 gap-4 max-w-sm mx-auto">
                <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm flex flex-col items-center">
                    <span class="material-symbols-outlined text-emerald-500 text-3xl mb-1">check_circle</span>
                    <span class="text-2xl font-bold text-slate-800">{{ $correctAnswers }}</span>
                    <span class="text-xs text-slate-500 font-medium">Jawaban Benar</span>
                </div>
                <div class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm flex flex-col items-center">
                    <span class="material-symbols-outlined text-indigo-400 text-3xl mb-1">list_alt</span>
                    <span class="text-2xl font-bold text-slate-800">{{ $totalQuestions }}</span>
                    <span class="text-xs text-slate-500 font-medium">Total Soal</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Answers Section -->
    <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 p-6 sm:p-10">
        <div class="flex items-center gap-3 mb-8 pb-4 border-b border-slate-100">
            <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined">analytics</span>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800">Detail Evaluasi Jawaban</h3>
                <p class="text-sm text-slate-500">Ulas kembali jawaban yang telah Anda berikan.</p>
            </div>
        </div>

        <div class="space-y-6">
            @foreach ($answerData as $index => $answer)
                <div class="rounded-2xl border-2 {{ $answer->correctAnswer == 1 ? 'border-emerald-100 bg-emerald-50/30' : 'border-red-100 bg-red-50/30' }} p-5 sm:p-6 transition-colors">
                    
                    <div class="flex items-start gap-4">
                        <!-- Indicator Icon -->
                        <div class="shrink-0 mt-1">
                            @if ($answer->correctAnswer == 1)
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 shadow-sm">
                                    <span class="material-symbols-outlined text-[20px]">check</span>
                                </div>
                            @else
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600 shadow-sm">
                                    <span class="material-symbols-outlined text-[20px]">close</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Question and Answer -->
                        <div class="flex-1 min-w-0">
                            <h4 class="text-base font-semibold text-slate-800 mb-3 leading-snug">
                                {{ $index + 1 }}. {{ $answer->question->question }}
                            </h4>
                            
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                                <span class="text-sm font-medium text-slate-500 shrink-0">Jawaban Anda:</span>
                                <div class="px-4 py-2 rounded-xl text-sm font-medium {{ $answer->correctAnswer == 1 ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }} inline-flex items-center">
                                    {{ $answer->choices }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="flex justify-center pt-4">
        @if (isset($idMaterial))
        <a href="{{ route('sub.materi', $idMaterial) }}" class="inline-flex items-center px-8 py-3.5 bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-violet-700 transition-all shadow-lg shadow-indigo-200">
            <span class="material-symbols-outlined mr-2 text-[20px]">menu_book</span>
            Kembali ke Materi
        </a>
        @else
        <a href="{{ route('get.index') }}" class="inline-flex items-center px-8 py-3.5 bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-violet-700 transition-all shadow-lg shadow-indigo-200">
            <span class="material-symbols-outlined mr-2 text-[20px]">home</span>
            Kembali ke Beranda
        </a>
        @endif
    </div>
    
</div>
@endsection
