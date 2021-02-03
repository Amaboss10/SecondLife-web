<?php

namespace App\Entity;

use App\Repository\SousCategorieAnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SousCategorieAnnonceRepository::class)
 */
class SousCategorieAnnonce
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
    private $nom_souscategorie;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieAnnonce::class, inversedBy="sousCategorieAnnonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie_annonce;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="sous_categorie", orphanRemoval=true)
     */
    private $annonces;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSouscategorie(): ?string
    {
        return $this->nom_souscategorie;
    }

    public function setNomSouscategorie(string $nom_souscategorie): self
    {
        $this->nom_souscategorie = $nom_souscategorie;

        return $this;
    }

    public function getCategorieAnnonce(): ?CategorieAnnonce
    {
        return $this->categorie_annonce;
    }

    public function setCategorieAnnonce(?CategorieAnnonce $categorie_annonce): self
    {
        $this->categorie_annonce = $categorie_annonce;

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setSousCategorie($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getSousCategorie() === $this) {
                $annonce->setSousCategorie(null);
            }
        }

        return $this;
    }
}
