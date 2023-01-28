<?php 

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="roles")
 */
class Role
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $name;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private \DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at")
     */
    private \DateTime $updatedAt;

    /**
     * @var Collection<int, User>
    * @ORM\OneToMany(targetEntity="User", mappedBy="role")
    */
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
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

    public function getUser(): ArrayCollection
    {
        return $this->users;
    }

}