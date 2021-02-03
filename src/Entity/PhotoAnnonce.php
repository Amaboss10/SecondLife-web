<?php

namespace App\Entity;

use App\Repository\PhotoAnnonceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotoAnnonceRepository::class)
 */
class PhotoAnnonce
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
    private $lien_photoAnnonce;

    /**
     * @ORM\ManyToOne(targetEntity=Annonce::class, inversedBy="photoAnnonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $annonce;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLienPhotoAnnonce(): ?string
    {
        return $this->lien_photoAnnonce;
    }

    public function setLienPhotoAnnonce(string $lien_photoAnnonce): self
    {
        $this->lien_photoAnnonce = $lien_photoAnnonce;

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }
}
