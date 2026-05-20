@extends('teacher.layouts.headers')

@section('pageTitle', 'Analitik — ' . $material->material_title)

@section('teacherContent')
@php $fmtT = function($s) {
    $s = (int)$s;
    if ($s < 60) return $s . ' dtk';
    if ($s < 3600) return round($s / 60) . ' mnt';
    return number_format($s / 3600, 1) . ' jam';
}; @endphp
<div class="space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('teacher.home') }}" class="text-sm text-slate-500 hover:text-emerald-600 flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali
        </a>
        <h2 class="text-xl font-bold text-slate-800">{{ $material->material_title }}</h2>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Total Siswa</p>
            <p class="text-3xl font-bold text-slate-800">{{ $totalStudents }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Rata Progress</p>
            <p class="text-3xl font-bold text-emerald-600">{{ $avgProgress }}%</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Rata Skor Quiz</p>
            <p class="text-3xl font-bold text-amber-500">{{ $avgScore }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Quiz Selesai</p>
            <p class="text-3xl font-bold text-indigo-600">{{ $quizDoneCount }}<span class="text-lg text-slate-400">/{{ $totalStudents }}</span></p>
        </div>
    </div>

    {{-- Student Table --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-700">Progress per Siswa</h3>
        </div>
        @if($studentsProgress->isEmpty())
        <div class="p-10 text-center text-slate-400">Belum ada siswa yang bergabung.</div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-xs text-slate-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold">Siswa</th>
                        <th class="px-5 py-3 text-left font-semibold">Progress</th>
                        <th class="px-5 py-3 text-left font-semibold">Waktu Belajar</th>
                        <th class="px-5 py-3 text-left font-semibold">Quiz</th>
                        <th class="px-5 py-3 text-left font-semibold">Akses Terakhir</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($studentsProgress as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-4 font-medium text-slate-800">{{ $item['student']->name }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-24 bg-slate-100 rounded-full h-1.5">
                                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width:{{ $item['percentage'] }}%"></div>
                                </div>
                                <span class="text-xs font-semibold text-slate-600">{{ $item['opened'] }}/{{ $item['totalSubs'] }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-slate-600">{{ $fmtT($item['totalDuration']) }}</td>
                        <td class="px-5 py-4">
                            @if($item['quiz'])
                            <span class="text-emerald-600 font-semibold">{{ $item['quiz']->score }}</span>
                            @else
                            <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-slate-500 text-xs">
                            {{ $item['lastAccess'] ? \Carbon\Carbon::parse($item['lastAccess'])->diffForHumans() : '—' }}
                        </td>
                        <td class="px-5 py-4">
                            <a href="{{ route('teacher.analytics.student', [$material->id, $item['student']->id]) }}" class="text-emerald-600 hover:text-emerald-700 text-xs font-medium">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>
@endsection
