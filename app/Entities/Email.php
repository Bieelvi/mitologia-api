<?php 

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="email")
 */
class Email
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
    private string $main;

    /**
     * @ORM\Column(type="string", nullable="true")
     */
    private string $recovery;

    /**
     * @ORM\Column(type="string")
     */
    private bool $verified;

    /**
     * @ORM\Column(type="datetime", name="verified_at", nullable="true")
     */
    private ?\DateTime $verifiedAt;

    /**
     * @ORM\Column(type="string", name="hash_verified", length="1000", nullable="true")
     */ 
    private ?string $hashVerified;

    /**
    * @ORM\OneToOne(targetEntity="User", inversedBy="email", cascade={"persist", "remove"})
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private User $user;

    public function __construct()
    {
        $this->verified = false;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setMain(string $main): self
    {
        $this->main = $main;
        return $this;
    }

    public function getMain(): string
    {
        return $this->main;
    }
    
    public function setRecovery(string $recovery): self
    {
        $this->recovery = $recovery;
        return $this;
    }

    public function getRecovery(): string
    {
        return $this->recovery;
    }

    public function setVerified(bool $verified): self
    {
        $this->verified = $verified;
        return $this;
    }

    public function getVerified(): bool
    {
        return $this->verified;
    }

    public function setVerifiedAt(?\DateTime $verifiedAt): self
    {
        $this->verifiedAt = $verifiedAt;
        return $this;
    }

    public function getVerifiedAt(): ?\DateTime
    {
        return $this->verifiedAt;
    }

    public function setHashVerified(?string $hashVerified): self
    {
        $this->hashVerified = $hashVerified;
        return $this;
    }

    public function getHashVerified(): ?string
    {
        return $this->hashVerified;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

}