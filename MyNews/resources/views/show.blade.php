@extends('app')

@section('content')
<h2>show</h2>
@if ($news)


  {{-- <img style="height:100px;" src="{{ asset($friend->avatar) }}"> --}}
  <strong>{{$news->name}}</strong> <br /> 
   <strong>{{$news->text}}</strong> <br /> 

     @foreach($news->tags as $tag)
    <strong>{{$tag->name}}</strong> <br />
    <br />
    @endforeach 
  <br />

  @else
  <p>No news found.</p>
@endif

@endsection