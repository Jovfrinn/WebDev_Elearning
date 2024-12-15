@extends('admin.layouts.headers')

@section('teacherContent')
<div class="container">
    <div class="header-main">
      <span>Halaman Admin</span>
      <span class="vortex">Verifikasi Pengajar</span>
      <hr />
    </div>
    {{-- <div class="count-student">{{$count}} Pengajar</div> --}}
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
        @if (count($pendingUsers) == 0)
            <tr>
                <td colspan="6" class="text-center">Tidak ada pengajar yang belum diverifikasi</td>
            </tr>
            @else
            <?php $no = 1; ?>
            @foreach ($pendingUsers as $user)
            <tr>
                <td class="no-td">{{$no++}}</td>
                <td class="image-td">
                    @if($user->image_profile == NULL)
                    <img src="{{asset('assets/img/profileDefault.jpeg')}}" alt="">
                    @else
                    <img src="{{asset('assets/img/'.$user->image_profile)}}" alt="">
                    @endif
                </td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->nip}}</td>
                <td class="d-flex align-items-center justify-content-center mt-3">
                    <a href="{{route('verifikasi.teacher', $user->id)}}" class="btn btn-success me-2">Verifikasi</a>
                    <a href="{{route('delete.teacher', $user->id)}}" class="delete-btn">Hapus</a>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
  </table>
</div>
</div>
@endsection























{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <h1>Daftar Guru yang Belum Diverifikasi</h1>
        @foreach ($pendingUsers as $user)
            <div>
                <p>Nama: {{ $user->name }}</p>
                <p>Email: {{ $user->email }}</p>
                <p>NIP: {{ $user->nip }}</p>
                <form action="{{ route('post.teacher', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Verifikasi</button>
                </form>
            </div>
        @endforeach
    </div>
</body>
</html> --}}