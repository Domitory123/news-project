@extends('app')

@section('content')

<div class="">

    <form action="{{ route('registration.postSigUp')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}

        <label>
            <h2><b>Створити акаунт</b></h2>
        </label>

        <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="імя" autocomplete="name" required>
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Електронна пошта" autocomplete="email" required>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="Пароль" autocomplete="password" required>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        
        <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" id="password_confirmation" name="password_confirmation" placeholder="Підтвердження паролю" required>
        @error('password_confirmation')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        
        <button type="submit">Зареєструватись</button>
       
        <input style="display: none;" type="checkbox" name="remember" id="remember"  checked >

         <a href="{{ route('getSigin') }}" >Увійти</a>


    </form>
    <div>

        @endsection