@extends('edit-profile.layouts.headers')

@section('content')
<div class="profile">Profile</div>
<form action="{{route('profile.update',$user->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="card-profile">
            <div class="edit-image mt-5">
                @if ($user->image_profile == null)
                <div class="image-profile"><img src="{{asset('assets/img/profileDefault.jpeg')}}" alt=""></div>
                @else
                <div class="image-profile"><img src="{{asset('assets/img/'.$user->image_profile)}}" alt=""></div>
                @endif
                <div class="your-image ms-4">
                    <input type="file" id="fileInput" name="image">
                    <label for="fileInput" class="me-3 my-3" id="customLabel">Pilih File</label>
                </div>
            </div>
            <div class="edit-name">
                <div class="full-name">Nama</div>
                <div class="your-full-name"><input type="text" placeholder="Nama Anda" name="nama" value="{{ $user->name}}"></div> 
            </div>
            <div class="edit-email">
                <div class="email">Email</div>
                <div class="your-email"><input type="text" placeholder="Email Anda" name="email" value="{{ $user->email}}"></div>
            </div>
            <div class="btn-edit">
                <button class="btn button-edit" type="submit">Save</button>
                </div>
        </div>
</form>

@endsection