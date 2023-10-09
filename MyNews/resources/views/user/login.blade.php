@extends('app')

@section('content')


<div class="login">
    
    <form action="{{ route('postSigin')}}" method="post">
        {{ csrf_field() }}
       
        @error('email')
            <span  role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <br/>
        <input  id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Електронна пошта" autocomplete="email" required>

        <input type="password" id="password" name="password" placeholder="Пароль" autocomplete="password" required>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
                 
        <div >
        <input  type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        <label  for="remember">Запам'ятати мене</label>
        </div>  
                             
        <button type="submit">Увійти</button>
        <br>        
      
 <label>
    Не маєте профілю? <a href="{{ route('registration.getSigUp') }}"><b>&nbsp;Зареєструватися.</b></a>
</label>
 
    </form>
</div>

@endsection