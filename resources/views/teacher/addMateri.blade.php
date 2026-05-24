@extends('teacher.layouts.headers')

@section('pageTitle', 'Tambah Kelas Baru')

@section('teacherContent')
<div class="max-w-3xl mx-auto">
    <!-- Header Page -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Buat Kelas Baru</h2>
            <p class="text-sm text-slate-500 mt-1">Lengkapi informasi di bawah ini untuk membuat kelas baru Anda.</p>
        </div>
        <a href="{{ route('teacher.home') }}" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-full transition-colors tooltip" title="Kembali">
            <span class="material-symbols-outlined">close</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 overflow-hidden p-6 sm:p-8">
        <form method="POST" action="{{route('store.materi')}}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Judul Kelas -->
            <div>
                <label for="material_title" class="block text-sm font-semibold text-slate-700 mb-2">Judul Kelas</label>
                <input type="text" id="material_title" name="material_title" placeholder="Contoh: Pemrograman Web Lanjut" required
                    class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-colors text-slate-800 placeholder-slate-400">
            </div>

            <!-- Deskripsi Kelas -->
            <div>
                <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Kelas</label>
                <textarea id="description" name="description" rows="4" placeholder="Jelaskan secara singkat apa yang akan dipelajari di kelas ini..." required
                    class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-colors text-slate-800 placeholder-slate-400 resize-y"></textarea>
            </div>

            <!-- Thumbnail Kelas with Preview -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Thumbnail Kelas</label>
                
                <!-- Preview Container (hidden by default) -->
                <div id="imagePreviewContainer" class="hidden mb-3 relative group">
                    <img id="imagePreview" src="" alt="Preview" class="w-full h-48 object-cover rounded-xl border border-slate-200 shadow-sm">
                    <button type="button" onclick="clearImagePreview()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition-opacity shadow-md hover:bg-red-600">
                        <span class="material-symbols-outlined text-[16px]">close</span>
                    </button>
                </div>

                <!-- Upload Area -->
                <div id="imageUploadArea" class="flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl hover:bg-slate-50 hover:border-emerald-400 transition-colors relative group cursor-pointer" onclick="document.getElementById('image').click()">
                    <div class="space-y-1 text-center">
                        <span class="material-symbols-outlined text-4xl text-slate-400 group-hover:text-emerald-500 transition-colors">image</span>
                        <div class="flex text-sm text-slate-600 justify-center">
                            <span class="font-medium text-emerald-600">Klik untuk upload</span>
                            <p class="pl-1">atau seret gambar ke sini</p>
                        </div>
                        <p class="text-xs text-slate-500">PNG, JPG, GIF (Maks: 2MB)</p>
                    </div>
                    <input id="image" name="image" type="file" class="sr-only" accept="image/*" required onchange="previewImage(this)">
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('teacher.home') }}" class="px-6 py-3 border border-slate-200 text-slate-600 font-medium rounded-xl hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-emerald-600 text-white font-medium rounded-xl hover:bg-emerald-700 transition-colors shadow-md shadow-emerald-200 flex items-center">
                    <span class="material-symbols-outlined text-sm mr-2">save</span>
                    Simpan Kelas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    function previewImage(input) {
        const previewContainer = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('imagePreview');
        const uploadArea = document.getElementById('imageUploadArea');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
                uploadArea.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function clearImagePreview() {
        const previewContainer = document.getElementById('imagePreviewContainer');
        const uploadArea = document.getElementById('imageUploadArea');
        const input = document.getElementById('image');

        previewContainer.classList.add('hidden');
        uploadArea.classList.remove('hidden');
        input.value = '';
    }
</script>
@endsection