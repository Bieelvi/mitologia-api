<div class="h-100 d-flex flex-column justify-content-center align-items-center">
    <div class="bg-light rounded px-5 py-5">
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
                <button type="submit" class="btn btn-primary mb-3">Create identity</button>
            </div>
        </form>   
        
        <div>
            <small>If you already have an account, <a href="{{ route('login.index') }}">click here</a>.</small>
        </div>
        
        <div>
            <small>Or login using one of the social networks below.</small>
        </div>

        <div class="d-flex justify-content-evenly mt-3">
            <div class="border rounded-3 p-2">
                <a href="{{ route('login.provider', ['provider' => 'github']) }}" class="text-decoration-none">
                    <img src="{{ asset('img/github-mark.png') }}" alt="Github logo" width="30px" class="px-1"> Github
                </a>
            </div>
            <div class="border rounded-3 p-2">
                <a href="{{ route('login.provider', ['provider' => 'gmail']) }}" class="text-decoration-none">
                    <img src="{{ asset('img/gmail-logo.png') }}" alt="Gmail logo" width="30px" class="px-1"> Gmail
                </a>
            </div>
        </div>
    </div>
</div>  