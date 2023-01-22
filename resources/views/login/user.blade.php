<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('components.link')
    <title>Mitology - Login</title>
</head>
<body class="bg-dark">
    <main class="d-flex flex-column justify-content-center align-items-center" style="height: 100vh">
        <section>
            <div class="text-white text-center">
                <h1>MITOLOGY API</h1>
            </div>
            <div class="bg-light rounded px-5 py-5">
                <form action="{{ route('login.login') }}" method="post">
                    @csrf           
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                    </div>
            
                    <div class="mb-3">
                        <label for="password" class="form-label">Your password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="your password" required>
                    </div>
            
                    <div>
                        <button type="submit" class="btn btn-primary mb-3">Submit identity</button>
                    </div>
                </form>   
                <span><small>If you don't have an account, <a href="{{ route('user.index') }}">click here</a></small></span>
            </div>
        </section>
    </main>  
@include('components.msgError')
@include('components.msg')  
</body>
@include('components.script')
</html>