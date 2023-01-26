<?php 

namespace App\Actions\LogoutHandle;

use App\Entities\User;

class DeleteLoggedUserSession implements ActionsAfterLogoutHandle
{
    public function execute(User $user): void
    {
        session()->flush();
    }
}