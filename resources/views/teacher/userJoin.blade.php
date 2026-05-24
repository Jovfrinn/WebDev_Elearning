@extends('teacher.layouts.headers')

@section('pageTitle', 'Peserta Kelas')

@section('teacherContent')
<div class="max-w-6xl mx-auto">
    <!-- Header Page -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Peserta Kelas</h2>
            <p class="text-sm text-slate-500 mt-1">Daftar siswa yang telah bergabung dalam materi ini.</p>
        </div>
        <a href="{{ route('get.subMateri', $idMaterial) }}" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-full transition-colors tooltip" title="Kembali">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="text-lg font-bold text-slate-800">Daftar Siswa</h3>
            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold shadow-sm">{{ count($userJoin) }} Siswa Bergabung</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Profil</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Alamat Email</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @if (count($userJoin) == 0)
                    <tr>
                        <td colspan="4" class="py-12 px-6 text-center text-slate-500">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 mb-3">
                                <span class="material-symbols-outlined text-3xl text-slate-400">group_off</span>
                            </div>
                            <p class="font-medium text-slate-600">Belum ada peserta yang bergabung</p>
                        </td>
                    </tr>
                    @else
                        @php $no = 1; @endphp
                        @foreach ($userJoin as $student)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-6 text-sm text-slate-600 font-medium">{{$no++}}</td>
                            <td class="py-4 px-6">
                                <div class="h-10 w-10 rounded-full overflow-hidden border border-slate-200">
                                    @if($student->image_profile == NULL)
                                    <img src="{{asset('assets/img/profileDefault.jpeg')}}" alt="Default Profile" class="h-full w-full object-cover">
                                    @else
                                    <img src="{{asset('assets/img/'.$student->image_profile)}}" alt="Profile {{ $student->name }}" class="h-full w-full object-cover">
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm font-semibold text-slate-800">{{$student->name}}</p>
                                <p class="text-xs text-slate-400 lg:hidden">{{$student->email}}</p>
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-600 hidden sm:table-cell">
                                <a href="mailto:{{$student->email}}" class="hover:text-emerald-600 transition-colors">{{$student->email}}</a>
                            </td>
                        </tr>
                        @endforeach 
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection