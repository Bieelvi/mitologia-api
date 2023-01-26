<?php 

namespace App\Repositories;

use App\Entities\Login;
use Doctrine\Persistence\ObjectRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;

class LogUserRepository
{
    private ObjectRepository $repository;

    public function __construct()
    {
        $this->repository = EntityManager::getRepository(Login::class);
    }

    public function findOneBy(array $criteria): Login|null
    {
        return $this->repository->findOneBy($criteria);
    }
}