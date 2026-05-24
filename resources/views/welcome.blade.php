<!DOCTYPE html>
<html lang="id" class="antialiased scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduVortex - Platform Belajar Masa Depan</title>
    
    <link rel="shortcut icon" href="{{asset('assets/img/eduvortex.png')}}" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <!-- Vite for Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans text-slate-900 bg-slate-50 relative overflow-x-hidden">

    <!-- Background Elements -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute top-[-20%] right-[-10%] w-[50%] h-[50%] rounded-full bg-slate-300/20 blur-[120px] animate-pulse" style="animation-duration: 8s;"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-indigo-200/20 blur-[100px] animate-pulse" style="animation-duration: 12s;"></div>
    </div>

    <!-- Navigation -->
    <nav x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)" 
         :class="{ 'bg-white/80 backdrop-blur-md border-b border-slate-200/50 shadow-sm': scrolled, 'bg-transparent': !scrolled }"
         class="fixed w-full top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <img src="{{asset('assets/img/vortex.png')}}" alt="EduVortex" class="h-10 w-10 mr-3">
                    <span class="text-2xl font-bold text-slate-800 tracking-tight">EduVortex</span>
                </div>
                
                <!-- Auth Buttons -->
                <div class="hidden sm:flex items-center space-x-4">
                    @auth
                        <a href="{{ route('get.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition-colors">Ke Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-700 font-medium transition-colors">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-full bg-indigo-700 text-white font-medium hover:bg-indigo-800 transition-all duration-300 transform hover:-translate-y-0.5 shadow-sm">Daftar Gratis</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="relative z-10 pt-32 pb-16 sm:pt-40 sm:pb-24 lg:pb-32 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto flex flex-col lg:flex-row items-center">
        <!-- Text Content -->
        <div class="text-center lg:text-left lg:w-1/2 lg:pr-12">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-sm font-semibold mb-6">
                <span class="flex h-2 w-2 rounded-full bg-indigo-500 mr-2"></span>
                Platform Edukasi Terpadu
            </div>
            
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight text-slate-900 mb-6 leading-tight">
                Belajar Jadi <br class="hidden sm:block">
                <span class="text-indigo-700">Lebih Mudah</span>
            </h1>
            
            <p class="mt-4 text-lg sm:text-xl text-slate-500 max-w-2xl mx-auto lg:mx-0 mb-10 leading-relaxed">
                Tingkatkan skill dan pengetahuan Anda bersama pengajar terbaik di EduVortex. Akses materi interaktif, kuis menantang, dan kelas berkualitas kapan saja, di mana saja.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                <a href="{{ auth()->check() ? route('get.index') : route('register') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-indigo-700 text-white text-lg font-semibold hover:bg-indigo-800 transition-all duration-300 flex items-center justify-center transform hover:-translate-y-1 shadow-md">
                    Mulai Belajar Sekarang
                    <span class="material-symbols-outlined ml-2">arrow_forward</span>
                </a>
                
                <a href="#features" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white border border-slate-200 text-slate-700 text-lg font-semibold hover:bg-slate-50 hover:border-slate-300 transition-all duration-300 flex items-center justify-center">
                    Pelajari Fitur
                </a>
            </div>
        </div>

        <!-- Illustration / Graphic -->
        <div class="lg:w-1/2 mt-16 lg:mt-0 relative">
            <div class="relative w-full max-w-lg mx-auto">
                <!-- Abstract Floating Cards -->
                <div class="absolute top-0 -left-4 w-72 h-72 bg-slate-300 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob"></div>
                <div class="absolute top-0 -right-4 w-72 h-72 bg-indigo-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-8 left-20 w-72 h-72 bg-sky-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob animation-delay-4000"></div>
                
                <!-- Main Mockup Image (Glassmorphism representation) -->
                <div class="relative bg-white/40 backdrop-blur-xl border border-white/60 rounded-3xl p-6 shadow-2xl shadow-indigo-200/50 transform rotate-[-2deg] hover:rotate-0 transition-transform duration-500">
                    <div class="bg-slate-100 rounded-2xl h-64 sm:h-80 w-full overflow-hidden flex items-center justify-center relative">
                        <img src="{{asset('assets/img/ukm.jpg')}}" alt="Edukasi" class="object-cover w-full h-full opacity-90">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <div class="h-4 w-1/3 bg-white/80 rounded-full mb-3"></div>
                            <div class="h-3 w-2/3 bg-white/60 rounded-full"></div>
                        </div>
                    </div>
                    
                    <!-- Floating small card -->
                    <div class="absolute -right-6 -top-6 bg-white rounded-2xl p-4 shadow-xl border border-slate-100 flex items-center gap-4 animate-bounce" style="animation-duration: 3s;">
                        <div class="h-12 w-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <span class="material-symbols-outlined text-2xl">verified</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Materi Teruji</p>
                            <p class="text-xs text-slate-500">100+ Kelas Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
