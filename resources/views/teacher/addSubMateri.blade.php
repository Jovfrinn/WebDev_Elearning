@extends('teacher.layouts.headers')

@section('pageTitle', 'Tambah Sub Materi (Video)')

@section('teacherContent')
<div class="max-w-5xl mx-auto">
    <!-- Header Page -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Materi Pembelajaran</h2>
            <p class="text-sm text-slate-500 mt-1">Unggah video pembelajaran, lampirkan PDF, dan tambahkan deskripsi materi.</p>
        </div>
        <a href="{{ route('get.subMateri', $idMaterial) }}" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-full transition-colors tooltip" title="Kembali">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: Video + PDF -->
        <div class="lg:col-span-5 space-y-6">
            <!-- Dropzone Video -->
            <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                    <span class="material-symbols-outlined mr-2 text-emerald-500">movie</span>
                    Video Pembelajaran
                </h3>
                
                <!-- Video Preview (hidden by default) -->
                <div id="videoPreviewContainer" class="hidden mb-4 relative group">
                    <video id="videoPreview" controls class="w-full rounded-xl border border-slate-200 shadow-sm bg-black max-h-[250px]"></video>
                    <button type="button" onclick="clearVideoPreview()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition-opacity shadow-md hover:bg-red-600 z-10">
                        <span class="material-symbols-outlined text-[16px]">close</span>
                    </button>
                </div>

                <form action="{{ route('store.video') }}" class="border-2 border-dashed border-emerald-300 rounded-xl bg-emerald-50/50 flex flex-col items-center justify-center min-h-[250px] p-4 text-center cursor-pointer hover:bg-emerald-50 transition-colors" id="video-dropzone" enctype="multipart/form-data">
                    @csrf
                    <div class="dz-message" data-dz-message>
                        <span class="material-symbols-outlined text-5xl text-emerald-400 mb-3 block">cloud_upload</span>
                        <span class="text-sm font-medium text-slate-700 block">Klik atau Seret video ke sini</span>
                        <span class="text-xs text-slate-500 mt-1 block">Format: MP4, AVI, MKV, MOV (Maks: 1GB)</span>
                    </div>
                </form>
            </div>

            <!-- PDF Upload -->
            <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                    <span class="material-symbols-outlined mr-2 text-red-500">picture_as_pdf</span>
                    Lampiran PDF
                    <span class="ml-2 text-xs text-slate-400 font-normal">(Opsional)</span>
                </h3>

                <!-- PDF Preview (hidden by default) -->
                <div id="pdfPreviewContainer" class="hidden mb-4">
                    <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-xl">
                        <div class="flex-shrink-0 w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-2xl">description</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p id="pdfFileName" class="text-sm font-semibold text-slate-800 truncate"></p>
                            <p id="pdfFileSize" class="text-xs text-slate-500"></p>
                        </div>
                        <button type="button" onclick="clearPdfPreview()" class="p-1.5 text-red-400 hover:text-red-600 hover:bg-red-100 rounded-full transition-colors">
                            <span class="material-symbols-outlined text-[18px]">close</span>
                        </button>
                    </div>
                </div>

                <!-- PDF Upload Area -->
                <div id="pdfUploadArea" class="flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl hover:bg-slate-50 hover:border-red-300 transition-colors cursor-pointer group" onclick="document.getElementById('file_pdf').click()">
                    <div class="space-y-1 text-center">
                        <span class="material-symbols-outlined text-4xl text-slate-400 group-hover:text-red-500 transition-colors">upload_file</span>
                        <div class="flex text-sm text-slate-600 justify-center">
                            <span class="font-medium text-red-600">Klik untuk upload PDF</span>
                        </div>
                        <p class="text-xs text-slate-500">File PDF (Maks: 10MB)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Form -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 p-6 sm:p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4">Detail Materi</h3>
                
                <form method="POST" action="{{route('store.subMateri')}}" enctype="multipart/form-data" class="space-y-6" id="subMateriForm">
                    @csrf
                    <input type="hidden" name="idMaterial" value="{{$idMaterial}}">
                    
                    <!-- Judul Materi -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">Judul Materi</label>
                        <input type="text" id="title" name="title" placeholder="Contoh: Pengenalan HTML & CSS" required
                            class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-colors text-slate-800 placeholder-slate-400">
                    </div>

                    <!-- Penjelasan Materi -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Penjelasan Materi</label>
                        <textarea id="description" name="description" rows="5" placeholder="Tuliskan poin-poin penting dari video ini..." required
                            class="block w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-colors text-slate-800 placeholder-slate-400 resize-y"></textarea>
                    </div>

                    <!-- Hidden PDF input (lives inside this form) -->
                    <input type="file" id="file_pdf" name="file_pdf" class="hidden" accept=".pdf" onchange="previewPdf(this)">

                    <!-- Actions -->
                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-emerald-600 text-white font-medium rounded-xl hover:bg-emerald-700 transition-colors shadow-md shadow-emerald-200 flex items-center justify-center">
                            <span class="material-symbols-outlined text-sm mr-2">add_circle</span>
                            Simpan Materi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script>
  // Prevent Dropzone from auto-discovering all forms with class 'dropzone'
  Dropzone.autoDiscover = false;

  document.addEventListener('DOMContentLoaded', function() {
      var myDropzone = new Dropzone("#video-dropzone", {
          url: "{{ route('store.video') }}",
          paramName: "file",
          maxFilesize: 1024, // 1GB
          timeout: 0, // No timeout for large uploads
          acceptedFiles: ".mp4,.avi,.mkv,.webm,.mov",
          maxFiles: 1,
          headers: {
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          dictDefaultMessage: "",
          chunking: false,
          init: function() {
              var submitButton = document.querySelector('button[type="submit"]');
              var originalButtonText = submitButton.innerHTML;

              this.on("addedfile", function(file) {
                  // Hide the default message
                  var dzMsg = document.querySelector('.dz-message');
                  if (dzMsg) dzMsg.style.display = 'none';

                  // Show video preview
                  if (file.type && file.type.startsWith('video/')) {
                      var videoPreviewContainer = document.getElementById('videoPreviewContainer');
                      var videoPreview = document.getElementById('videoPreview');
                      var url = URL.createObjectURL(file);
                      videoPreview.src = url;
                      videoPreviewContainer.classList.remove('hidden');
                  }
              });
              this.on("removedfile", function() {
                  if (this.files.length === 0) {
                      var dzMsg = document.querySelector('.dz-message');
                      if (dzMsg) dzMsg.style.display = '';
                      clearVideoPreview();
                  }
              });
              this.on("sending", function(file, xhr, formData) {
                  // Show upload progress and disable submit button
                  console.log('Uploading:', file.name, 'Size:', file.size);
                  if (submitButton) {
                      submitButton.disabled = true;
                      submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                      submitButton.innerHTML = '<span class="material-symbols-outlined text-sm mr-2 animate-spin">sync</span>Mengunggah Video...';
                  }
              });
              this.on("success", function(file, response) {
                  console.log('Video uploaded successfully:', response);
                  // Show success indicator
                  var dzMsg = document.querySelector('.dz-message');
                  if (dzMsg) {
                      dzMsg.innerHTML = '<span class="material-symbols-outlined text-5xl text-emerald-500 mb-3 block">check_circle</span><span class="text-sm font-medium text-emerald-700 block">Video berhasil diunggah!</span>';
                      dzMsg.style.display = '';
                  }
                  
                  // Re-enable submit button
                  if (submitButton) {
                      submitButton.disabled = false;
                      submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                      submitButton.innerHTML = originalButtonText;
                  }
              });
              this.on("error", function(file, errorMessage, xhr) {
                  console.error('Upload error:', errorMessage, xhr);
                  var msg = 'Gagal mengunggah video.';
                  if (typeof errorMessage === 'string') {
                      msg = errorMessage;
                  } else if (errorMessage && errorMessage.message) {
                      msg = errorMessage.message;
                  }
                  // Check for server errors
                  if (xhr && xhr.status === 419) {
                      msg = 'Sesi telah habis. Silakan refresh halaman dan coba lagi.';
                  } else if (xhr && xhr.status === 413) {
                      msg = 'File terlalu besar untuk server. Hubungi administrator.';
                  } else if (xhr && xhr.status === 422) {
                      try {
                          var resp = JSON.parse(xhr.responseText);
                          if (resp.message) msg = resp.message;
                      } catch(e) {}
                  }
                  alert(msg);
                  this.removeFile(file);
                  
                  // Re-enable submit button
                  if (submitButton) {
                      submitButton.disabled = false;
                      submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                      submitButton.innerHTML = originalButtonText;
                  }
              });
          }
      });
  });

  // PDF Preview
  function previewPdf(input) {
      const previewContainer = document.getElementById('pdfPreviewContainer');
      const uploadArea = document.getElementById('pdfUploadArea');
      const fileName = document.getElementById('pdfFileName');
      const fileSize = document.getElementById('pdfFileSize');

      if (input.files && input.files[0]) {
          const file = input.files[0];
          fileName.textContent = file.name;
          fileSize.textContent = formatFileSize(file.size);
          previewContainer.classList.remove('hidden');
          uploadArea.classList.add('hidden');
      }
  }

  function clearPdfPreview() {
      const previewContainer = document.getElementById('pdfPreviewContainer');
      const uploadArea = document.getElementById('pdfUploadArea');
      const input = document.getElementById('file_pdf');

      previewContainer.classList.add('hidden');
      uploadArea.classList.remove('hidden');
      input.value = '';
  }

  function clearVideoPreview() {
      const container = document.getElementById('videoPreviewContainer');
      const video = document.getElementById('videoPreview');
      container.classList.add('hidden');
      video.src = '';
  }

  function formatFileSize(bytes) {
      if (bytes === 0) return '0 Bytes';
      const k = 1024;
      const sizes = ['Bytes', 'KB', 'MB', 'GB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
  }
</script>
<style>
    .dropzone {
        background: transparent !important;
        border: none !important;
        padding: 0 !important;
    }
    .dropzone .dz-preview {
        margin: 1rem auto !important;
    }
</style>
@endsection