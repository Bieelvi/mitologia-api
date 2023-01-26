<form action="{{ route('user.update', ['id' => $user->getId()]) }}" method="post">
    @method('patch')
    @csrf

    <div class="mb-3">
        <label for="password" class="form-label">Your password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="your current password" required>
    </div>

    <div class="row mb-3">
        <div class="col-sm-6">
            <label for="newPassword" class="form-label">Your new password</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="your new password" required>
        </div>

        <div class="col-sm-6">
            <label for="repeatPassword" class="form-label">Repat password</label>
            <input type="password" class="form-control" id="repeatPassword" name="repeatPassword" placeholder="repeat your new password" required>
        </div>
    </div>

    <div>
        <button type="submit" class="btn btn-primary mb-3">Update password</button>
    </div>
</form>   