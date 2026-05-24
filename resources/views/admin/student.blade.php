@extends('admin.layouts.headers')

@section('pageTitle', 'Data Peserta')

@section('teacherContent')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Data Peserta</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola seluruh akun peserta yang terdaftar di EduVortex.</p>
        </div>
        <span class="inline-flex items-center px-4 py-2 bg-rose-50 text-rose-700 rounded-full text-sm font-semibold border border-rose-100">
            <span class="material-symbols-outlined text-[18px] mr-1.5">people</span>
            {{ $count }} Peserta
        </span>
    </div>

    <!-- Search Bar -->
    <div class="mb-6">
        <div class="relative max-w-md">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <span class="material-symbols-outlined text-xl">search</span>
            </span>
            <input type="text" id="searchInput" placeholder="Cari nama atau email peserta..."
                class="w-full pl-12 pr-4 py-3 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-colors text-sm text-slate-800 placeholder-slate-400 shadow-sm">
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="dataTable">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-16">No</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Profil</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @if(count($students) == 0)
                    <tr>
                        <td colspan="5" class="py-12 px-6 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-3">
                                <span class="material-symbols-outlined text-3xl text-slate-400">group_off</span>
                            </div>
                            <p class="font-medium text-slate-600">Belum ada peserta terdaftar.</p>
                        </td>
                    </tr>
                    @else
                    @php $no = 1; @endphp
                    @foreach ($students as $student)
                    <tr class="hover:bg-slate-50/80 transition-colors searchable-row">
                        <td class="py-4 px-6 text-sm text-slate-600 font-medium">{{ $no++ }}</td>
                        <td class="py-4 px-6">
                            <div class="h-10 w-10 rounded-full overflow-hidden border-2 border-slate-100 shadow-sm">
                                @if($student->image_profile == NULL)
                                <img src="{{ asset('assets/img/profileDefault.jpeg') }}" alt="Default" class="h-full w-full object-cover">
                                @else
                                <img src="{{ asset('assets/img/'.$student->image_profile) }}" alt="{{ $student->name }}" class="h-full w-full object-cover">
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-sm font-semibold text-slate-800 searchable-name">{{ $student->name }}</p>
                        </td>
                        <td class="py-4 px-6">
                            <p class="text-sm text-slate-600 searchable-email">{{ $student->email }}</p>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <button onclick="return confirm('Apakah Anda yakin ingin menghapus peserta ini?')" class="px-4 py-2 border border-red-200 text-red-600 text-xs font-semibold rounded-lg hover:bg-red-50 hover:border-red-300 transition-colors inline-flex items-center">
                                <span class="material-symbols-outlined text-[16px] mr-1">delete</span>
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div id="pagination-wrap" class="hidden mt-6">
        <div class="flex justify-center">
            <nav id="pagination-nav" class="inline-flex items-center gap-1" aria-label="Pagination Peserta"></nav>
        </div>
        <p id="pagination-info" class="text-center text-xs text-slate-400 mt-2"></p>
    </div>
</div>
@endsection

@section('script')
<script>
(function () {
    const searchInput   = document.getElementById('searchInput');
    const allRows       = Array.from(document.querySelectorAll('.searchable-row'));
    const paginationWrap = document.getElementById('pagination-wrap');
    const paginationNav  = document.getElementById('pagination-nav');
    const paginationInfo = document.getElementById('pagination-info');
    const ITEMS_PER_PAGE = 9;
    let currentPage = 1;

    function getMatched() {
        const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
        if (!query) return allRows;
        return allRows.filter(function(row) {
            const name  = row.querySelector('.searchable-name')?.textContent.toLowerCase()  || '';
            const email = row.querySelector('.searchable-email')?.textContent.toLowerCase() || '';
            return name.includes(query) || email.includes(query);
        });
    }

    function renderPage() {
        const matched    = getMatched();
        const total      = matched.length;
        const totalPages = Math.ceil(total / ITEMS_PER_PAGE) || 1;
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        // Hide all, show only current page slice
        allRows.forEach(function(r) { r.style.display = 'none'; });
        matched.slice((currentPage - 1) * ITEMS_PER_PAGE, currentPage * ITEMS_PER_PAGE)
               .forEach(function(r) { r.style.display = ''; });

        // Update row numbers
        var visibleNo = (currentPage - 1) * ITEMS_PER_PAGE + 1;
        matched.slice((currentPage - 1) * ITEMS_PER_PAGE, currentPage * ITEMS_PER_PAGE).forEach(function(r) {
            var noCell = r.querySelector('td:first-child');
            if (noCell) noCell.textContent = visibleNo++;
        });

        // Render pagination nav
        if (totalPages <= 1) {
            paginationWrap.classList.add('hidden');
            return;
        }
        paginationWrap.classList.remove('hidden');

        var html = '';
        // Prev
        if (currentPage === 1) {
            html += `<span class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-300 cursor-not-allowed select-none"><span class="material-symbols-outlined text-[18px]">chevron_left</span></span>`;
        } else {
            html += `<button onclick="goToPage(${currentPage-1})" class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all"><span class="material-symbols-outlined text-[18px]">chevron_left</span></button>`;
        }
        // Pages
        getPageRange(currentPage, totalPages).forEach(function(p) {
            if (p === '...') {
                html += `<span class="inline-flex items-center justify-center w-9 h-9 text-slate-400 text-sm select-none">…</span>`;
            } else if (p === currentPage) {
                html += `<span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-rose-600 text-white text-sm font-semibold shadow-sm select-none">${p}</span>`;
            } else {
                html += `<button onclick="goToPage(${p})" class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-600 text-sm font-semibold hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all">${p}</button>`;
            }
        });
        // Next
        if (currentPage === totalPages) {
            html += `<span class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-300 cursor-not-allowed select-none"><span class="material-symbols-outlined text-[18px]">chevron_right</span></span>`;
        } else {
            html += `<button onclick="goToPage(${currentPage+1})" class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all"><span class="material-symbols-outlined text-[18px]">chevron_right</span></button>`;
        }
        paginationNav.innerHTML = html;

        var from = (currentPage - 1) * ITEMS_PER_PAGE + 1;
        var to   = Math.min(currentPage * ITEMS_PER_PAGE, total);
        paginationInfo.textContent = 'Menampilkan ' + from + '–' + to + ' dari ' + total + ' peserta';
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