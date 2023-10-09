@extends('app')

@section('content')
<h2>Всі новини</h2>

@foreach($News as $news)
<div class="">
      <div  class=""> 
               <p>{{$news->name}}</p> 
               <a class="" href="{{ route('news.show', $news) }}" >     <img style="height:200px;" src="{{ asset($news->photo) }}"></a> <br/>
               <span>{{$news->created_at->format('H:i j F Y ')}}</span> 

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