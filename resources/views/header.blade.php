<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('components.link')
    @include('components.script')
    <title>{{ $titlePage }}</title>
</head>

<body class="bg-dark">
    <header>
        <nav class="container-fluid navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="{{ route('home.index') }}">
                <img src="{{ asset('img/logo-header.png') }}" width="45px" alt="Header logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
                
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <a class="btn text-white" href="{{ route('profile.index') }}">Profile</a> 

                <div class="navbar-nav">
                    @if (Session::has('logged_user'))
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <input type="submit" class="btn text-white" value="Logout">
                        </form>    
                    @else    
                        <a class="btn text-white" href="{{ route('login.index') }}">Login</a>
                    @endif
                </div>
            </div>
        </nav>
    </header>