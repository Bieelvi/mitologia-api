<?php 

namespace App\Crypt;

use App\Entities\User;
use Illuminate\Support\Facades\Crypt;

class UserCrypt
{
    public function encrypt(User $user): string
    {
        return Crypt::encrypt($user);
    }

    public function decrypt(string $crypt): User
    {
        return Crypt::decrypt($crypt);
    }
}