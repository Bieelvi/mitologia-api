<?php 

namespace App\Handles;

use App\Actions\LoginHandle\ActionsAfterLoginHandle;
use App\Entities\User;
use App\Exceptions\NotFoundException;
use App\Repositories\UserRepository;

class LoginHandle 
{
    /** @var ActionsAfterLoginHandle[] */
    private array $actions;
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->actions = [];
        $this->repository = $repository;
    }

    public function addActions(ActionsAfterLoginHandle $actionsAfterLoginHandle)
    {
        $this->actions[] = $actionsAfterLoginHandle;
    }

    public function execute(User $userLogin)
    {
        $user = $this->repository->findOneBy([
            'email' => $userLogin->getEmail()
        ]);
        if (is_null($user))
            throw new NotFoundException("User not found!");

        $user->verifiyPassword($userLogin->getPassword());
        
        foreach ($this->actions as $action) {
            $action->execute($user);
        }
    }
}