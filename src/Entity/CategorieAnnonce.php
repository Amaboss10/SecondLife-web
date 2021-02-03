<?php

namespace App\Entity;

use App\Repository\CategorieAnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieAnnonceRepository::class)
 */
class CategorieAnnonce
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
    private $nom_categorie;

    /**
     * @ORM\OneToMany(targetEntity=SousCategorieAnnonce::class, mappedBy="categorie_annonce", orphanRemoval=true)
     */
    private $sousCategorieAnnonces;

    public function __construct()
    {
        $this->sousCategorieAnnonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nom_categorie;
    }

    public function setNomCategorie(string $nom_categorie): self
    {
        $this->nom_categorie = $nom_categorie;

        return $this;
    }

    /**
     * @return Collection|SousCategorieAnnonce[]
     */
    public function getSousCategorieAnnonces(): Collection
    {
        return $this->sousCategorieAnnonces;
    }

    public function addSousCategorieAnnonce(SousCategorieAnnonce $sousCategorieAnnonce): self
    {
        if (!$this->sousCategorieAnnonces->contains($sousCategorieAnnonce)) {
            $this->sousCategorieAnnonces[] = $sousCategorieAnnonce;
            $sousCategorieAnnonce->setCategorieAnnonce($this);
        }

        return $this;
    }

    public function removeSousCategorieAnnonce(SousCategorieAnnonce $sousCategorieAnnonce): self
    {
        //tester si la sous categorie est vide
        if ($this->sousCategorieAnnonces->removeElement($sousCategorieAnnonce)) {
            // set the owning side to null (unless already changed)
            if ($sousCategorieAnnonce->getCategorieAnnonce() === $this) {
                $sousCategorieAnnonce->setCategorieAnnonce(null);
            }
        }

        return $this;
    }
}
