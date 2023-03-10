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
     * @ORM\OneToOne(targetEntity="Email", mappedBy="user", cascade={"persist", "remove"})
     */
    private Email $email;

    private ?string $password;

    private ?string $repeatPassword;

    /**
     * @ORM\Column(type="string", name="password", nullable=true)
     */
    private ?string $hashedPassword;

    /**
     * @ORM\Column(type="string", name="hashGithub", nullable=true)
     */
    private ?string $hashGithub;

    /**
     * @ORM\Column(type="string", name="hashFacebook", nullable=true)
     */
    private ?string $hashFacebook;

    /**
     * @ORM\Column(type="string", name="hashGmail", nullable=true)
     */
    private ?string $hashGmail;

    /**
     * @ORM\Column(type="string", name="urlAvatar", nullable=true)
     */
    private ?string $urlAvatar;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private \DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at")
     */
    private \DateTime $updatedAt;

    /**
     * @var Collection<int, Login>
     * @ORM\OneToMany(targetEntity="Login", mappedBy="user", cascade={"persist", "remove"})
     */
    private Collection $access;

    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="users", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    private Role $role;

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

    public function setEmail(Email $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail(): Email
    {
        return $this->email; 
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password; 
    }

    public function setRepeatPassword(?string $repeatPassword): self
    {
        $this->repeatPassword = $repeatPassword;
        return $this;
    }

    public function getRepeatPassword(): ?string
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
        $this->hashedPassword = Hash::make($this->password);
    }   

    public function verifiyPassword(string $password): void
    {
        if (!Hash::check($password, $this->hashedPassword))
            throw new PasswordException('Incorrect credentials');
    }

    public function checkSamePassword(): void
    {
        if (!Hash::check($this->repeatPassword, $this->hashedPassword))
            throw new PasswordException('Passwords do not match');
    }

    public function getAccess(): Collection
    {
        return $this->access;
    }

    public function setRole(Role $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getRole(): Role
    {
        return $this->role; 
    }

    public function setHashFacebook(?string $hashFacebook): self
    {
        $this->hashFacebook = $hashFacebook;
        return $this;
    }

    public function getHashFacebook(): ?string
    {
        return $this->hashFacebook; 
    }

    public function setHashGithub(?string $hashGithub): self
    {
        $this->hashGithub = $hashGithub;
        return $this;
    }

    public function getHashGithub(): ?string
    {
        return $this->hashGithub; 
    }

    public function setHashGmail(?string $hashGmail): self
    {
        $this->hashGmail = $hashGmail;
        return $this;
    }

    public function getHashGmail(): ?string
    {
        return $this->hashGmail; 
    }

    public function setUrlAvatar(?string $urlAvatar): self
    {
        $this->urlAvatar = $urlAvatar;
        return $this;
    }

    public function getUrlAvatar(): ?string
    {
        return $this->urlAvatar; 
    }
}