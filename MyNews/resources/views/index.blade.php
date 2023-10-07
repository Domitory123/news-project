@extends('app')

@section('content')
<h2>Всі новини</h2>

@foreach($News as $news)
<div class="">
     {{-- <div  class="photo" style=" background-image: url({{ asset('/storage/' . $new->name_main_photo) }});"> --}}
      {{-- </div> --}}

      <div  class=""> 
               {{-- <p>{{$news->id}}</p>  --}}
               <p>{{$news->name}}</p> 

        <div  class="">
               <a class="" href="{{ route('news.show', $news)}}" >докладніше&rarr;</a>
        </div>
      </div>  
</div>

<br/> 
@endforeach 




@endsection