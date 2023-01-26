<?php 

namespace App\Handles;

use App\Actions\LogoutHandle\ActionsAfterLogoutHandle;
use App\Crypt\UserCrypt;
use App\Exceptions\NotFoundException;
use App\Repositories\UserRepository;

class LogoutHandle
{
    /** @var ActionsAfterLogoutHandle[] */
    private array $actions;
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->actions = [];
        $this->repository = $repository;
    }

    public function addActions(ActionsAfterLogoutHandle $actionsAfterLogoutHandle)
    {
        $this->actions[] = $actionsAfterLogoutHandle;
    }

    public function execute()
    {
        $crypt = new UserCrypt();
        $userDecrypt = $crypt->decrypt(session()->get('logged_user'));
        $user = $this->repository->findOneBy([
            'id' => $userDecrypt->getId()
        ]);
        if (is_null($user)) {
            throw new NotFoundException('User not found!');
        }

        foreach ($this->actions as $action) {
            $action->execute($user);
        }
    }
}