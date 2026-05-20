@extends('teacher.layouts.headers')

@section('pageTitle', 'Detail — ' . $student->name)

@section('teacherContent')
@php $fmtTS = function($s) {
    $s = (int)$s;
    if ($s < 60) return $s . ' detik';
    if ($s < 3600) return round($s / 60) . ' menit';
    return number_format($s / 3600, 1) . ' jam';
}; @endphp
<div class="max-w-3xl space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('teacher.analytics', $material->id) }}" class="text-sm text-slate-500 hover:text-emerald-600 flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali ke Analitik
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-6">
        <p class="text-sm text-slate-500 mb-1">{{ $material->material_title }}</p>
        <h2 class="text-xl font-bold text-slate-800">{{ $student->name }}</h2>
        @if($quiz)
        <span class="inline-flex items-center gap-1 mt-2 text-sm text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full font-medium">
            <span class="material-symbols-outlined text-[16px]">check_circle</span> Quiz — Skor: {{ $quiz->score }}
        </span>
        @else
        <span class="inline-flex items-center gap-1 mt-2 text-sm text-slate-400 bg-slate-50 px-3 py-1 rounded-full">
            Quiz belum dikerjakan
        </span>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-700">Detail Sub-Materi</h3>
        </div>
        <ul class="divide-y divide-slate-100">
            @forelse($subProgress as $item)
            <li class="p-5 flex items-start gap-4">
                <div class="shrink-0 mt-0.5">
                    @if($item['hasLogs'])
                    <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                    @else
                    <span class="material-symbols-outlined text-slate-300">radio_button_unchecked</span>
                    @endif
                </div>
                <div>
                    <p class="font-semibold text-slate-800">{{ $item['sub']->title }}</p>
                    @if($item['hasLogs'])
                    <div class="flex flex-wrap gap-x-4 text-xs text-slate-500 mt-1">
                        <span>Durasi total: {{ $fmtTS($item['totalDuration']) }}</span>
                        <span>Dibuka {{ $item['accessCount'] }}x</span>
                        @if($item['lastAccessed'])
                        <span>Terakhir: {{ \Carbon\Carbon::parse($item['lastAccessed'])->diffForHumans() }}</span>
                        @endif
                    </div>
                    @else
                    <p class="text-xs text-slate-400 mt-1">Belum pernah dibuka</p>
                    @endif
                </div>
            </li>
            @empty
            <li class="p-10 text-center text-slate-400 text-sm">Belum ada sub-materi di kelas ini.</li>
            @endforelse
        </ul>
    </div>

</div>
@endsection
