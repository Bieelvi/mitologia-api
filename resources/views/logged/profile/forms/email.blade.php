<div class="row mb-3">
    <form action="{{ route('user.update.email', ['id' => $user->getId()]) }}" method="post" class="col-sm-6">
        @method('patch')
        @csrf
       
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="newEmail" name="email" placeholder="your new email" value="{{ $user->getEmail()->getMain() }}" required>
        </div>
    
        <div class="d-none mb-3" id="passwordDiv">
            <input type="password" class="form-control" id="passwordEmail" name="password" placeholder="please enter your password" required>
        </div>
    
        <div>
            <button type="submit" class="btn btn-primary mb-3">Update email</button>
        </div>
    </form>  
    
    <form action="{{ route('user.verified.email', ['id' => $user->getId()]) }}" method="post" class="col-sm-6">
        @csrf
       
        <div class="mb-3">
            <label for="verifiedEmail" class="form-label">Verified email address</label>
            <input type="text" class="form-control" id="verifiedEmail" name="verifiedEmail" value="{{ $user->getEmail()->getVerified() ? "Yes" : "No" }}" disabled>
        </div>
        
        @if (!$user->getEmail()->getVerified())
            <div>
                <button type="submit" class="btn btn-primary mb-3">Verified email</button>
            </div>            
        @endif
    </form>  
</div>

<script>
    document.getElementById('newEmail').addEventListener("input", (element) => {
        const div = document.getElementById('passwordDiv');

        if (element.target.value != "{{ $user->getEmail()->getMain() }}") {
            div.classList.remove('d-none');
        } else {
            div.classList.add('d-none');
        }   
    });
</script>