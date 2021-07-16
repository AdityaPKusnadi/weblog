@extends('layouts.main')

@section('content')
<div class="row title">
    <div class="col"><h5>Name</h5></div>
    <div class="col"><h5>Email</h5></div>
    <div class="col"><h5>ID</h5></div>
    <div class="col"><h5>Action</h5></div>
</div>
@foreach ( $data as $record)
    <div class="row">
        <div class="my-3 col">
            <h5 class="m-0 p-0">
                <a class="title" href="#">{{$record->name}}</a>
            </h5>
        </div>
        <div class="col">
            <div class="my-3 col">
                <h5 class="m-0 p-0">
                    <a class="title" href="#">{{$record->email}}</a>
                </h5>
            </div>
        </div>
        <div class="col">
            <div class="my-3 col">
                <h5 class="m-0 p-0">
                    <a class="title" href="#">{{$record->id}}</a>
                </h5>
            </div>
        </div>
        <div class="col my-3">
            <button class="btn btn-primary">EDIT</button>
            <button class="btn btn-danger" onclick="deleteAuthor('{{$record->id}}')">DELETE</button>
        </div>
    </div>
@endforeach
    
@endsection

@section('page-script')
@parent
<script>
    function deleteAuthor(id){
    Swal.fire({
    title: 'Do you want to delete this author???',
    showDenyButton: true,
    icon:'warning',
    showCancelButton: false,
    confirmButtonText: `Yes, Sure`,
    denyButtonText: `No, I'am Not sure`,
    }).then((result) => {
    if (result.isConfirmed) {
        Swal.fire('Author remove from the list!', '', 'success')
    } else if (result.isDenied) {
        Swal.fire('Author Keep on list', '', 'info')
    }
    })
}
</script>
@endsection