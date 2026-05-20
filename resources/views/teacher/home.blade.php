@if (!auth()->user()->is_verified)
<!DOCTYPE html>
<html lang="en" class="antialiased h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Verifikasi - EduVortex</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="h-full flex items-center justify-center bg-slate-50 font-sans p-4">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 sm:p-10 text-center shadow-xl shadow-slate-200/50 border border-slate-100">
        <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <span class="material-icons text-4xl text-amber-500">hourglass_empty</span>
        </div>
        <h1 class="text-2xl font-bold text-slate-800 mb-3">Menunggu Verifikasi</h1>
        <p class="text-slate-500 mb-8 leading-relaxed">Akun Pengajar Anda sedang dalam proses peninjauan. Silakan tunggu persetujuan dari Admin sebelum Anda dapat membuat kelas.</p>
        
        <form id="logout-form" action="{{route('logout')}}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center justify-center px-6 py-3 border border-slate-200 text-sm font-medium rounded-xl text-slate-600 bg-white hover:bg-slate-50 hover:text-slate-900 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 w-full">
                Kembali ke Beranda (Logout)
            </button>
        </form>
    </div>
</body>
</html>
@else

@extends('teacher.layouts.headers')

@section('pageTitle', 'Kelola Kelas Anda')

@section('teacherContent')
    <!-- Header & Action Section -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden">
        <!-- Decorative blob -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 rounded-full bg-emerald-500/10 blur-2xl"></div>

        <div class="relative z-10">
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Daftar Kelas</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola materi, tugas, dan perkembangan peserta didik Anda.</p>
        </div>
        
        <div class="relative z-10">
            <a href="{{route('add.materi')}}" class="inline-flex items-center justify-center px-6 py-3 bg-emerald-600 text-white font-medium rounded-xl hover:bg-emerald-700 transition-all duration-200 shadow-md shadow-emerald-200 group">
                <span class="material-symbols-outlined mr-2 group-hover:scale-110 transition-transform">add_circle</span>
                Tambah Kelas Baru
            </a>
        </div>
    </div>

    <!-- Classes List -->
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 overflow-hidden">
        @if($materials->isEmpty())
            <!-- Empty State -->
            <div class="p-12 text-center flex flex-col items-center justify-center">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-4xl text-slate-300">school</span>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum ada kelas</h3>
                <p class="text-slate-500 max-w-sm mb-6">Mulai perjalanan mengajar Anda dengan membuat kelas pertama. Bagikan pengetahuan Anda kepada dunia!</p>
                <a href="{{route('add.materi')}}" class="text-emerald-600 font-medium hover:text-emerald-700 flex items-center">
                    Buat Kelas Sekarang <span class="material-symbols-outlined text-sm ml-1">arrow_forward</span>
                </a>
            </div>
        @else
            <!-- List Items -->
            <ul class="divide-y divide-slate-100">
                @foreach ($materials as $material)
                <li class="p-4 sm:p-6 hover:bg-slate-50/50 transition-colors group flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start sm:items-center gap-4">
                        <!-- Thumbnail -->
                        <div class="h-16 w-24 sm:h-20 sm:w-32 rounded-xl overflow-hidden shrink-0 bg-slate-100 border border-slate-200 relative">
                            <img src="{{asset('assets/img/'.$material->material_image)}}" alt="Thumbnail" class="h-full w-full object-cover">
                        </div>
                        
                        <!-- Info -->
                        <div>
                            <a href="{{route('get.subMateri', $material->id)}}" class="text-lg font-bold text-slate-800 hover:text-emerald-600 transition-colors line-clamp-1 mb-1">
                                {{$material->material_title}}
                            </a>
                            <div class="flex items-center text-xs text-slate-500">
                                <span class="material-symbols-outlined text-[14px] mr-1">calendar_today</span>
                                Dibuat pada {{$material->created_at->format('d F Y')}}
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2 sm:opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('teacher.analytics', $material->id) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Analitik Kelas">
                            <span class="material-symbols-outlined">insights</span>
                        </a>
                        <a href="{{route('get.subMateri', $material->id)}}" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors tooltip" title="Kelola Kelas">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <a href="#" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors tooltip" title="Hapus Kelas">
                            <span class="material-symbols-outlined">delete</span>
                        </a>
                    </div>
                </li>
                @endforeach
            </ul>
        @endif
    </div>

@endsection
@endif