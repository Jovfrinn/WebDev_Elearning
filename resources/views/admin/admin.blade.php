@extends('admin.layouts.headers')

@section('pageTitle', 'Ringkasan Sistem')

@section('teacherContent')
    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Selamat Datang, Admin</h2>
            <p class="text-sm text-slate-500 mt-1">Berikut adalah ringkasan data di platform EduVortex hari ini.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
        <!-- Student Card -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 flex items-center justify-between group hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Peserta</p>
                <h3 class="text-4xl font-bold text-slate-800">{{ $student }}</h3>
                <a href="{{ route('get.student') }}" class="inline-flex items-center mt-3 text-sm font-medium text-rose-600 hover:text-rose-700 transition-colors">
                    Lihat detail
                    <span class="material-symbols-outlined text-sm ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
            <div class="h-16 w-16 rounded-full bg-rose-50 flex items-center justify-center text-rose-600 group-hover:bg-rose-600 group-hover:text-white transition-colors duration-300">
                <span class="material-symbols-outlined text-3xl">people</span>
            </div>
        </div>

        <!-- Material Card -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 flex items-center justify-between group hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Materi</p>
                <h3 class="text-4xl font-bold text-slate-800">{{ $material }}</h3>
                <a href="{{ route('get.materi') }}" class="inline-flex items-center mt-3 text-sm font-medium text-rose-600 hover:text-rose-700 transition-colors">
                    Lihat detail
                    <span class="material-symbols-outlined text-sm ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
            <div class="h-16 w-16 rounded-full bg-rose-50 flex items-center justify-center text-rose-600 group-hover:bg-rose-600 group-hover:text-white transition-colors duration-300">
                <span class="material-symbols-outlined text-3xl">book</span>
            </div>
        </div>

        <!-- Teacher Card -->
        <div class="bg-white rounded-2xl p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 flex items-center justify-between group hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
            <div>
                <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Pengajar</p>
                <h3 class="text-4xl font-bold text-slate-800">{{ $teacher }}</h3>
                <a href="{{ route('get.teachers') }}" class="inline-flex items-center mt-3 text-sm font-medium text-rose-600 hover:text-rose-700 transition-colors">
                    Lihat detail
                    <span class="material-symbols-outlined text-sm ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
            <div class="h-16 w-16 rounded-full bg-rose-50 flex items-center justify-center text-rose-600 group-hover:bg-rose-600 group-hover:text-white transition-colors duration-300">
                <span class="material-symbols-outlined text-3xl">school</span>
            </div>
        </div>
    </div>

    {{-- Period Filter --}}
    <div class="mt-8 flex items-center gap-3">
        <span class="text-sm font-medium text-slate-600">Periode:</span>
        @foreach([7 => '7 Hari', 30 => '30 Hari', 90 => '3 Bulan', 0 => 'Semua'] as $d => $label)
        <a href="{{ route('admin', ['period' => $d]) }}"
           class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ $days == $d ? 'bg-rose-600 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- Activity Cards --}}
    @php $fmtA = function($s) {
        $s = (int)$s;
        if ($s < 60) return $s . ' dtk';
        if ($s < 3600) return round($s / 60) . ' mnt';
        return number_format($s / 3600, 1) . ' jam';
    }; @endphp
    <div class="mt-4 grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Siswa Aktif</p>
            <p class="text-3xl font-bold text-slate-800">{{ $activeStudents }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Total Waktu Belajar</p>
            <p class="text-3xl font-bold text-indigo-600">{{ $fmtA($totalStudyTime) }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Quiz Dikerjakan</p>
            <p class="text-3xl font-bold text-emerald-600">{{ $totalQuizzes }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Rata Skor Quiz</p>
            <p class="text-3xl font-bold text-amber-500">{{ $avgPlatformScore }}</p>
        </div>
    </div>

    {{-- Top Materials & Top Students --}}
    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
            <div class="p-5 border-b border-slate-100">
                <h3 class="font-bold text-slate-700">Materi Paling Aktif</h3>
            </div>
            @if($topMaterials->isEmpty())
            <div class="p-6 text-center text-slate-400 text-sm">Belum ada data.</div>
            @else
            <ul class="divide-y divide-slate-100">
                @foreach($topMaterials as $mat)
                <li class="px-5 py-3 flex items-center justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-slate-800 truncate">{{ $mat->material_title }}</p>
                        <p class="text-xs text-slate-500">{{ $mat->userTeacher?->name ?? '—' }} · {{ $mat->student_count }} siswa</p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-sm font-semibold text-indigo-600">{{ $mat->access_count }} akses</p>
                        <p class="text-xs text-slate-400">skor rata {{ $mat->avg_score }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
            <div class="p-5 border-b border-slate-100">
                <h3 class="font-bold text-slate-700">Siswa Paling Aktif</h3>
            </div>
            @if($topStudents->isEmpty())
            <div class="p-6 text-center text-slate-400 text-sm">Belum ada data.</div>
            @else
            <ul class="divide-y divide-slate-100">
                @foreach($topStudents as $s)
                <li class="px-5 py-3 flex items-center justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-slate-800 truncate">{{ $s->name }}</p>
                        <p class="text-xs text-slate-500">{{ $s->class_count }} kelas · rata skor {{ $s->avg_score }}</p>
                    </div>
                    <p class="text-sm font-semibold text-emerald-600 shrink-0">{{ $fmtA($s->total_duration) }}</p>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>

@endsection