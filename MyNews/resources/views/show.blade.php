@extends('app')

@section('content')


  <h1>{{$news->name}}</h1> <br /> 

  <img style="height:500px;" src="{{ asset($news->photo) }}"> 
  <p>теги</p>
  @foreach($news->tags as $tag)
    <strong>#{{$tag->name}}</strong> 

  @endforeach 
    <p>текст</p>
    {{-- {!!$news->text!!} <br />  --}}

    {!!$news->showTextWithTags()!!}


  <br />


@endsection