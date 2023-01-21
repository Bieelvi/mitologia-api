<?php

namespace App\Models;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_oficial")
 */
class UserOficial
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $firstname;

    public function setFirstName(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }
}