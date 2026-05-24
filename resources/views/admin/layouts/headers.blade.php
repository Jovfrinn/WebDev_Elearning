<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard - EduVortex</title>
    <link rel="shortcut icon" href="{{asset('assets/img/eduvortex.png')}}" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <!-- Vite for Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js (Bundled in Vite) -->

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('/assets/css/admin/style.css')}}" />
</head>
<body class="bg-slate-50 text-slate-900 font-sans flex h-screen overflow-hidden" x-data="{ sidebarOpen: false, sidebarMini: localStorage.getItem('sidebarMini') === 'true' }" x-init="$watch('sidebarMini', value => localStorage.setItem('sidebarMini', value))">

    <!-- Mobile sidebar backdrop -->
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-20 bg-slate-900/50 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false" style="display: none;"></div>

    <!-- Sidebar -->
    <aside :class="(sidebarOpen ? 'translate-x-0' : '-translate-x-full') + (sidebarMini ? ' lg:w-20 w-64' : ' w-64')" class="fixed inset-y-0 left-0 z-30 bg-white border-r border-slate-200 transition-all duration-300 lg:translate-x-0 lg:static lg:inset-auto flex flex-col h-full shadow-sm overflow-hidden shrink-0">
        <!-- Logo -->
        <div class="flex items-center h-16 border-b border-slate-100 px-6 shrink-0" :class="sidebarMini ? 'lg:justify-center lg:px-0' : 'justify-center'">
            <img src="{{asset('assets/img/vortex.png')}}" alt="EduVortex Logo" class="h-8 w-8 drop-shadow-sm" :class="sidebarMini ? 'mr-0' : 'mr-3'">
            <a href="{{route('admin')}}" class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-rose-600 to-pink-600 whitespace-nowrap" :class="sidebarMini ? 'lg:hidden' : ''">AdminPanel</a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto overflow-x-hidden">
            <a href="{{route('admin')}}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ Route::currentRouteName() == 'admin' ? 'bg-rose-50 text-rose-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}" :class="sidebarMini ? 'lg:justify-center lg:px-0' : ''" title="Beranda">
                <span class="material-symbols-outlined {{ Route::currentRouteName() == 'admin' ? 'text-rose-600' : 'text-slate-400 group-hover:text-rose-500 transition-colors' }}" :class="sidebarMini ? 'mr-0' : 'mr-3'">dashboard</span>
                <span :class="sidebarMini ? 'lg:hidden' : ''" class="whitespace-nowrap">Beranda</span>
            </a>
            
            <a href="{{route('get.student')}}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ Route::currentRouteName() == 'get.student' ? 'bg-rose-50 text-rose-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}" :class="sidebarMini ? 'lg:justify-center lg:px-0' : ''" title="Peserta">
                <span class="material-symbols-outlined {{ Route::currentRouteName() == 'get.student' ? 'text-rose-600' : 'text-slate-400 group-hover:text-rose-500 transition-colors' }}" :class="sidebarMini ? 'mr-0' : 'mr-3'">people</span>
                <span :class="sidebarMini ? 'lg:hidden' : ''" class="whitespace-nowrap">Peserta</span>
            </a>

            <a href="{{route('get.materi')}}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ Route::currentRouteName() == 'get.materi' ? 'bg-rose-50 text-rose-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}" :class="sidebarMini ? 'lg:justify-center lg:px-0' : ''" title="Materi">
                <span class="material-symbols-outlined {{ Route::currentRouteName() == 'get.materi' ? 'text-rose-600' : 'text-slate-400 group-hover:text-rose-500 transition-colors' }}" :class="sidebarMini ? 'mr-0' : 'mr-3'">book</span>
                <span :class="sidebarMini ? 'lg:hidden' : ''" class="whitespace-nowrap">Materi</span>
            </a>

            <a href="{{route('get.teachers')}}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ Route::currentRouteName() == 'get.teachers' ? 'bg-rose-50 text-rose-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}" :class="sidebarMini ? 'lg:justify-center lg:px-0' : ''" title="Pengajar">
                <span class="material-symbols-outlined {{ Route::currentRouteName() == 'get.teachers' ? 'text-rose-600' : 'text-slate-400 group-hover:text-rose-500 transition-colors' }}" :class="sidebarMini ? 'mr-0' : 'mr-3'">school</span>
                <span :class="sidebarMini ? 'lg:hidden' : ''" class="whitespace-nowrap">Pengajar</span>
            </a>

            <a href="{{route('get.teacher')}}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ Route::currentRouteName() == 'get.teacher' ? 'bg-rose-50 text-rose-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}" :class="sidebarMini ? 'lg:justify-center lg:px-0' : ''" title="Verifikasi Pengajar">
                <span class="material-symbols-outlined {{ Route::currentRouteName() == 'get.teacher' ? 'text-rose-600' : 'text-slate-400 group-hover:text-rose-500 transition-colors' }}" :class="sidebarMini ? 'mr-0' : 'mr-3'">how_to_reg</span>
                <span :class="sidebarMini ? 'lg:hidden' : ''" class="whitespace-nowrap">Verifikasi Pengajar</span>
            </a>

            <div class="pt-4 mt-4 border-t border-slate-100">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3 whitespace-nowrap" :class="sidebarMini ? 'lg:hidden px-4' : 'px-4'">Akun</p>
                <a href="{{route('profile')}}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ Route::currentRouteName() == 'profile' ? 'bg-rose-50 text-rose-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}" :class="sidebarMini ? 'lg:justify-center lg:px-0' : ''" title="Setting">
                    <span class="material-symbols-outlined {{ Route::currentRouteName() == 'profile' ? 'text-rose-600' : 'text-slate-400 group-hover:text-rose-500 transition-colors' }}" :class="sidebarMini ? 'mr-0' : 'mr-3'">settings</span>
                    <span :class="sidebarMini ? 'lg:hidden' : ''" class="whitespace-nowrap">Setting</span>
                </a>
            </div>
        </nav>

        <!-- Footer / Logout -->
        <div class="p-4 border-t border-slate-100 shrink-0 flex items-center justify-center">
            @if(auth()->check())
            <form id="logout-form" action="{{route('logout')}}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center py-3 text-red-600 rounded-xl hover:bg-red-50 transition-colors duration-200 font-medium group" :class="sidebarMini ? 'lg:justify-center px-0' : 'px-4'" title="Logout">
                    <span class="material-symbols-outlined group-hover:scale-110 transition-transform" :class="sidebarMini ? 'mr-0' : 'mr-3'">logout</span>
                    <span :class="sidebarMini ? 'lg:hidden' : ''" class="whitespace-nowrap">Logout</span>
                </button>
            </form>
            @else
            <a href="{{route('login')}}" class="w-full flex items-center justify-center py-3 bg-gradient-to-r from-rose-600 to-pink-600 text-white rounded-xl hover:from-rose-700 hover:to-pink-700 transition-all duration-200 font-medium shadow-md shadow-rose-200" :class="sidebarMini ? 'lg:px-0 px-4' : 'px-4'" title="Login">
                <span class="material-symbols-outlined" :class="sidebarMini ? 'lg:block hidden' : 'hidden'">login</span>
                <span :class="sidebarMini ? 'lg:hidden' : ''" class="whitespace-nowrap">Login</span>
            </a>
            @endif
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-full overflow-hidden w-full relative">
        <!-- Top Navbar -->
        <header class="sticky top-0 z-10 bg-white/70 backdrop-blur-md border-b border-slate-200 shadow-sm shrink-0">
            <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center">
                    <!-- Mobile Hamburger -->
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 mr-4 text-slate-500 rounded-lg lg:hidden hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-rose-500 transition-colors">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <!-- Desktop Minimize Toggle -->
                    <button @click="sidebarMini = !sidebarMini" class="p-2 mr-4 text-slate-500 rounded-lg hidden lg:block hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-rose-500 transition-colors" title="Toggle Sidebar">
                        <span class="material-symbols-outlined transition-transform duration-300" :class="sidebarMini ? 'rotate-180' : ''">menu_open</span>
                    </button>
                    
                    <h1 class="text-xl font-semibold text-slate-800 tracking-tight hidden sm:block">
                        @yield('pageTitle', 'Dashboard Admin')
                    </h1>
                </div>

                <!-- Profile Area -->
                <div class="flex items-center gap-4">
                    <!-- Notification Bell -->
                    <button class="p-2 text-slate-400 hover:text-rose-600 transition-colors relative rounded-full hover:bg-rose-50">
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                    </button>

                    <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

                    @if(auth()->check())
                        <div class="flex items-center gap-3 cursor-pointer p-1 rounded-full sm:pr-3 hover:bg-slate-100 transition-colors group">
                            <div class="h-9 w-9 rounded-full overflow-hidden border-2 border-rose-100 group-hover:border-rose-300 transition-colors shadow-sm">
                                @if(auth()->user()->image_profile)
                                    <img src="{{asset('assets/img/'.auth()->user()->image_profile)}}" alt="Profile" class="h-full w-full object-cover">
                                @else
                                    <img src="{{asset('assets/img/profileDefault.jpeg')}}" alt="Profile" class="h-full w-full object-cover">
                                @endif
                            </div>
                            <span class="text-sm font-medium text-slate-700 hidden sm:block group-hover:text-rose-700 transition-colors">{{ auth()->user()->name }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto bg-slate-50/50">
            <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">
                @yield('teacherContent') <!-- Reusing the same yield name to avoid breaking pages -->
            </div>
        </main>
    </div>

    @yield('script')
</body>
</html>
