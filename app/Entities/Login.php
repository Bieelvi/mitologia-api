<?php 

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="log_user_access")
 */
class Login
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="bigint")
     * @ORM\ManyToOne(targetEntity="User", inversedBy="access")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private User $user;

    /**
     * @ORM\Column(type="datetime", name="logged_at"))
     */
    private \DateTime $loggedAt;

    /**
     * @ORM\Column(type="datetime", name="logged_out_at", nullable=true)
     */
    private \DateTime $loggedOutAt;

    public function getId(): int
    {
        return $this->id;
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

    public function setLoggedAt(\DateTime $loggedAt): self
    {
        $this->loggedAt = $loggedAt;
        return $this;
    }

    public function getLoggedAt(): \DateTime
    {
        return $this->loggedAt;
    }

    public function setLoggedOutAt(\DateTime $loggedOutAt): self
    {
        $this->loggedOutAt = $loggedOutAt;
        return $this;
    }

    public function getLoggedOutAt(): \DateTime
    {
        return $this->loggedOutAt;
    }
}