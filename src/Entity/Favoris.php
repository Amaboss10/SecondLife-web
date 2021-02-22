<?php

namespace App\Entity;

use App\Repository\FavorisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FavorisRepository::class)
 */
class Favoris
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Annonce::class)
     * @ORM\JoinColumn(name="annonce", referencedColumnName="id", nullable=false)
     */
    private $id_annonce;

    /**
     * 
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @ORM\JoinColumn(name="utilisateur", referencedColumnName="id_personne", nullable=false)
     */
    private $id_utilisateur;

    /**
     * date ajout à la liste des favoris
     * @ORM\Column(type="datetime")
     */
    private $date_favoris;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdAnnonce(): ?Annonce
    {
        return $this->id_annonce;
    }

    public function setIdAnnonce(?Annonce $id_annonce): self
    {
        $this->id_annonce = $id_annonce;

        return $this;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $id_utilisateur): self
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }

    public function getDateFavoris(): ?\DateTimeInterface
    {
        return $this->date_favoris;
    }

    public function setDateFavoris(\DateTimeInterface $date_favoris): self
    {
        $this->date_favoris = $date_favoris;

        return $this;
    }
}
