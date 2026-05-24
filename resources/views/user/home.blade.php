@extends('user.layouts.headers')

@section('pageTitle', 'Kelas Saya')

@section('mainContent')
    <!-- Header Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Kelas yang Diikuti</h2>
        <p class="text-sm text-slate-500 mt-1">Lanjutkan proses belajarmu hari ini.</p>
    </div>

    @if(isset($materialUser) && $materialUser->count() > 0)
        <!-- Grid Container -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($materialUser as $materi)
                <!-- Course Card -->
                <div class="group bg-white rounded-2xl overflow-hidden shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex flex-col">
                    
                    <!-- Thumbnail Container with Aspect Ratio -->
                    <div class="relative w-full pb-[56.25%] overflow-hidden bg-slate-100">
                        <img 
                            src="{{ asset('assets/img/'.$materi['material_image']) }}" 
                            alt="{{ $materi['material_title'] }}" 
                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                        />
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300"></div>
                        
                        <!-- Play/Join overlay icon on hover -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                            <a href="{{ route('join.class', $materi['id']) }}" class="h-12 w-12 bg-white/30 backdrop-blur-md rounded-full flex items-center justify-center text-white shadow-lg border border-white/20 hover:bg-white hover:text-indigo-600 transition-colors">
                                <span class="material-symbols-outlined ml-1">play_arrow</span>
                            </a>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-5 flex-1 flex flex-col">
                        <a href="{{ route('join.class', $materi['id']) }}" class="text-lg font-bold text-slate-800 hover:text-indigo-600 transition-colors line-clamp-2 mb-2 group-hover:underline decoration-indigo-200 underline-offset-4">
                            {{ $materi['material_title'] }}
                        </a>
                        
                        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-full overflow-hidden bg-slate-200 ring-2 ring-white shadow-sm flex items-center justify-center">
                                    <img src="{{ $materi->userTeacher->image_profile ? asset('assets/img/'.$materi->userTeacher->image_profile) : 'https://ui-avatars.com/api/?name='.urlencode($materi->userTeacher->name).'&background=random&color=fff' }}" alt="{{ $materi->userTeacher->name }}" class="h-full w-full object-cover">
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-700 leading-none">{{ $materi->userTeacher->name }}</span>
                                    <span class="text-[11px] text-slate-400 mt-0.5">Pemateri</span>
                                </div>
                            </div>
                            
                            <!-- Small CTA Button -->
                            <a href="{{ route('join.class', $materi['id']) }}" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 text-xs font-semibold rounded-lg hover:bg-indigo-600 hover:text-white transition-colors">
                                Lanjut
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($materialUser->hasPages())
        <div class="mt-10 flex justify-center">
            <nav class="inline-flex items-center gap-1" aria-label="Pagination Kelas Saya">
                {{-- Previous --}}
                @if($materialUser->onFirstPage())
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-300 cursor-not-allowed select-none">
                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                    </span>
                @else
                    <a href="{{ $materialUser->previousPageUrl() }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach($materialUser->getUrlRange(1, $materialUser->lastPage()) as $page => $url)
                    @if($page == $materialUser->currentPage())
                        <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-indigo-600 text-white text-sm font-semibold shadow-sm shadow-indigo-200 select-none">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-600 text-sm font-semibold hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($materialUser->hasMorePages())
                    <a href="{{ $materialUser->nextPageUrl() }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                    </a>
                @else
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-300 cursor-not-allowed select-none">
                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                    </span>
                @endif
            </nav>
        </div>

        <!-- Pagination Info -->
        <p class="text-center text-xs text-slate-400 mt-3">
            Menampilkan {{ $materialUser->firstItem() }}–{{ $materialUser->lastItem() }} dari {{ $materialUser->total() }} kelas
        </p>
        @endif
    @else
        <!-- Beautiful Empty State -->
        <div class="w-full max-w-2xl mx-auto mt-10 md:mt-20 text-center">
            <div class="bg-white rounded-3xl p-10 sm:p-16 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 flex flex-col items-center justify-center relative overflow-hidden">
                <!-- Decorative blurred circles behind -->
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-indigo-500/10 blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-32 h-32 rounded-full bg-violet-500/10 blur-2xl"></div>
                
                <!-- Illustration (SVG) -->
                <div class="h-40 w-40 sm:h-56 sm:w-56 mb-8 relative z-10">
                    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="w-full h-full drop-shadow-md">
                        <!-- Abstract illustration representing empty classes/exploration -->
                        <path fill="#EEF2FF" d="M45.7,-76.4C58.9,-69.1,69,-55.4,76.5,-40.7C84,-26,88.9,-10.3,87.6,5C86.3,20.3,78.8,35.1,69.5,48.2C60.2,61.3,49.1,72.7,35.3,79.5C21.5,86.3,5,88.5,-10.1,85.2C-25.2,81.9,-38.9,73.1,-51.7,63.1C-64.5,53.1,-76.4,41.9,-83.1,27.8C-89.8,13.7,-91.3,-3.3,-86.3,-18.2C-81.3,-33.1,-69.8,-45.9,-56.3,-53.4C-42.8,-60.9,-27.3,-63.1,-12.3,-68.8C2.7,-74.5,17.7,-83.7,31.7,-84.9C45.7,-86.1,58.7,-79.3,45.7,-76.4Z" transform="translate(100 100)" />
                        <path fill="#6366F1" d="M37,-63C47.8,-52.1,56.5,-40.2,64.4,-27.1C72.3,-14,79.4,0.3,78.4,14.5C77.4,28.7,68.3,42.8,55.9,53.2C43.5,63.6,27.8,70.3,12.2,73C-3.4,75.7,-18.9,74.4,-33.5,68.7C-48.1,63,-61.8,52.9,-70.7,39.6C-79.6,26.3,-83.7,9.8,-81.4,-5.4C-79.1,-20.6,-70.4,-34.5,-59.4,-44.6C-48.4,-54.7,-35.1,-61,-21.9,-65.4C-8.7,-69.8,4.4,-72.3,17.1,-69.7C29.8,-67.1,42.1,-59.4,37,-63Z" transform="translate(100 100) scale(0.6)" />
                        <!-- Floating elements -->
                        <circle cx="140" cy="50" r="8" fill="#F472B6" class="animate-bounce" style="animation-duration: 3s;" />
                        <rect x="40" y="140" width="12" height="12" rx="2" fill="#38BDF8" class="animate-spin" style="animation-duration: 8s;" />
                        <polygon points="160,150 170,165 150,165" fill="#FBBF24" class="animate-pulse" style="animation-duration: 4s;" />
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-slate-800 mb-2 z-10">Belum Ada Kelas</h3>
                <p class="text-slate-500 mb-8 max-w-md z-10">Sepertinya Anda belum bergabung dengan kelas apa pun. Mari mulai perjalanan belajar Anda sekarang!</p>
                
                <a href="{{ route('all.materi') }}" class="group relative inline-flex items-center justify-center px-8 py-3.5 text-base font-semibold text-white transition-all duration-200 bg-gradient-to-r from-indigo-600 to-violet-600 rounded-full hover:from-indigo-500 hover:to-violet-500 shadow-lg shadow-indigo-200 hover:shadow-indigo-300 overflow-hidden z-10">
                    <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-white rounded-full group-hover:w-56 group-hover:h-56 opacity-10"></span>
                    <span class="relative flex items-center">
                        <span class="material-symbols-outlined mr-2 text-xl">explore</span>
                        Eksplor Kelas Sekarang
                    </span>
                </a>
            </div>
        </div>
    @endif
@endsection
