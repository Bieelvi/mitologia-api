<form action="{{ route('user.update', ['id' => $user->getId()]) }}" method="post">
    @method('patch')
    @csrf
    <div class="mb-3">
        <label for="nickname" class="form-label">Name or nickname</label>
        <input type="nickname" class="form-control" id="nickname" name="nickname" value="{{ $user->getNickname() }}" required>
    </div>

    <div class="row mb-3">
        <div class="col-sm-6">
            <label for="createdAt" class="form-label">Created at</label>
            <input type="text" class="form-control" id="createdAt" name="createdAt" value="{{ $user->getCreatedAt()->format('Y-m-d H:i:s') }}" disabled>
        </div>
        <div class="col-sm-6">
            <label for="updatedAt" class="form-label">Updated at</label>
            <input type="text" class="form-control" id="updatedAt" name="updatedAt" value="{{ $user->getUpdatedAt()->format('Y-m-d H:i:s') }}" disabled>
        </div>
    </div>

    <div>
        <button type="submit" class="btn btn-primary mb-3">Update identity</button>
    </div>
</form>  