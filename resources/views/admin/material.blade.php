@extends('admin.layouts.headers')

@section('pageTitle', 'Semua Materi')

@section('teacherContent')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Semua Materi</h2>
            <p class="text-sm text-slate-500 mt-1">Lihat seluruh materi yang tersedia di platform EduVortex.</p>
        </div>
        <span class="inline-flex items-center px-4 py-2 bg-rose-50 text-rose-700 rounded-full text-sm font-semibold border border-rose-100">
            <span class="material-symbols-outlined text-[18px] mr-1.5">book</span>
            {{ count($materials) }} Materi
        </span>
    </div>

    <!-- Search Bar -->
    <div class="mb-6">
        <div class="relative max-w-md">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <span class="material-symbols-outlined text-xl">search</span>
            </span>
            <input type="text" id="searchInput" placeholder="Cari judul materi atau nama pengajar..."
                class="w-full pl-12 pr-4 py-3 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-colors text-sm text-slate-800 placeholder-slate-400 shadow-sm">
        </div>
    </div>

    @if(count($materials) > 0)
    <!-- Grid Container -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8" id="materiGrid">
        @foreach ($materials as $material)
        <div class="group bg-white rounded-2xl overflow-hidden shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex flex-col searchable-card">
            <!-- Thumbnail -->
            <div class="relative w-full pb-[56.25%] overflow-hidden bg-slate-100">
                <img src="{{ asset('/assets/img/'.$material->material_image) }}" alt="{{ $material->material_title }}"
                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-slate-900/20 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300"></div>
            </div>

            <!-- Content -->
            <div class="p-5 flex-1 flex flex-col">
                <h3 class="text-lg font-bold text-slate-800 line-clamp-2 mb-2 searchable-title">
                    {{ $material->material_title }}
                </h3>

                <div class="mt-auto pt-4 border-t border-slate-100 flex items-center gap-3">
                    <div class="h-8 w-8 rounded-full overflow-hidden bg-slate-200 ring-2 ring-white shadow-sm">
                        @if($material->userTeacher && $material->userTeacher->image_profile)
                            <img src="{{ asset('assets/img/'.$material->userTeacher->image_profile) }}" alt="Pemateri" class="h-full w-full object-cover">
                        @else
                            <img src="{{ asset('assets/img/profileDefault.jpeg') }}" alt="Pemateri" class="h-full w-full object-cover">
                        @endif
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-slate-700 leading-none searchable-teacher">{{ $material->userTeacher->name }}</span>
                        <span class="text-[11px] text-slate-400 mt-0.5">Pemateri</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <!-- Empty State -->
    <div class="w-full max-w-md mx-auto mt-16 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-100 mb-6">
            <span class="material-symbols-outlined text-4xl text-slate-400">menu_book</span>
        </div>
        <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Materi</h3>
        <p class="text-slate-500 text-sm">Belum ada materi yang ditambahkan oleh pengajar.</p>
    </div>
    @endif

    <!-- Pagination -->
    <div id="pagination-wrap" class="hidden mt-8">
        <div class="flex justify-center">
            <nav id="pagination-nav" class="inline-flex items-center gap-1" aria-label="Pagination Materi"></nav>
        </div>
        <p id="pagination-info" class="text-center text-xs text-slate-400 mt-2"></p>
    </div>
</div>
@endsection

@section('script')
<script>
(function () {
    const searchInput    = document.getElementById('searchInput');
    const allCards       = Array.from(document.querySelectorAll('.searchable-card'));
    const totalCount     = allCards.length;
    const paginationWrap = document.getElementById('pagination-wrap');
    const paginationNav  = document.getElementById('pagination-nav');
    const paginationInfo = document.getElementById('pagination-info');
    const ITEMS_PER_PAGE = 9;
    let currentPage = 1;

    function getMatched() {
        const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
        if (!query) return allCards;
        return allCards.filter(function(card) {
            const title   = card.querySelector('.searchable-title')?.textContent.toLowerCase()   || '';
            const teacher = card.querySelector('.searchable-teacher')?.textContent.toLowerCase() || '';
            return title.includes(query) || teacher.includes(query);
        });
    }

    function renderPage() {
        const matched    = getMatched();
        const total      = matched.length;
        const totalPages = Math.ceil(total / ITEMS_PER_PAGE) || 1;
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        allCards.forEach(function(c) { c.style.display = 'none'; });
        matched.slice((currentPage - 1) * ITEMS_PER_PAGE, currentPage * ITEMS_PER_PAGE)
               .forEach(function(c) { c.style.display = ''; });

        if (totalPages <= 1) { paginationWrap.classList.add('hidden'); return; }
        paginationWrap.classList.remove('hidden');

        var html = '';
        if (currentPage === 1) {
            html += `<span class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-300 cursor-not-allowed select-none"><span class="material-symbols-outlined text-[18px]">chevron_left</span></span>`;
        } else {
            html += `<button onclick="goToPage(${currentPage-1})" class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all"><span class="material-symbols-outlined text-[18px]">chevron_left</span></button>`;
        }
        getPageRange(currentPage, totalPages).forEach(function(p) {
            if (p === '...') {
                html += `<span class="inline-flex items-center justify-center w-9 h-9 text-slate-400 text-sm select-none">…</span>`;
            } else if (p === currentPage) {
                html += `<span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-rose-600 text-white text-sm font-semibold shadow-sm select-none">${p}</span>`;
            } else {
                html += `<button onclick="goToPage(${p})" class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-600 text-sm font-semibold hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all">${p}</button>`;
            }
        });
        if (currentPage === totalPages) {
            html += `<span class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-300 cursor-not-allowed select-none"><span class="material-symbols-outlined text-[18px]">chevron_right</span></span>`;
        } else {
            html += `<button onclick="goToPage(${currentPage+1})" class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all"><span class="material-symbols-outlined text-[18px]">chevron_right</span></button>`;
        }
        paginationNav.innerHTML = html;

        var from = (currentPage - 1) * ITEMS_PER_PAGE + 1;
        var to   = Math.min(currentPage * ITEMS_PER_PAGE, total);
        paginationInfo.textContent = 'Menampilkan ' + from + '–' + to + ' dari ' + total + ' materi';
    }

    function getPageRange(cur, tot) {
        if (tot <= 7) return Array.from({length: tot}, function(_, i){ return i+1; });
        var p = [];
        if (cur <= 4) { for(var i=1;i<=5;i++) p.push(i); p.push('...'); p.push(tot); }
        else if (cur >= tot-3) { p.push(1); p.push('...'); for(var i=tot-4;i<=tot;i++) p.push(i); }
        else { p.push(1); p.push('...'); p.push(cur-1); p.push(cur); p.push(cur+1); p.push('...'); p.push(tot); }
        return p;
    }

    window.goToPage = function(page) { currentPage = page; renderPage(); };

    if (searchInput) {
        var debounce;
        searchInput.addEventListener('input', function() {
            clearTimeout(debounce);
            debounce = setTimeout(function() { currentPage = 1; renderPage(); }, 180);
        });
    }

    renderPage();
})();
</script>
@endsection