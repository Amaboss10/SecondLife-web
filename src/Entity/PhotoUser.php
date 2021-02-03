<?php

namespace App\Entity;

use App\Repository\PhotoUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotoUserRepository::class)
 */
class PhotoUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $lien_photoUser;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="photoUser", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLienPhotoUser(): ?string
    {
        return $this->lien_photoUser;
    }

    public function setLienPhotoUser(string $lien_photoUser): self
    {
        $this->lien_photoUser = $lien_photoUser;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
