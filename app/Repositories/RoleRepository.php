<?php 

namespace App\Repositories;

use App\Entities\Role;
use Doctrine\Persistence\ObjectRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;

class RoleRepository
{
    private ObjectRepository $repository;

    public function __construct()
    {
        $this->repository = EntityManager::getRepository(Role::class);
    }

    public function findOneBy(array $criteria): Role|null
    {
        return $this->repository->findOneBy($criteria);
    }
}