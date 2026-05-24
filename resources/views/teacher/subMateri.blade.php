@extends('teacher.layouts.headers')

@section('pageTitle', 'Detail Kelas - ' . $material->material_title)

@section('teacherContent')
<div class="max-w-6xl mx-auto">
    <!-- Header Page -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">{{$material->material_title}}</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola materi pembelajaran dan kuis untuk kelas ini.</p>
        </div>
        <a href="{{ route('teacher.home') }}" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-full transition-colors tooltip" title="Kembali ke Dashboard">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <a href="{{route('add.subMateri', $idMateri)}}" class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 p-5 flex flex-col items-center justify-center text-center hover:bg-emerald-50 hover:border-emerald-200 transition-all group">
            <span class="material-symbols-outlined text-4xl text-emerald-400 mb-2 group-hover:scale-110 transition-transform">note_add</span>
            <span class="font-bold text-slate-800">Tambah Materi</span>
            <span class="text-xs text-slate-500 mt-1">Unggah video baru</span>
        </a>

        <a href="{{route('add.quiz', $idMateri)}}" class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 p-5 flex flex-col items-center justify-center text-center hover:bg-blue-50 hover:border-blue-200 transition-all group">
            <span class="material-symbols-outlined text-4xl text-blue-400 mb-2 group-hover:scale-110 transition-transform">quiz</span>
            <span class="font-bold text-slate-800">Buat Kuis</span>
            <span class="text-xs text-slate-500 mt-1">Evaluasi pemahaman</span>
        </a>

        <a href="{{route('show.join', $idMateri)}}" class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 p-5 flex flex-col items-center justify-center text-center hover:bg-violet-50 hover:border-violet-200 transition-all group">
            <span class="material-symbols-outlined text-4xl text-violet-400 mb-2 group-hover:scale-110 transition-transform">groups</span>
            <span class="font-bold text-slate-800">Peserta Kelas</span>
            <span class="text-xs text-slate-500 mt-1">Lihat yang bergabung</span>
        </a>
    </div>

    <!-- Content List -->
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="text-lg font-bold text-slate-800">Daftar Konten Kelas</h3>
            <span class="px-3 py-1 bg-white border border-slate-200 rounded-full text-xs font-semibold text-slate-600 shadow-sm">{{ count($subMateri) }} Materi</span>
        </div>
        
        <ul class="divide-y divide-slate-100">
            <!-- Video Materials -->
            @forelse ($subMateri as $index => $materi)
            <li class="p-4 sm:p-6 hover:bg-slate-50 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl">smart_display</span>
                    </div>
                    <div>
                        <h4 class="text-md font-bold text-slate-800">{{ $materi->title }}</h4>
                        <p class="text-sm text-slate-500 mt-1 flex items-center">
                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mr-2"></span>
                            Video Pembelajaran {{ $index + 1 }}
                        </p>
                    </div>
                </div>
                
                <div class="flex items-center sm:justify-end gap-2 pl-16 sm:pl-0">
                    <a href="{{route('delete.subMateri', $materi->id)}}" onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?')" class="px-4 py-2 border border-red-200 text-red-600 text-sm font-medium rounded-lg hover:bg-red-50 hover:border-red-300 transition-colors flex items-center">
                        <span class="material-symbols-outlined text-[18px] mr-1">delete</span>
                        Hapus
                    </a>
                </div>
            </li>
            @empty
            <li class="p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                    <span class="material-symbols-outlined text-3xl text-slate-400">inventory_2</span>
                </div>
                <p class="text-slate-600 font-medium">Belum ada materi pembelajaran.</p>
                <p class="text-sm text-slate-400 mt-1">Silakan tambah materi video pertama Anda.</p>
            </li>
            @endforelse

            <!-- Quiz Section (If Exists) -->
            @if (isset($question) && $question != null)
            <li class="p-4 sm:p-6 bg-blue-50/30 hover:bg-blue-50 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl">quiz</span>
                    </div>
                    <div>
                        <a href="{{route('go.quiz', $question)}}" class="text-md font-bold text-slate-800 hover:text-blue-600 transition-colors">Kuis - {{$material->material_title}}</a>
                        <p class="text-sm text-slate-500 mt-1 flex items-center">
                            <span class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-2"></span>
                            Evaluasi Akhir
                        </p>
                    </div>
                </div>
                
                <div class="flex items-center sm:justify-end pl-16 sm:pl-0">
                    <a href="{{route('go.quiz', $question)}}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-50 hover:border-slate-300 transition-colors shadow-sm flex items-center">
                        <span class="material-symbols-outlined text-[18px] mr-1">visibility</span>
                        Lihat Kuis
                    </a>
                </div>
            </li>
            @endif
        </ul>
    </div>
</div>
@endsection