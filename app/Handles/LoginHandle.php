<?php 

namespace App\Handles;

use App\Actions\LoginHandle\ActionsAfterLoginHandle;
use App\Entities\User;
use App\Exceptions\NotFoundException;
use App\Repositories\EmailRepository;

class LoginHandle 
{
    /** @var ActionsAfterLoginHandle[] */
    private array $actions;
    private EmailRepository $repository;

    public function __construct(EmailRepository $repository)
    {
        $this->actions = [];
        $this->repository = $repository;
    }

    public function addActions(ActionsAfterLoginHandle $actionsAfterLoginHandle)
    {
        $this->actions[] = $actionsAfterLoginHandle;
    }

    public function execute(User $user)
    {
        $email = $this->repository->findOneBy([
            'main' => $user->getEmail()->getMain()
        ]);
        if (is_null($email))
            throw new NotFoundException("User not found!");

        if (!$email->getUser()->getHashGithub() && !$email->getUser()->getHashFacebook() && !$email->getUser()->getHashGmail())  
            $email->getUser()->verifiyPassword($user->getPassword());
        
        foreach ($this->actions as $action) {
            $action->execute($email->getUser());
        }
    }
}