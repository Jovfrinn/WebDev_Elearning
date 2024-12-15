@extends('admin.layouts.headers')

@section('teacherContent')
<div class="container">
    <div class="header-main">
      <span>Halaman Admin</span>
      <span class="vortex">Data Pengajar</span>
      <hr />
    </div>
    <div class="count-student">{{$count}} Pengajar</div>
<table class="table-student">
    <thead>
        <tr>
            <th class="no-th">No</th>
            <th>Gambar</th>
            <th>Nama</th>
            <th class="email-th">Email</th>
            <th>NIP</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        @foreach ($teachers as $teacher)
        <tr>
            <td class="no-td">{{$no++}}</td>
            <td class="image-td">
                @if($teacher->image_profile == NULL)
                <img src="{{asset('assets/img/profileDefault.jpeg')}}" alt="">
                @else
                <img src="{{asset('assets/img/'.$teacher->image_profile)}}" alt="">
                @endif
            </td>
            <td>{{$teacher->name}}</td>
            <td>{{$teacher->email}}</td>
            <td>{{$teacher->nip}}</td>
            <td><button class="delete-btn">Hapus</button></td>
        </tr>
        @endforeach
    </tbody>
  </table>
</div>
</div>
@endsection