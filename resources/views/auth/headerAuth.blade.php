<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'EduVortex')</title>
    
    <link rel="shortcut icon" href="{{asset('assets/img/eduvortex.png')}}" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <!-- Vite for Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-slate-900 bg-slate-50 relative min-h-screen flex items-start justify-center overflow-x-hidden py-12 px-4 sm:px-6 lg:px-8">
    
    <!-- Abstract Modern Background -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-indigo-500/20 blur-[100px] animate-pulse" style="animation-duration: 8s;"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-violet-500/20 blur-[120px] animate-pulse" style="animation-duration: 12s;"></div>
        <div class="absolute top-[20%] right-[10%] w-[30%] h-[30%] rounded-full bg-pink-500/10 blur-[80px] animate-pulse" style="animation-duration: 10s;"></div>
    </div>

    <!-- Main Content Area -->
    <div class="relative z-10 w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center">
                <img src="{{asset('assets/img/vortex.png')}}" alt="EduVortex Logo" class="h-12 w-12 mr-3 drop-shadow-md">
                <span class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-600 tracking-tight">EduVortex</span>
            </a>
        </div>

        <!-- Yield Auth Card -->
        @yield('content')
        
    </div>

</body>
</html>