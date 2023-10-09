@extends('app')

@section('content')

<div class="login">

    <form action="{{ route('registration.postSigUp')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}

        <label>
            <h2><b>Створити акаунт</b></h2>
        </label>

        <input  @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="імя" autocomplete="name" required>
        @error('name')
        <span  role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    <br/>

        <input  @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Електронна пошта" autocomplete="email" required>
        @error('email')
        <span  role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        <br/>
        <input  @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="Пароль" autocomplete="password" required>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        <br/>
        <input  @error('password_confirmation') is-invalid @enderror" type="password" id="password_confirmation" name="password_confirmation" placeholder="Підтвердження паролю" required>
        @error('password_confirmation')
        <span  role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        <br/>
        <button type="submit">Зареєструватись</button>
        <br/>
        <input style="display: none;" type="checkbox" name="remember" id="remember"  checked >
        <br/>
<samp>якщо є акаунт</samp><br/>
         <a href="{{ route('getSigin') }}" >Увійти</a>


    </form>
</div>

        @endsection