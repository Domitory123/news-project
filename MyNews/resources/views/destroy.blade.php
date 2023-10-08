@extends('app')

@section('content')


   <h1>Ви дійсно бажаєте видалити новину?</h1>

   <form action="{{ route('news.destroy', ['news' => $news]) }}" method="POST">
    {{ csrf_field() }}
    @method('DELETE')

    <h1>{{$news->name}}</h1> <br /> 
    <img style="height:300px;" src="{{ asset($news->photo) }}"> 
    <p>теги</p>
    @foreach($news->tags as $tag)
      <strong>#{{$tag->name}}</strong> 
  
    @endforeach 
      <p>текст</p>
      {!!$news->text!!} <br /> 
    <br />
{{--   
    <a href="{{ route('news.destroy',$news) }}">видалити</a>  --}}
   
    <button type="submit">Видалити</button>
    <a href="{{ url()->previous() }}">скасувати</a>
</form>





@endsection