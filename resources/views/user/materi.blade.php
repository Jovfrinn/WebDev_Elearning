@extends('user.layouts.headers')

@section('pageTitle', $materi->material_title)

@section('mainContent')
<div class="max-w-5xl mx-auto">

    <!-- Hero Banner -->
    <div class="relative rounded-2xl overflow-hidden mb-8 shadow-[0_4px_20px_-4px_rgba(6,81,237,0.15)]">
        <!-- Background Image -->
        <div class="relative w-full h-56 sm:h-72 lg:h-80">
            <img src="{{ asset('assets/img/'.$materi->material_image) }}" alt="{{ $materi->material_title }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/50 to-slate-900/10"></div>
        </div>

        <!-- Content on top of image -->
        <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight mb-2">{{ $materi->material_title }}</h1>
            @if($materi->description)
            <p class="text-sm sm:text-base text-slate-200 max-w-2xl leading-relaxed line-clamp-2">{{ $materi->description }}</p>
            @endif
            <div class="mt-4 flex items-center gap-4">
                <div class="flex items-center gap-2 text-slate-300 text-sm">
                    <span class="material-symbols-outlined text-[18px]">video_library</span>
                    {{ count($subMaterial) }} Video
                </div>
                @if(isset($question))
                <div class="flex items-center gap-2 text-slate-300 text-sm">
                    <span class="material-symbols-outlined text-[18px]">quiz</span>
                    1 Kuis
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 overflow-hidden">
        <!-- Section Header -->
        <div class="p-5 sm:p-6 border-b border-slate-100 bg-slate-50/80 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined">menu_book</span>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Daftar Pembelajaran</h2>
                    <p class="text-xs text-slate-500">Ikuti materi secara berurutan untuk hasil terbaik</p>
                </div>
            </div>
            <span class="hidden sm:inline-flex px-3 py-1 bg-white border border-slate-200 rounded-full text-xs font-semibold text-slate-600 shadow-sm">
                {{ count($subMaterial) + (isset($question) ? 1 : 0) }} Item
            </span>
        </div>

        <!-- List Items -->
        <ul class="divide-y divide-slate-100">
            @php $nomor = 1; @endphp
            @foreach($subMaterial as $material)
            <li class="group hover:bg-slate-50/80 transition-colors">
                <a href="{{ route('show.materi', $material->id) }}" class="flex items-center p-4 sm:p-5 gap-4">
                    <!-- Number Badge -->
                    <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm group-hover:bg-indigo-100 transition-colors">
                        {{ $nomor++ }}
                    </div>
                    
                    <!-- Icon -->
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center group-hover:bg-indigo-50 group-hover:text-indigo-500 transition-colors">
                        <span class="material-symbols-outlined text-xl">smart_display</span>
                    </div>
                    
                    <!-- Title -->
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm sm:text-base font-semibold text-slate-800 group-hover:text-indigo-700 transition-colors truncate">
                            {{ $material->title }}
                        </h3>
                        <div class="flex items-center gap-2 mt-0.5">
                            <p class="text-xs text-slate-400">Video Pembelajaran</p>
                            @if($material->file_pdf)
                            <span class="inline-flex items-center px-1.5 py-0.5 bg-red-50 text-red-600 text-[10px] font-semibold rounded">
                                <span class="material-symbols-outlined text-[12px] mr-0.5">picture_as_pdf</span>
                                PDF
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- PDF Download + Arrow -->
                    <div class="flex items-center gap-2 flex-shrink-0">
                        @if($material->file_pdf)
                        <a href="{{ asset('assets/pdf/'.$material->file_pdf) }}" target="_blank" onclick="event.stopPropagation()" class="hidden sm:inline-flex px-3 py-1.5 bg-red-50 text-red-600 text-xs font-semibold rounded-lg hover:bg-red-100 transition-colors items-center border border-red-100" title="Download PDF">
                            <span class="material-symbols-outlined text-[16px] mr-1">download</span>
                            PDF
                        </a>
                        @endif
                        <div class="text-slate-300 group-hover:text-indigo-500 transition-colors">
                            <span class="material-symbols-outlined text-xl">chevron_right</span>
                        </div>
                    </div>
                </a>
            </li>
            @endforeach

            <!-- Quiz Item -->
            @if (isset($question))
            <li class="group hover:bg-blue-50/50 transition-colors bg-blue-50/20">
                <a href="{{ route('go.quiz', $question) }}" class="flex items-center p-4 sm:p-5 gap-4">
                    <!-- Quiz Badge -->
                    <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-sm group-hover:bg-amber-100 transition-colors">
                        <span class="material-symbols-outlined text-lg">emoji_events</span>
                    </div>
                    
                    <!-- Icon -->
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <span class="material-symbols-outlined text-xl">quiz</span>
                    </div>
                    
                    <!-- Title -->
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm sm:text-base font-semibold text-slate-800 group-hover:text-blue-700 transition-colors truncate">
                            Kuis - {{ $materi->material_title }}
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">Evaluasi akhir materi</p>
                    </div>
                    
                    <!-- CTA -->
                    <div class="flex-shrink-0">
                        <span class="hidden sm:inline-flex px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded-lg group-hover:bg-blue-700 transition-colors shadow-sm">
                            Mulai Kuis
                        </span>
                        <span class="sm:hidden text-blue-500 group-hover:text-blue-700 transition-colors">
                            <span class="material-symbols-outlined text-xl">chevron_right</span>
                        </span>
                    </div>
                </a>
            </li>
            @endif
        </ul>

        <!-- Empty State -->
        @if(count($subMaterial) == 0 && !isset($question))
        <div class="p-10 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                <span class="material-symbols-outlined text-3xl text-slate-400">inventory_2</span>
            </div>
            <p class="text-slate-600 font-medium">Belum ada konten pembelajaran.</p>
            <p class="text-sm text-slate-400 mt-1">Pengajar belum menambahkan materi untuk kelas ini.</p>
        </div>
        @endif
    </div>
</div>
@endsection
