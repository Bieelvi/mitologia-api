<?php 

namespace App\Actions\LoginHandle;

use App\Entities\Login;
use App\Entities\User;
use LaravelDoctrine\ORM\Facades\EntityManager;

class RegisterLogDatabase implements ActionsAfterLoginHandle
{
    public function execute(User $user): void
    {
        $login = new Login();
        $login->setLoggedAt(new \DateTime())
            ->setUser($user); 

        EntityManager::persist($user);
        EntityManager::flush();
    }
}