@extends('app')

@section('content')
<h2>Створення новини</h2>
<div class="container-create">
    <div class="create-form">

        <form action="{{ route('store')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <b>Назва</b> <br>
             <input class="" type="text" name="name"  placeholder="name" > 
             <br>
            <b>Теги</b> <br>
            <input class="" type="text" name="tag" value="{{ old('tag') }}" placeholder="tag" >
            @if ($errors->has('tag'))
                <div class="alert alert-danger">{{ $errors->first('tag') }}</div>
            @endif
            <br>
            <b>Текст</b> <br>
                <textarea name="text" cols="28"  rows="5" placeholder="text" ></textarea> <br/>

            <input class="" type="file" name="file"  accept="image/*" >
                <br>
            <button type="submit">Зберегти</button>
            
        </form>
    </div>
</div>

@endsection