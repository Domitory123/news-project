@extends('app')

@section('content')
<h2>show</h2>
@if ($news)


  {{-- <img style="height:100px;" src="{{ asset($friend->avatar) }}"> --}}
  <p>назва</p>
  <strong>{{$news->name}}</strong> <br /> 
  <p>теги</p>
  @foreach($news->tags as $tag)
    <strong>#{{$tag->name}}</strong> <br />
    <a href="{{ route('tag.delete',$tag) }}">видалити</a>
    
    <br />
 
  <p>текст</p>
   {!!$news->text!!} <br /> 
   
    @endforeach 
  <br />

  @else
  <p>No news found.</p>
@endif

@endsection