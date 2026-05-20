@extends('user.layouts.headers')

@section('pageTitle', 'Progress Belajar Saya')

@section('mainContent')
@php $fmtDur = function($s) {
    $s = (int)$s;
    if ($s < 60) return $s . ' detik';
    if ($s < 3600) return round($s / 60) . ' menit';
    return number_format($s / 3600, 1) . ' jam';
}; @endphp
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] flex items-center gap-4">
            <div class="h-12 w-12 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                <span class="material-symbols-outlined">school</span>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Kelas Diikuti</p>
                <p class="text-3xl font-bold text-slate-800">{{ $totalClasses }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] flex items-center gap-4">
            <div class="h-12 w-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                <span class="material-symbols-outlined">schedule</span>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Total Waktu Belajar</p>
                <p class="text-3xl font-bold text-slate-800">{{ $fmtDur($totalDuration) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] flex items-center gap-4">
            <div class="h-12 w-12 rounded-full bg-amber-50 flex items-center justify-center text-amber-600">
                <span class="material-symbols-outlined">star</span>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Rata-rata Skor Quiz</p>
                <p class="text-3xl font-bold text-slate-800">{{ $avgScore }}</p>
            </div>
        </div>
    </div>

    {{-- Per Class Progress --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h2 class="text-lg font-bold text-slate-800">Progress per Kelas</h2>
        </div>
        @if($progressData->isEmpty())
        <div class="p-10 text-center text-slate-400">
            <span class="material-symbols-outlined text-5xl mb-2">inbox</span>
            <p>Anda belum bergabung ke kelas apapun.</p>
        </div>
        @else
        <ul class="divide-y divide-slate-100">
            @foreach($progressData as $item)
            <li class="p-5 flex flex-col sm:flex-row sm:items-center gap-4 hover:bg-slate-50 transition-colors">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <a href="{{ route('progress.show', $item['material']->id) }}" class="font-semibold text-slate-800 hover:text-indigo-600 transition-colors">
                            {{ $item['material']->material_title }}
                        </a>
                        <span class="text-sm font-bold text-indigo-600">{{ $item['percentage'] }}%</span>
                    </div>
                    {{-- Progress Bar --}}
                    <div class="w-full bg-slate-100 rounded-full h-2 mb-3">
                        <div class="bg-indigo-500 h-2 rounded-full transition-all duration-500" style="width: {{ $item['percentage'] }}%"></div>
                    </div>
                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-500">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">menu_book</span>
                            {{ $item['openedSubs'] }}/{{ $item['totalSubs'] }} sub-materi
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                            {{ $fmtDur($item['totalDuration']) }}
                        </span>
                        @if($item['quiz'])
                        <span class="flex items-center gap-1 text-emerald-600 font-medium">
                            <span class="material-symbols-outlined text-[14px]">check_circle</span>
                            Quiz: {{ $item['quiz']->score }}
                        </span>
                        @else
                        <span class="flex items-center gap-1 text-slate-400">
                            <span class="material-symbols-outlined text-[14px]">radio_button_unchecked</span>
                            Quiz belum dikerjakan
                        </span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('progress.show', $item['material']->id) }}" class="shrink-0 p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Lihat detail">
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
            </li>
            @endforeach
        </ul>
        @endif
    </div>
</div>
@endsection
