<?php 

namespace App\Repositories;

use App\Entities\Email;
use Doctrine\Persistence\ObjectRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;

class EmailRepository
{
    private ObjectRepository $repository;

    public function __construct()
    {
        $this->repository = EntityManager::getRepository(Email::class);
    }

    public function findOneBy(array $criteria): Email|null
    {
        return $this->repository->findOneBy($criteria);
    }
}