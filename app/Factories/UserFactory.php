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
            ->setHashGithub(key_exists('github', $userInf) ? $userInf['github'] : null)
            ->setHashFacebook(key_exists('facebook', $userInf) ? $userInf['facebook'] : null)
            ->setHashGmail(key_exists('gmail', $userInf) ? $userInf['gmail'] : null);

        $email->setUser($user);

        return $user;
    }
}