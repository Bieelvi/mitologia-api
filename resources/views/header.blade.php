<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('components.link')
    <title>{{ $titlePage }}</title>
</head>

<body class="bg-dark">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">LOGO</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link" href="#">API</a>
                    </div>
                </div>
                <div class="navbar-nav">
                    @if (Session::has('logged_user'))
                        <form action="{{ url('/logout') }}" method="post">
                            @csrf
                            <input type="submit" class="btn text-white" value="Logout">
                        </form>    
                    @else                        
                        <form action="{{ url('/get') }}" method="post">
                            @csrf
                            <input type="submit" class="btn text-white" value="Login">
                        </form>    
                    @endif
                </div>
            </div>
        </nav>
    </header>