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
     * @ORM\Column(type="string", length=255)
     */
    private $lien_photo_annonce;

    /**
     * @ORM\ManyToOne(targetEntity=Annonce::class, inversedBy="images_annonce")
     * @ORM\JoinColumn(nullable=false)
     */
    private $annonce;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLienPhotoAnnonce(): ?string
    {
        return $this->lien_photo_annonce;
    }

    public function setLienPhotoAnnonce(string $lien_photo_annonce): self
    {
        $this->lien_photo_annonce = $lien_photo_annonce;

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
    public function __toString()
    {
        return $this->lien_photo_annonce;
    }
}
