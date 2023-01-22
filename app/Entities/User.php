<?php

namespace App\Entities;

use App\Exceptions\PasswordException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping AS ORM;
use Illuminate\Support\Facades\Hash;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_oficial")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $nickname;

    /**
     * @ORM\Column(type="string")
     */
    private string $email;

    /**
     * @ORM\Column(type="string")
     */
    private string $password;

    private string $repeatPassword;

    /**
     * @ORM\Column(type="datetime", name="created_at"))
     */
    private \DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at"))
     */
    private \DateTime $updatedAt;

    /**
     * @var Collection<int, Login>
     * @ORM\OneToMany(targetEntity="Login", mappedBy="user_id", cascade={"persist"})
     */
    private Collection $access;

    public function __construct()
    {
        $this->access = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;
        return $this;
    }

    public function getNickname(): string
    {
        return $this->nickname; 
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email; 
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password; 
    }

    public function setRepeatPassword(string $repeatPassword): self
    {
        $this->repeatPassword = $repeatPassword;
        return $this;
    }

    public function getRepeatPassword(): string
    {
        return $this->repeatPassword; 
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt; 
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt; 
    }

    public function hashPassword(): void
    {
        $this->password = Hash::make($this->password);
    }   

    public function verifiyPassword(string $password): void
    {
        if (!Hash::check($password, $this->password))
            throw new PasswordException('Incorrect credentials');
    }

    public function checkSamePassword(): void
    {
        if (!Hash::check($this->repeatPassword, $this->password))
            throw new PasswordException('Passwords do not match');
    }

    public function getAccess(): Collection
    {
        return $this->access;
    }
}