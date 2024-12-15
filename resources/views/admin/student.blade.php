@extends('admin.layouts.headers')

@section('teacherContent')
<div class="container">
    <div class="header-main">
      <span>Halaman Admin</span>
      <span class="vortex">Data Peserta</span>
      <hr />
    </div>
    <div class="count-student">{{$count}} Peserta</div>
<table class="table-student">
    <thead>
        <tr>
            <th class="no-th">No</th>
            <th>Gambar</th>
            <th>Nama</th>
            <th class="email-th">Email</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        @foreach ($students as $student)
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
            <td><button class="delete-btn">Hapus</button></td>
        </tr>
        @endforeach
    </tbody>
  </table>
</div>
</div>
@endsection