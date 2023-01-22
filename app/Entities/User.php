<?php

namespace App\Entities;

use App\Exceptions\PasswordException;
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
     * @ORM\Column(type="date", name="created_at"))
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="date", name="updated_at"))
     */
    private \DateTimeImmutable $updatedAt;

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
        $this->password = Hash::make($password);
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

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt; 
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt; 
    }

    public function verifiyPassword(string $password): void
    {
        if (!Hash::check($password, $this->password))
            throw new PasswordException('Wrong password or email');
    }

    public function checkSamePassword(): void
    {
        if (!Hash::check($this->repeatPassword, $this->password))
            throw new PasswordException('Passwords do not match');
    }
}