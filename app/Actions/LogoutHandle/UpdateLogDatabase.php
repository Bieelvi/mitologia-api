<?php 

namespace App\Actions\LogoutHandle;

use App\Entities\User;
use LaravelDoctrine\ORM\Facades\EntityManager;

class UpdateLogDatabase implements ActionsAfterLogoutHandle
{
    public function execute(User $user): void
    {
        $lastLogUser = $user->getAccess()->last();
        $lastLogUser->setLoggedOutAt(new \DateTime());

        EntityManager::flush();
    }
}