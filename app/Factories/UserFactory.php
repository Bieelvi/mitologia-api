<?php 

namespace App\Factories;

use App\Entities\Email;
use App\Entities\User;
use App\Repositories\RoleRepository;

class UserFactory
{
    private RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository) 
    {
        $this->roleRepository = $roleRepository;
    }

    public function factory(array $userInf): User
    {   
        $email = new Email();
        $email->setMain($userInf['email']);

        $role = $this->roleRepository->findOneBy(['name' => 'normal']);

        $user = new User();
        $user->setNickname($userInf['nickname'])
            ->setUrlAvatar($userInf['url_avatar'])
            ->setEmail($email)
            ->setPassword(null)
            ->setRepeatPassword(null)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
            ->setRole($role)
            ->setHashGithub($userInf['github'])
            ->setHashFacebook($userInf['facebook'])
            ->setHashGmail($userInf['gmail']);

        $email->setUser($user);

        return $user;
    }
}