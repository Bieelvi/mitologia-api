<?php 

namespace App\Crypt;

use App\Entities\User;
use App\Exceptions\InvalidTokenException;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Crypt;

class EmailCrypt
{
    private string $crypt;
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function encrypt(User $user): string
    {
        $today = (new \DateTime())->format('Y-m-d H:i:s');
        $value = ['today' => $today, 'id' => $user->getId()];

        $this->crypt = Crypt::encrypt($value);

        return $this->crypt;
    }

    public function decrypt(string $crypt): array
    {
        $this->crypt = $crypt;

        return Crypt::decrypt($this->crypt);
    }

    public function valid(string $crypt): User
    {
        $token = $this->decrypt($crypt);

        $date = new \DateTime($token['today']);
        $now = new \DateTime();

        $diff = $now->diff($date);
        if ($diff->format("%I") > "10") {
            throw new InvalidTokenException('Invalid token');
        }

        $user = $this->repository->findOneBy(['id' => $token['id']]);
        if (is_null($user)) {
            throw new InvalidTokenException('Invalid token');
        }

        return $user;
    }
}