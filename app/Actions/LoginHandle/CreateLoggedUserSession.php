<?php 

namespace App\Actions\LoginHandle;

use App\Crypt\DurationSessionCrypt;
use App\Crypt\UserCrypt;
use App\Entities\User;

class CreateLoggedUserSession implements ActionsAfterLoginHandle
{
    public function execute(User $user): void
    {
        $userCrypt = new UserCrypt();
        $durattionSessionCrypt = new DurationSessionCrypt();
        
        session()->put(
            'logged_user', 
            $userCrypt->encrypt($user)
        );

        session()->put(
            'logged_user_duration', 
            $durattionSessionCrypt->encrypt()
        );
    }
}