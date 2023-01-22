<?php 

namespace App\Actions\LoginHandle;

use App\Entities\User;

interface ActionsAfterLoginHandle
{
    public function execute(User $user): void;
}