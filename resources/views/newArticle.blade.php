@extends('layouts.main')

@section('title','New Article')

@section('content')
    <h2 class="m-5">New Article</h2>
    <form method="POST">
        @csrf
        <div class="mb-3">
            <label for="frm-title" class="form-label">Title</label>
            <input type="text" name="frm-title" id="frm-title" placeholder="Article Title" class="form-control">
        </div>
        <div class="mb-3">
            <label for="frm-content"  class="form-label">Content</label>
            <textarea name="frm-content" id="frm-content" cols="30" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Author</label>

            <select name="author" class="form-control" id="author">
                <option value="">--Pilih--</option>
                @foreach ($data as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-6">
            <button type="submit" class="btn btn-success form-control">Submit</button>
        </div>
    </form>
@endsection

@section('page-script')
    @parent
    <script>
        $(document).ready(function () {
            tinymce.init({
                selector:'textarea#frm-content',
                content_css:false,
                skin:false
            });
        });
    </script>
@endsection