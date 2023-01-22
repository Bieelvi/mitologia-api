@extends('home')

@section('content')

<main style="height: 100vh">
    <section class="d-flex justify-content-center align-items-center">
        <div class="w-25 bg-light rounded px-5 py-5">
            <form action="{{ route('user.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="nickname" class="form-label">Name or nickname</label>
                    <input type="nickname" class="form-control" id="nickname" name="nickname" placeholder="bieelvi" required>
                </div>
        
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                </div>
        
                <div class="mb-3">
                    <label for="password" class="form-label">Your password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="your password" required>
                </div>
        
                <div class="mb-3">
                    <label for="repeatPassword" class="form-label">Repeat your password</label>
                    <input type="password" class="form-control" id="repeatPassword" name="repeatPassword" placeholder="repeat your password" required>
                </div>
        
                <div>
                    <button type="submit" class="btn btn-primary mb-3">Submit identity</button>
                </div>
            </form>   
        </div>
    </section>
</main>
    
@endsection