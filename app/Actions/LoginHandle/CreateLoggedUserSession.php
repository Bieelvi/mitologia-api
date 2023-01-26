<?php 

namespace App\Actions\LoginHandle;

use App\Crypt\UserCrypt;
use App\Entities\User;

class CreateLoggedUserSession implements ActionsAfterLoginHandle
{
    public function execute(User $user): void
    {
        $crypt = new UserCrypt();
        $encryptTokenSession = $crypt->encrypt($user);
        
        session()->put(
            'logged_user', 
            $encryptTokenSession
        );
    }
}