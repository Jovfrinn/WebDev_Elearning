@extends('auth.headerAuth')

@section('content')

    <div class="background-container">
        <div class="background"></div>
        <div class="content d-flex justify-content-center align-items-center">
         <div class="content-login">
            <div class="img">
                <img src="{{asset('assets/img/ukm.jpg')}}" alt="">
            </div>
            <div class="form-login">
                <div class="title-login text-start ms-3">Register</div>
                <form  method="POST" action="{{ route('register') }}" class="d-flex flex-column align-items-center">
                    @csrf
                    <div class="email d-flex flex-column align-items-start">
                    <label for="name" class="hidden">Nama:</label>
                    <input type="text" class="input-email form-control" id="name" name="name" placeholder="Nama"  :value="old('name')" required autofocus autocomplete="name" >
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="password d-flex flex-column align-items-start">
                    <label for="email" class="hidden">Email:</label>
                    <input type="email" class="input-password form-control" id="email" name="email" placeholder="Email" :value="old('email')" required autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />    
                    </div>
                    <div class="password d-flex flex-column align-items-start">
                    <label for="password" class="hidden">Password:</label>
                    <input type="password" class="input-password form-control" id="password" name="password" placeholder="Password"   required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="password d-flex flex-column align-items-start">
                    <label for="password_confirmation" class="hidden">Confirm Password:</label>
                    <input type="password" class="input-password form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password"  required autocomplete="new-password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    <button type="submit" class="btn">  {{ __('Register') }}</button>
                </form>    
                <div class="hr mx-auto"></div>

                <a href="#" class="btn btn-google mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                    <path d="M15.545 6.558a9.4 9.4 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.7 7.7 0 0 1 5.352 2.082l-2.284 2.284A4.35 4.35 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.8 4.8 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.7 3.7 0 0 0 1.599-2.431H8v-3.08z"/>
                  </svg>
                </a>
                <div class="signUp">Already have account? ? <a href="{{ route('login') }}">Sign In</a></div>
            </div>
        </div>
        </div>
      </div>
@endsection