@extends('app')

@section('content')
<h2>Адмінка</h2>

<a href="{{ route('create') }}">створити новину</a>
@foreach($News as $news)
<hr/> 
<div class="">
      <div  class=""> 
               <p>{{$news->name}}</p> 
               <a class="" href="{{ route('news.show', $news) }}" >
               <img style="height:100px;" src="{{ asset($news->photo) }}">
              </a>
                <br/>
               <span>{{$news->created_at->format('H:i j F Y ')}}</span> 
               <a href="{{ route('news.edit',$news )}}">редагувати</a> 
               <a href="{{ route('news.showDestroy',$news )}}">видалити</a> 
               
        <div  class="">
               <a class="" href="{{ route('news.show', $news) }}" >докладніше&rarr;</a>
        </div>
      </div>  
</div>
@endforeach 

<div class="custom-pagination">
    {{ $News->links() }}
</div>

@endsection