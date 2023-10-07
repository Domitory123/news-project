@extends('app')

@section('content')

@if ($news)
   
  <h1>{{$news->name}}</h1> <br /> 

  <img style="height:500px;" src="{{ asset($news->photo) }}"> 
  <p>теги</p>
  @foreach($news->tags as $tag)
    <strong>#{{$tag->name}}</strong> 
    {{-- <a href="{{ route('tag.delete',$tag) }}">видалити</a> --}}
  @endforeach 
    <p>текст</p>
    {!!$news->text!!} <br /> 

  <br />

  @else
  <p>No news found.</p>
@endif

@endsection