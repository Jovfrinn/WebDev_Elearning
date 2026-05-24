@extends('admin.layouts.headers')

@section('pageTitle', 'Buat Akun Guru')

@section('teacherContent')
<div class="max-w-2xl mx-auto">

    <!-- Back Link -->
    <a href="{{ route('get.teachers') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-rose-600 transition-colors mb-6 group">
        <span class="material-symbols-outlined text-[18px] mr-1.5 group-hover:-translate-x-1 transition-transform">arrow_back</span>
        Kembali ke Daftar Pengajar
    </a>

    <!-- Card -->
    <div class="bg-white rounded-3xl shadow-[0_4px_24px_-4px_rgba(0,0,0,0.08)] border border-slate-100 overflow-hidden">

        <!-- Card Header -->
        <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-xl bg-rose-50 flex items-center justify-center border border-rose-100">
                    <span class="material-symbols-outlined text-rose-600 text-[20px]">person_add</span>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-800 leading-tight">Buat Akun Guru Baru</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Isi formulir di bawah untuk mendaftarkan akun guru.</p>
                </div>
            </div>
            <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-700 text-xs font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                Perlu Verifikasi
            </span>
        </div>

        <!-- Info Banner -->
        <div class="mx-8 mt-6 flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
            <span class="material-symbols-outlined text-amber-500 text-[20px] mt-0.5 shrink-0">info</span>
            <p class="text-sm text-amber-700 leading-relaxed">
                Setelah akun dibuat, guru dapat langsung login menggunakan email & password yang Anda tentukan.
                Status akun akan <strong>menunggu verifikasi</strong> — Anda dapat memverifikasinya di halaman <strong>Verifikasi Pengajar</strong>.
            </p>
        </div>

        <!-- Form -->
        <form action="{{ route('store.teacher') }}" method="POST" class="px-8 py-7 space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <span class="material-symbols-outlined text-xl">badge</span>
                    </span>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Dr. Budi Santoso"
                        class="w-full pl-12 pr-4 py-3 border rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all text-sm text-slate-800 placeholder-slate-400 {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}"
                    >
                </div>
                @error('name')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Alamat Email <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <span class="material-symbols-outlined text-xl">mail</span>
                    </span>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="guru@sekolah.com"
                        class="w-full pl-12 pr-4 py-3 border rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all text-sm text-slate-800 placeholder-slate-400 {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}"
                    >
                </div>
                @error('email')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- NIP -->
            <div>
                <label for="nip" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    NIP <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <span class="material-symbols-outlined text-xl">tag</span>
                    </span>
                    <input
                        type="text"
                        id="nip"
                        name="nip"
                        value="{{ old('nip') }}"
                        placeholder="Contoh: 198701012010011001"
                        class="w-full pl-12 pr-4 py-3 border rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all text-sm text-slate-800 placeholder-slate-400 {{ $errors->has('nip') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}"
                    >
                </div>
                @error('nip')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-100 pt-2">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Keamanan Akun</p>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Password <span class="text-rose-500">*</span>
                </label>
                <div class="relative" x-data="{ show: false }">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <span class="material-symbols-outlined text-xl">lock</span>
                    </span>
                    <input
                        :type="show ? 'text' : 'password'"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        class="w-full pl-12 pr-12 py-3 border rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all text-sm text-slate-800 placeholder-slate-400 {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}"
                    >
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                        <span class="material-symbols-outlined text-xl" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password Confirm -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Konfirmasi Password <span class="text-rose-500">*</span>
                </label>
                <div class="relative" x-data="{ show: false }">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <span class="material-symbols-outlined text-xl">lock_reset</span>
                    </span>
                    <input
                        :type="show ? 'text' : 'password'"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ulangi password di atas"
                        class="w-full pl-12 pr-12 py-3 border rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all text-sm text-slate-800 placeholder-slate-400 border-slate-200"
                    >
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                        <span class="material-symbols-outlined text-xl" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                    </button>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-2 flex items-center gap-3">
                <button
                    type="submit"
                    class="flex-1 sm:flex-none inline-flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-700 hover:to-pink-700 text-white font-semibold rounded-xl shadow-lg shadow-rose-200 hover:shadow-rose-300 transition-all duration-200 text-sm group"
                >
                    <span class="material-symbols-outlined mr-2 group-hover:scale-110 transition-transform">person_add</span>
                    Buat Akun Guru
                </button>
                <a href="{{ route('get.teachers') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3.5 border border-slate-200 text-slate-600 font-medium rounded-xl hover:bg-slate-50 transition-colors text-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
