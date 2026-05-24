@extends('user.layouts.headers')

@section('pageTitle', 'Semua Kelas')

@section('mainContent')
    <!-- Header Section -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Jelajahi Semua Kelas</h2>
            <p class="text-sm text-slate-500 mt-1">Temukan kelas yang sesuai dengan minat dan kebutuhanmu.</p>
        </div>
        <!-- Total Count Badge -->
        <span id="result-count" class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 rounded-full text-sm font-semibold border border-indigo-100 shrink-0">
            <span class="material-symbols-outlined text-[16px] mr-1.5">school</span>
            <span id="count-text">{{ count($material) }} Kelas</span>
        </span>
    </div>

    <!-- Search Bar -->
    <div class="mb-8">
        <div class="relative max-w-xl">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <span class="material-symbols-outlined text-xl" id="search-icon">search</span>
            </span>
            <input
                type="text"
                id="searchInput"
                placeholder="Cari judul kelas atau nama guru..."
                autocomplete="off"
                class="w-full pl-12 pr-12 py-3.5 border border-slate-200 rounded-2xl bg-white shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm text-slate-800 placeholder-slate-400"
            >
            <!-- Clear Button -->
            <button
                id="clearSearch"
                onclick="clearSearch()"
                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors opacity-0 pointer-events-none"
                title="Hapus pencarian"
            >
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>
        <!-- Filter Pills -->
        <div class="flex items-center gap-2 mt-3 flex-wrap">
            <span class="text-xs text-slate-400 font-medium">Filter cepat:</span>
            <button onclick="filterBy('judul')" class="filter-pill px-3 py-1.5 rounded-full text-xs font-semibold border border-slate-200 bg-white text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all" data-filter="judul">Judul Kelas</button>
            <button onclick="filterBy('guru')" class="filter-pill px-3 py-1.5 rounded-full text-xs font-semibold border border-slate-200 bg-white text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all" data-filter="guru">Nama Guru</button>
            <button onclick="filterBy('semua')" class="filter-pill active px-3 py-1.5 rounded-full text-xs font-semibold border border-indigo-200 bg-indigo-50 text-indigo-600 transition-all" data-filter="semua">Semua</button>
        </div>
    </div>

    @if(count($material) > 0)
        <!-- Grid Container -->
        <div id="kelas-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($material as $materi)
                <!-- Course Card — data attributes for JS search -->
                <div
                    class="kelas-card group bg-white rounded-2xl overflow-hidden shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex flex-col"
                    data-title="{{ strtolower($materi->material_title) }}"
                    data-guru="{{ strtolower($materi->userTeacher ? $materi->userTeacher->name : '') }}"
                >
                    <!-- Thumbnail -->
                    <div class="relative w-full pb-[56.25%] overflow-hidden bg-slate-100">
                        <img
                            src="{{ asset('assets/img/'.$materi->material_image) }}"
                            alt="{{ $materi->material_title }}"
                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        />
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300"></div>

                        <!-- Play overlay on hover -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                            <a href="{{ route('join.class', $materi->id) }}" class="h-12 w-12 bg-white/30 backdrop-blur-md rounded-full flex items-center justify-center text-white shadow-lg border border-white/20 hover:bg-white hover:text-indigo-600 transition-colors">
                                <span class="material-symbols-outlined ml-0.5">play_arrow</span>
                            </a>
                        </div>

                        <!-- Category label -->
                        <div class="absolute top-3 left-3 z-10">
                            <span class="px-2.5 py-1 bg-white/20 backdrop-blur-md text-white text-[11px] font-semibold rounded-full border border-white/30">
                                Kelas Online
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-5 flex-1 flex flex-col">
                        <a href="{{ route('join.class', $materi->id) }}" class="text-lg font-bold text-slate-800 hover:text-indigo-600 transition-colors line-clamp-2 mb-2 group-hover:underline decoration-indigo-200 underline-offset-4 card-title">
                            {{ $materi->material_title }}
                        </a>

                        @if($materi->description)
                        <p class="text-sm text-slate-500 line-clamp-2 mb-4">{{ $materi->description }}</p>
                        @endif

                        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-full overflow-hidden bg-slate-200 ring-2 ring-white shadow-sm">
                                    @if($materi->userTeacher && $materi->userTeacher->image_profile)
                                        <img src="{{ asset('assets/img/'.$materi->userTeacher->image_profile) }}" alt="Pemateri" class="h-full w-full object-cover">
                                    @else
                                        <img src="{{ 'https://ui-avatars.com/api/?name='.urlencode($materi->userTeacher ? $materi->userTeacher->name : 'P').'&background=6366f1&color=fff&bold=true' }}" alt="Pemateri" class="h-full w-full object-cover">
                                    @endif
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-700 leading-none card-guru">{{ $materi->userTeacher ? $materi->userTeacher->name : '-' }}</span>
                                    <span class="text-[11px] text-slate-400 mt-0.5">Pemateri</span>
                                </div>
                            </div>

                            <a href="{{ route('join.class', $materi->id) }}" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 text-xs font-semibold rounded-lg hover:bg-indigo-600 hover:text-white transition-colors">
                                Gabung
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- No Results State (hidden by default) -->
        <div id="no-results" class="hidden mt-8 w-full max-w-md mx-auto text-center py-16">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-indigo-50 mb-6">
                <span class="material-symbols-outlined text-4xl text-indigo-300">search_off</span>
            </div>
            <h3 class="text-xl font-bold text-slate-700 mb-2">Kelas Tidak Ditemukan</h3>
            <p class="text-slate-500 text-sm mb-6">Tidak ada kelas yang cocok dengan "<span id="search-query" class="font-semibold text-indigo-600"></span>".</p>
            <button onclick="clearSearch()" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-md shadow-indigo-200">
                <span class="material-symbols-outlined text-[18px] mr-1.5">restart_alt</span>
                Tampilkan Semua Kelas
            </button>
        </div>

        <!-- Pagination -->
        <div id="pagination-wrap" class="hidden mt-10">
            <div class="flex justify-center">
                <nav id="pagination-nav" class="inline-flex items-center gap-1" aria-label="Pagination Semua Kelas"></nav>
            </div>
            <p id="pagination-info" class="text-center text-xs text-slate-400 mt-3"></p>
        </div>

    @else
        <!-- Empty State -->
        <div class="w-full max-w-md mx-auto mt-16 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-100 mb-6">
                <span class="material-symbols-outlined text-4xl text-slate-400">school</span>
            </div>
            <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Kelas Tersedia</h3>
            <p class="text-slate-500 text-sm">Kelas belum ditambahkan oleh pengajar. Silakan periksa kembali nanti.</p>
        </div>
    @endif
@endsection

@section('script')
<script>
(function () {
    const searchInput  = document.getElementById('searchInput');
    const clearBtn     = document.getElementById('clearSearch');
    const noResults    = document.getElementById('no-results');
    const searchQuery  = document.getElementById('search-query');
    const countText    = document.getElementById('count-text');
    const grid         = document.getElementById('kelas-grid');
    const allCards     = Array.from(document.querySelectorAll('.kelas-card'));
    const totalCards   = allCards.length;

    const ITEMS_PER_PAGE = 9;
    let activeFilter = 'semua';
    let currentPage  = 1;

    // ── Pagination UI ──────────────────────────────────────────────
    const paginationWrap = document.getElementById('pagination-wrap');
    const paginationNav  = document.getElementById('pagination-nav');
    const paginationInfo = document.getElementById('pagination-info');

    function renderPagination(filteredCards) {
        const total = filteredCards.length;
        const totalPages = Math.ceil(total / ITEMS_PER_PAGE);

        // Hide pagination if only 1 page
        if (totalPages <= 1) {
            paginationWrap.classList.add('hidden');
            return;
        }
        paginationWrap.classList.remove('hidden');

        // Clamp currentPage
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        // Build nav HTML
        let html = '';

        // Prev
        if (currentPage === 1) {
            html += `<span class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-300 cursor-not-allowed select-none">
                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                     </span>`;
        } else {
            html += `<button onclick="goToPage(${currentPage - 1})" class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                     </button>`;
        }

        // Page numbers (with ellipsis for large page counts)
        const pages = getPageRange(currentPage, totalPages);
        pages.forEach(function(p) {
            if (p === '...') {
                html += `<span class="inline-flex items-center justify-center w-9 h-9 text-slate-400 text-sm select-none">…</span>`;
            } else if (p === currentPage) {
                html += `<span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-indigo-600 text-white text-sm font-semibold shadow-sm shadow-indigo-200 select-none">${p}</span>`;
            } else {
                html += `<button onclick="goToPage(${p})" class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-600 text-sm font-semibold hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all">${p}</button>`;
            }
        });

        // Next
        if (currentPage === totalPages) {
            html += `<span class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-300 cursor-not-allowed select-none">
                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                     </span>`;
        } else {
            html += `<button onclick="goToPage(${currentPage + 1})" class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                     </button>`;
        }

        paginationNav.innerHTML = html;

        // Info text
        const from = (currentPage - 1) * ITEMS_PER_PAGE + 1;
        const to   = Math.min(currentPage * ITEMS_PER_PAGE, total);
        paginationInfo.textContent = `Menampilkan ${from}–${to} dari ${total} kelas`;
    }

    function getPageRange(current, total) {
        if (total <= 7) {
            return Array.from({length: total}, function(_, i) { return i + 1; });
        }
        var pages = [];
        if (current <= 4) {
            for (var i = 1; i <= 5; i++) pages.push(i);
            pages.push('...');
            pages.push(total);
        } else if (current >= total - 3) {
            pages.push(1);
            pages.push('...');
            for (var i = total - 4; i <= total; i++) pages.push(i);
        } else {
            pages.push(1);
            pages.push('...');
            pages.push(current - 1);
            pages.push(current);
            pages.push(current + 1);
            pages.push('...');
            pages.push(total);
        }
        return pages;
    }

    window.goToPage = function(page) {
        currentPage = page;
        runSearch();
        // Smooth scroll to top of grid
        var gridTop = grid ? grid.getBoundingClientRect().top + window.scrollY - 80 : 0;
        window.scrollTo({ top: gridTop, behavior: 'smooth' });
    };

    // ── Search & Filter ────────────────────────────────────────────
    function runSearch() {
        var query = searchInput.value.trim().toLowerCase();

        // 1. Determine which cards match the search/filter
        var matched = [];
        allCards.forEach(function (card) {
            var title = card.dataset.title || '';
            var guru  = card.dataset.guru  || '';
            var match = false;
            if (activeFilter === 'judul') {
                match = title.includes(query);
            } else if (activeFilter === 'guru') {
                match = guru.includes(query);
            } else {
                match = title.includes(query) || guru.includes(query);
            }
            if (match) matched.push(card);
        });

        // 2. Hide all cards first
        allCards.forEach(function(card) { card.style.display = 'none'; });

        // 3. Show only the cards for the current page
        var start = (currentPage - 1) * ITEMS_PER_PAGE;
        var end   = start + ITEMS_PER_PAGE;
        var pageCards = matched.slice(start, end);

        pageCards.forEach(function(card) {
            card.style.display = '';
            highlightText(card.querySelector('.card-title'), query);
            highlightText(card.querySelector('.card-guru'),  query);
        });

        // 4. Update count badge
        if (query === '') {
            countText.textContent = totalCards + ' Kelas';
        } else {
            countText.textContent = matched.length + ' dari ' + totalCards + ' Kelas';
        }

        // 5. Toggle no-results
        if (matched.length === 0 && query !== '') {
            if (grid) grid.style.display = 'none';
            noResults.classList.remove('hidden');
            if (searchQuery) searchQuery.textContent = searchInput.value.trim();
            paginationWrap.classList.add('hidden');
        } else {
            if (grid) grid.style.display = '';
            noResults.classList.add('hidden');
            renderPagination(matched);
        }

        // 6. Show/hide clear button
        if (query !== '') {
            clearBtn.classList.remove('opacity-0', 'pointer-events-none');
        } else {
            clearBtn.classList.add('opacity-0', 'pointer-events-none');
        }
    }

    function highlightText(el, query) {
        if (!el) return;
        var original = el.dataset.original || el.textContent;
        el.dataset.original = original;
        if (!query) {
            el.innerHTML = original;
            return;
        }
        var regex = new RegExp('(' + query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
        el.innerHTML = original.replace(regex, '<mark class="bg-indigo-100 text-indigo-700 rounded px-0.5">$1</mark>');
    }

    // Debounce
    var debounceTimer;
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            currentPage = 1; // reset to page 1 on new search
            debounceTimer = setTimeout(runSearch, 180);
        });
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') clearSearch();
        });
    }

    window.clearSearch = function () {
        searchInput.value = '';
        currentPage = 1;
        runSearch();
        searchInput.focus();
    };

    window.filterBy = function (filter) {
        activeFilter = filter;
        currentPage  = 1; // reset to page 1 on filter change
        document.querySelectorAll('.filter-pill').forEach(function (pill) {
            var isActive = pill.dataset.filter === filter;
            pill.classList.toggle('active',            isActive);
            pill.classList.toggle('bg-indigo-50',      isActive);
            pill.classList.toggle('text-indigo-600',   isActive);
            pill.classList.toggle('border-indigo-200', isActive);
            pill.classList.toggle('bg-white',          !isActive);
            pill.classList.toggle('text-slate-600',    !isActive);
            pill.classList.toggle('border-slate-200',  !isActive);
        });
        runSearch();
        searchInput.focus();
        var placeholders = {
            judul: 'Cari berdasarkan judul kelas...',
            guru:  'Cari berdasarkan nama guru...',
            semua: 'Cari judul kelas atau nama guru...',
        };
        searchInput.placeholder = placeholders[filter] || placeholders.semua;
    };

    // Initial render
    runSearch();
})();
</script>
@endsection
