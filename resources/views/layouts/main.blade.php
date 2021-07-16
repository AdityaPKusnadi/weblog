<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WEBLOG - @yield('title','Main')</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    <nav class="navbar  navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a href="#" class="navbar-brand">WEBLOG</a>
            <button class="class-toggler" type="button" data-bs-toogle="collapse" data-bs-target="navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toogle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="">
                    <li class="nav-item">
                        <a href="{{ url('/')}}" aria-current="page" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('/articles/new')}}" class="nav-link">New Article</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('/author/list')}}" class="nav-link">List Author</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{url('/profile')}}" class="nav-link">My Profile</a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container">
        @yield('content')
    </div>
    @section('page-script')
        <script src="{{asset('js/app.js')}}"></script>
    @show
</body>
</html>