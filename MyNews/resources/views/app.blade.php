<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>

        <div class="container-main">
            <div class="header">
                <h1>Новини 27</h1>
                <a href="{{ route('index') }}">головна</a>
               

                @if (Auth::check())

                @if (Auth::user()->checkAdmin())
                  <a href="{{ route('admin.index') }}">адмінка</a>
                  @endif
                @endif

                <div class="header-user">
                    @if (!Auth::check())
                        <a href="{{ route('getSigin') }}">Увійти</a>
                        <a href="{{ route('registration.getSigUp') }}"><b>&nbsp;Зареєструватися.</b></a>
                    @else
                      <a href="{{ route('logout')}}"> Вихід </a>
                    @endif
                </div>
            </div>

            <div class="content">
                @yield('content')  
            </div>
            

        </div>

    </body>
</html>
