@php
    $layout = 'user.layouts.headers';
    $sectionName = 'mainContent';

    if(auth()->check()) {
        if(auth()->user()->id_role == 3) {
            $layout = 'admin.layouts.headers';
            $sectionName = 'teacherContent';
        } elseif(auth()->user()->id_role == 2) {
            $layout = 'teacher.layouts.headers';
            $sectionName = 'teacherContent';
        }
    }
@endphp

@extends($layout)

@section('pageTitle', 'Pengaturan Profil')

@section($sectionName)
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    
    <!-- Header Page -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Profil Anda</h2>
        <p class="text-sm text-slate-500 mt-1">Perbarui informasi akun dan alamat email Anda.</p>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition.opacity class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center justify-between">
            <div class="flex items-center">
                <span class="material-symbols-outlined mr-2">check_circle</span>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    @endif

    <!-- Profile Form Card -->
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 overflow-hidden">
        <form action="{{route('profile.update', $user->id)}}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
            @csrf
            @method('PUT')

            <!-- Avatar Section -->
            <div class="flex flex-col sm:flex-row items-center gap-6 mb-8 pb-8 border-b border-slate-100">
                <div class="relative group">
                    <div class="h-24 w-24 rounded-full overflow-hidden border-4 border-slate-50 shadow-md">
                        @if ($user->image_profile == null)
                            <img src="{{asset('assets/img/profileDefault.jpeg')}}" alt="Default Profile" class="h-full w-full object-cover">
                        @else
                            <img src="{{asset('assets/img/'.$user->image_profile)}}" alt="Your Profile" class="h-full w-full object-cover">
                        @endif
                    </div>
                    
                    <!-- Overlay for upload -->
                    <label for="fileInput" class="absolute inset-0 bg-slate-900/50 rounded-full flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity duration-200">
                        <span class="material-symbols-outlined text-white text-xl">photo_camera</span>
                        <span class="text-white text-[10px] font-medium mt-1 uppercase tracking-wider">Ubah</span>
                    </label>
                    <input type="file" id="fileInput" name="image" class="hidden" accept="image/*">
                </div>
                
                <div class="text-center sm:text-left">
                    <h3 class="text-lg font-bold text-slate-800">{{ $user->name }}</h3>
                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                    <p class="text-xs text-slate-400 mt-2">Format gambar yang didukung: JPG, PNG, JPEG.</p>
                </div>
            </div>

            <!-- Inputs Section -->
            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" value="{{ $user->name }}" 
                        class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors text-slate-800">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ $user->email }}" 
                        class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors text-slate-800">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-slate-900 text-white font-medium rounded-xl hover:bg-slate-800 transition-colors shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900">
                    <span class="material-symbols-outlined mr-2 text-sm">save</span>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Preview image before upload
    document.getElementById('fileInput').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('.group img').src = e.target.result;
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
@endsection