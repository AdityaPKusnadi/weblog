@extends('layouts.main')

@section('title','Add Comment')

@section('content')
    <h2 class="m-5">Add Comment</h2>
    <form method="POST">
        @csrf
        <div class="mb-3">
            <input type="hidden" class="form-control" value="{{$data}}" name="article">
            <label for="author" class="form-label">Author</label>

            <select name="author" class="form-control" id="author">
                <option value="">--Pilih--</option>
                @foreach ($author as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="comment"  class="form-label">Comment</label>
            <textarea name="comment" id="comment" cols="30" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-success form-control">Submit</button>
        </div>
    </form>
@endsection

@section('page-script')
    @parent
    <script>
        $(document).ready(function () {
            tinymce.init({
                selector:'textarea#comment',
                content_css:false,
                skin:false
            });
        });
    </script>
@endsection