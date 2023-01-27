<?php 

namespace App\Crypt;

use App\Exceptions\InvalidTokenException;
use Illuminate\Support\Facades\Crypt;

class DurationSessionCrypt
{
    private string $crypt;

    public function encrypt(): string
    {
        $this->crypt = Crypt::encrypt(new \DateTime());

        return $this->crypt;
    }

    public function decrypt(string $crypt): \DateTime
    {
        $this->crypt = $crypt;

        return Crypt::decrypt($this->crypt);
    }

    public function valid(string $crypt)
    {
        $date = $this->decrypt($crypt);
        $now = new \DateTime();

        $diff = $now->diff($date);
        $minutes = $diff->format("%I");
        if ($minutes >= "20") {
            throw new InvalidTokenException('Need to login again');
        }

        $this->encrypt();
    }
}