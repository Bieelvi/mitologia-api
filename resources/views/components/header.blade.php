<header>
    <nav class="container navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('img/logo-header.png') }}" width="45px" alt="Header logo">
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation" id="ariaExpanded" onclick="toggleCollapse()">
            <span class="navbar-toggler-icon"></span>
        </button>
            
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if (Session::has('logged_user'))
                    <li class="nav-item">
                        <a class="btn text-white" href="{{ route('profile.index') }}">Profile</a> 
                    </li>
                @endif
            </ul>
            <div class="d-flex">
                @if (Session::has('logged_user'))
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <input type="submit" class="btn btn-outline-danger" value="Sing out">
                    </form>    
                @else    
                    <a class="btn btn-outline-light mx-1" href="{{ route('login.index') }}">Sing in</a>
                    <a class="btn btn-outline-success mx-1" href="{{ route('user.index') }}">Sing up</a>
                @endif
            </div>
        </div>
    </nav>
</header>