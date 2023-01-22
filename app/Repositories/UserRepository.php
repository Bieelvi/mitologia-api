<?php 

namespace App\Repositories;

use App\Entities\User;
use App\Exceptions\NotFoundException;
use Doctrine\Persistence\ObjectRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;

class UserRepository
{
    private ObjectRepository $repository;

    public function __construct()
    {
        $this->repository = EntityManager::getRepository(User::class);
    }

    public function findOneBy(array $criteria): User|null
    {
        return $this->repository->findOneBy($criteria);
    }
}