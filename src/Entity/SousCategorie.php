<?php

namespace App\Entity;

use App\Repository\SousCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SousCategorieRepository::class)
 */
class SousCategorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=70)
     */
    private $nom_sous_categorie;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="sous_categories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    // /**
    //  * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="sous_categorie")
    //  */
    // private $annonces;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSousCategorie(): ?string
    {
        return $this->nom_sous_categorie;
    }

    public function setNomSousCategorie(string $nom_sous_categorie): self
    {
        $this->nom_sous_categorie = $nom_sous_categorie;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    // /**
    //  * @return Collection|Annonce[]
    //  */
    // public function getAnnonces(): Collection
    // {
    //     return $this->annonces;
    // }

    // public function addAnnonce(Annonce $annonce): self
    // {
    //     if (!$this->annonces->contains($annonce)) {
    //         $this->annonces[] = $annonce;
    //         $annonce->setSousCategorie($this);
    //     }

    //     return $this;
    // }

    // public function removeAnnonce(Annonce $annonce): self
    // {
    //     if ($this->annonces->removeElement($annonce)) {
    //         // set the owning side to null (unless already changed)
    //         if ($annonce->getSousCategorie() === $this) {
    //             $annonce->setSousCategorie(null);
    //         }
    //     }

    //     return $this;
    // }
}
