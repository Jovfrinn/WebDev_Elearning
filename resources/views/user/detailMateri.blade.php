@extends('user.layouts.headers')

@section('pageTitle', $detailMateri->title)

@section('mainContent')
<div class="max-w-5xl mx-auto">

    <!-- Back Button + Title -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('sub.materi', $detailMateri->id_material) }}" class="inline-flex items-center text-sm text-slate-500 hover:text-indigo-600 transition-colors mb-2">
                <span class="material-symbols-outlined text-[18px] mr-1">arrow_back</span>
                Kembali ke Daftar Materi
            </a>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">{{ $detailMateri->title }}</h1>
        </div>
    </div>

    <!-- Video Player Card -->
    <div class="bg-white rounded-2xl shadow-[0_4px_20px_-4px_rgba(6,81,237,0.15)] border border-slate-100 overflow-hidden mb-8">
        @if($detailMateri->file_material)
        <div class="relative w-full bg-black">
            <video controls preload="metadata" class="w-full max-h-[500px] mx-auto" controlslist="nodownload">
                <source src="{{ asset('assets/video/'.$detailMateri->file_material) }}" type="video/mp4">
                Browser Anda tidak mendukung pemutaran video.
            </video>
        </div>
        @else
        <div class="w-full h-64 sm:h-80 bg-slate-900 flex flex-col items-center justify-center text-slate-400">
            <span class="material-symbols-outlined text-6xl mb-3">videocam_off</span>
            <p class="text-base font-medium">Video belum tersedia</p>
            <p class="text-sm text-slate-500 mt-1">Pengajar belum mengunggah video untuk materi ini.</p>
        </div>
        @endif
    </div>

    <!-- Content Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Description -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                <span class="material-symbols-outlined mr-2 text-indigo-500">description</span>
                Deskripsi Materi
            </h3>
            @if($detailMateri->description)
            <p class="text-slate-600 leading-relaxed whitespace-pre-line">{{ $detailMateri->description }}</p>
            @else
            <p class="text-slate-400 italic">Belum ada deskripsi untuk materi ini.</p>
            @endif
        </div>

        <!-- Side Panel -->
        <div class="space-y-6">
            <!-- PDF Download Card -->
            @if($detailMateri->file_pdf)
            <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                    <span class="material-symbols-outlined mr-2 text-red-500">picture_as_pdf</span>
                    Lampiran PDF
                </h3>
                <a href="{{ asset('assets/pdf/'.$detailMateri->file_pdf) }}" target="_blank" class="w-full flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-xl hover:bg-red-100 transition-colors group">
                    <div class="flex-shrink-0 w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center group-hover:bg-red-200 transition-colors">
                        <span class="material-symbols-outlined text-2xl">download</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate">Download PDF</p>
                        <p class="text-xs text-slate-500 truncate">{{ $detailMateri->file_pdf }}</p>
                    </div>
                </a>
            </div>
            @endif

            <!-- Actions -->
            <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 p-6">
                <a href="{{ route('sub.materi', $detailMateri->id_material) }}" class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors shadow-md shadow-indigo-200">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    Selesai & Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
            <span class="material-symbols-outlined mr-2 text-slate-400">chat</span>
            Diskusi
        </h3>
        <div id="disqus_thread"></div>
        <script>
            var disqus_config = function () {
                this.page.url = "{{ route('show.materi', $detailMateri->id) }}";
                this.page.identifier = "PID_" + "{{ $detailMateri->id }}";
            };
            (function() {
                var d = document, s = d.createElement('script');
                s.src = 'https://webelearning.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    </div>
</div>
@endsection

@section('script')
<script>
    const _logId     = {{ $logId }};
    const _csrfToken = '{{ csrf_token() }}';

    function sendEndBeacon() {
        const data = new FormData();
        data.append('log_id', _logId);
        data.append('_token', _csrfToken);
        navigator.sendBeacon('{{ route('log.end') }}', data);
    }

    window.addEventListener('beforeunload', sendEndBeacon);
    window.addEventListener('pagehide', sendEndBeacon);
</script>
@endsection