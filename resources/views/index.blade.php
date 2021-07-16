@extends('layouts.main')

@section('content')
@php($i = 0)
@foreach ( $data as $record)
{{-- @php(dd($data)) --}}
    <div class="row">
        <div class="my-3 col">
            <h2 class="m-0 p-0">
                <a class="title" href="{{url('/articles/'.$record->id)}}">{{$record->title}}</a>
            </h2>
            <p class="timestamp m-0 p-0">Written At: {{ date("d/m/Y | H:i:s",strtotime($record->created_at))}}</p>
            <a href="#" class="authorlink"><p class="authorlink m-0 p-0">Author: {{ $record->authors_by_author->name}} Email: {{$record->authors_by_author->email }}</p></a>
            <a href="#" class="authorlink" onclick="commentCol('{{$record->id}}')">Comments({{ count($record->comments_by_article)}})</a>
            <div align="center" class="commentbox{{$record->id}}" id="box-comment">
                @foreach ($record->comments_by_article as $item)
                    <h5 class="">User:{{$item->author}} </h5>
                    <textarea name="commentpeople" class="commentpeople" cols="2" rows="3">{{$item->content}}</textarea>
                    <hr>
                @endforeach
                <a href="{{url('/comment/'.$record->id)}}" class="btn btn-primary">Add Comment</a>            
            </div>
        </div>
        <div class="col my-3">
            <a href="{{url('/article/edit/'.$record->id)}}" class="btn btn-primary">EDIT</a>
            <button class="btn btn-danger" onclick="deleteArticle({{$record->id}},{{ count($record->comments_by_article)}})" >DELETE</button>
        </div>
    </div>
    @php ($i++)
@endforeach
    
@endsection

@section('page-script')
    @parent
    <script>
        $(document).ready(function () {
            tinymce.init({
                selector:'textarea.commentpeople',
                content_css:false,
                skin:false,
                menubar:false,
                toolbar:false,
                readonly:1,
                height : "100",
                weight : "100",

            });

            // tinymce.init({
            //     selector:'textarea.commentInput',
            //     content_css:false,
            //     skin:false,
            //     menubar:false,
            //     toolbar:true,
            //     height : "100",
            //     weight : "100",

            // });

            

        });

        function deleteArticle(id,comment){
            Swal.fire({
            title: 'Do you want to delete the article???',
            showDenyButton: true,
            icon:'warning',
            showCancelButton: false,
            confirmButtonText: `Yes, Sure`,
            denyButtonText: `No, I'am Not sure`,
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "{{url('/article/delete')}}"+'/'+id+'/'+comment,
                    success: function (response) {
                        // console.log(response);
                        if(response == "200"){
                            Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Data successfuly delete from list!'
                            });

                            window.location.reload();
                        }
                    }
                });
                Swal.fire('Article remove from the list!', '', 'success')
            } else if (result.isDenied) {
                Swal.fire('Article Keep on list', '', 'info')
            }
            })
        }

        function commentCol(id){
            // console.log(id);
                if($(".commentbox"+id+"").css('display') == 'none'){
                    $(".commentbox"+id+"").attr('style','display:block');
                }else{
                    $(".commentbox"+id+"").attr('style','display:none');
                }
             }
       
    </script>
@endsection