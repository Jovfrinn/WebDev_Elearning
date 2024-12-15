@extends('teacher.layouts.headers')

@section('teacherContent')
<div class="section-userJoin">
    <div class="title-userJoin">Yang bergabung di Materi ini</div>
    <hr class="my-4 hr-userJoin">
    <div class="userJoin">
        <table class="table-student">
            <thead>
                <tr>
                    <th class="no-th">No</th>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th class="email-th">Email</th>
                </tr>
            </thead>
            <tbody>
                @if (count($userJoin) == 0)
                <tr>
                    <td colspan="4" class="text-center">Belum ada peserta yang bergabung</td>
                </tr>
                @else
                    
                <?php $no = 1; ?>
                @foreach ($userJoin as $student)
                <tr>
                    <td class="no-td">{{$no++}}</td>
                    <td class="image-td">
                        @if($student->image_profile == NULL)
                        <img src="{{asset('assets/img/profileDefault.jpeg')}}" alt="">
                        @else
                        <img src="{{asset('assets/img/'.$student->image_profile)}}" alt="">
                        @endif
                    </td>
                    <td>{{$student->name}}</td>
                    <td>{{$student->email}}</td>
                </tr>
                @endforeach 
                @endif

            </tbody>
          </table>
    </div>
</div>
@endsection