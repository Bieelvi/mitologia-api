<?php 

namespace App\Actions\LogoutHandle;

use App\Entities\User;

interface ActionsAfterLogoutHandle
{
    public function execute(User $user): void;
}