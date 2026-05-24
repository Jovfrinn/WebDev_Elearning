@extends('auth.headerAuth')

@section('title', 'Daftar - EduVortex')

@section('content')
    <!-- Glassmorphism Card -->
    <div class="bg-white/80 backdrop-blur-xl border border-white/60 shadow-2xl shadow-indigo-200/50 rounded-3xl p-8 sm:p-10 w-full max-w-md mx-auto">
        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Buat Akun Baru</h2>
            <p class="text-sm text-slate-500 mt-2">Mulai perjalanan belajarmu bersama kami.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 text-sm">person</span>
                    </div>
                    <input type="text" id="name" name="name" :value="old('name')" required autofocus autocomplete="name" 
                        class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl bg-white/50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors text-slate-800 placeholder-slate-400" placeholder="John Doe">
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 text-sm">mail</span>
                    </div>
                    <input type="email" id="email" name="email" :value="old('email')" required autocomplete="username" 
                        class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl bg-white/50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors text-slate-800 placeholder-slate-400" placeholder="nama@email.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 text-sm">lock</span>
                    </div>
                    <input type="password" id="password" name="password" required autocomplete="new-password" 
                        class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl bg-white/50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors text-slate-800 placeholder-slate-400" placeholder="••••••••">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 text-sm">lock_reset</span>
                    </div>
                    <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" 
                        class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl bg-white/50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors text-slate-800 placeholder-slate-400" placeholder="••••••••">
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 mt-6">
                Daftar
            </button>
        </form>

        <!-- Login Link -->
        <p class="mt-6 text-center text-sm text-slate-500">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">Masuk di sini</a>
        </p>
    </div>
@endsection