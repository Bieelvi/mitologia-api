<div class="h-100 d-flex flex-column justify-content-center align-items-center">
    <div class="bg-light rounded px-5 py-5" style="width: 340px">
        <form wire:submit.prevent="login">        
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="name@example.com" wire:model="email" required>
                @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
    
            <div class="mb-3">
                <label for="password" class="form-label">Your password</label>
                <input type="password" class="form-control" id="password" placeholder="your password" wire:model="password" required>
                @error('password') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
    
            <div>
                <button type="submit" class="btn btn-primary mb-3">Submit identity</button>
            </div>
        </form>   
        <span><small>If you don't have an account, <a href="{{ route('user.index') }}">click here</a></small></span>
    </div>
    @include('components.msg')  
    @include('components.msgError')
</div>  

