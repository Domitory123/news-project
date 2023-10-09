@extends('app')

@section('content')
<a href="{{ url()->previous() }}"> &#8592; назад</a>
<h2>Створення новини</h2>
<div class="container-create">
    <div class="create-form">

        <form action="{{ route('store')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <b>Назва</b> <br>
             <input class="" type="text" name="name" value="{{ old('name') }}" placeholder="name" > 
             <br>
             @if ($errors->has('name'))
             <div class="alert alert-danger">{{ $errors->first('name') }}</div>
             @endif
            <b>Теги</b> <br>
            <input class="" type="text" name="tag" value="{{ old('tag') }}" placeholder="tag" >
            @if ($errors->has('tag'))
                <div class="alert alert-danger">{{ $errors->first('tag') }}</div>
            @endif
            <br>
            <b>Текст</b> <br>
                <textarea name="text" cols="53"  rows="15" placeholder="text" >{{ old('text') }}</textarea> <br/>
            @if ($errors->has('text'))
                <div class="alert alert-danger">{{ $errors->first('text') }}</div>
            @endif
            <input class="" type="file" name="file"  accept="image/*" >
            @if ($errors->has('file'))
            <div class="alert alert-danger">{{ $errors->first('file') }}</div>
             @endif

                <br>
            <button type="submit">Зберегти</button>
            
        </form>
    </div>
</div>

@endsection