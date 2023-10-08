@extends('app')

@section('content')
<h2>Всі новини</h2>

@foreach($News as $news)
<div class="">
      <div  class=""> 
               <p>{{$news->name}}</p> 
               <img style="height:200px;" src="{{ asset($news->photo) }}"> <br/>
               <span>{{$news->created_at->format('H:i j F Y ')}}</span> 
               <a href="{{ route('news.edit',$news )}}">редагувати</a> 
               <a href="{{ route('news.showDestroy',$news )}}">видалити</a> 
               
        <div  class="">
               <a class="" href="{{ route('news.show', $news) }}" >докладніше&rarr;</a>
        </div>
      </div>  
</div>

<br/> 
@endforeach 

       <div class="custom-pagination">
              {{ $News->links() }}
       </div>
      





@endsection