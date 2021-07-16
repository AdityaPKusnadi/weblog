@extends('layouts.main')

@section('title',$data->title)
@section('content')
    <div class="card text-center">
        <h2 class="titlecontent m-5 p-0">{{$data->title}}</h2> 
    <div class="card-body">
        <p class="content p-2"> {!!$data->content!!}</p>
    </div>   
    </div>
@endsection