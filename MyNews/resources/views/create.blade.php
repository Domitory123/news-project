@extends('app')

@section('content')
<h2>qwwe</h2>

<form action="{{ route('store')}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}

    <input class="" type="text" name="text"  placeholder="text" >
    <input class="" type="text" name="tag"  placeholder="tag" >
    <button type="submit">відправити</button>
    


</form>
@endsection