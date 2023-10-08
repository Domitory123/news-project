@extends('app')

@section('content')


<div class=""></div>

 <div class="">

    <form action="{{ route('postSigin')}}" method="post">
        {{ csrf_field() }}
       
        @if($errors->has('email'))
         <strong class="registration-login-error-message">{{ $errors->first('email') }}</strong>
        @endif
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Електронна пошта" autocomplete="email" required>

        <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="Пароль" autocomplete="password" required>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
                 
        <div class="registration-login-remember">
        <input class="login-form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="login-form-check-label" for="remember">Запам'ятати мене</label>
        </div>  
                             
        <button type="submit">Увійти</button>
        <br>        
      
 <label>
    Не маєте профілю? <a href="{{ route('registration.getSigUp') }}"><b>&nbsp;Зареєструватися.</b></a>
</label>
 
    </form>
    <div>

@endsection