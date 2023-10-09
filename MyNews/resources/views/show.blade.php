@extends('app')

@section('content')


<a href="{{ url()->previous() }}"> &#8592; назад</a>
  <h1>{{$news->name}}</h1> <br /> 

  <img style="height:500px;" src="{{ asset($news->photo) }}"> 
  <p>теги</p>
  @foreach($news->tags as $tag)
    <strong>#{{$tag->name}}</strong> 

  @endforeach 
    <p>текст</p>
    {!!$news->text!!} <br /> 

  <br />


@endsection