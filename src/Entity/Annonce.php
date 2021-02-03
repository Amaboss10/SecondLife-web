<?php

namespace App\Entity;

use App\Repository\AnnoceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnoceRepository::class)
 */
class Annonce
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
    private $titre_annonce;

    /**
     * @ORM\Column(type="text")
     */
    private $description_annonce;

    /**
     * @ORM\Column(type="float")
     */
    private $prix_annonce;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat_annonce;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_publication_annonce;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=SousCategorieAnnonce::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sous_categorie;

    /**
     * @ORM\ManyToOne(targetEntity=MarqueAnnonce::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $marque;

    /**
     * @ORM\OneToMany(targetEntity=PhotoAnnonce::class, mappedBy="annonce", orphanRemoval=true)
     */
    private $photoAnnonces;

    /**
     * @ORM\ManyToMany(targetEntity=Favoris::class, mappedBy="annonce")
     */
    private $favoris;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $poids_annonce;

    public function __construct()
    {
        $this->photoAnnonces = new ArrayCollection();
        $this->favoris = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreAnnonce(): ?string
    {
        return $this->titre_annonce;
    }

    public function setTitreAnnonce(string $titre_annonce): self
    {
        $this->titre_annonce = $titre_annonce;

        return $this;
    }

    public function getDescriptionAnnonce(): ?string
    {
        return $this->description_annonce;
    }

    public function setDescriptionAnnonce(string $description_annonce): self
    {
        $this->description_annonce = $description_annonce;

        return $this;
    }

    public function getPrixAnnonce(): ?float
    {
        return $this->prix_annonce;
    }

    public function setPrixAnnonce(float $prix_annonce): self
    {
        $this->prix_annonce = $prix_annonce;

        return $this;
    }

    public function getEtatAnnonce(): ?bool
    {
        return $this->etat_annonce;
    }

    public function setEtatAnnonce(bool $etat_annonce): self
    {
        $this->etat_annonce = $etat_annonce;

        return $this;
    }

    public function getDatePublicationAnnonce(): ?\DateTimeInterface
    {
        return $this->date_publication_annonce;
    }

    public function setDatePublicationAnnonce(\DateTimeInterface $date_publication_annonce): self
    {
        $this->date_publication_annonce = $date_publication_annonce;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSousCategorie(): ?SousCategorieAnnonce
    {
        return $this->sous_categorie;
    }

    public function setSousCategorie(?SousCategorieAnnonce $sous_categorie): self
    {
        $this->sous_categorie = $sous_categorie;

        return $this;
    }

    public function getMarque(): ?MarqueAnnonce
    {
        return $this->marque;
    }

    public function setMarque(?MarqueAnnonce $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * @return Collection|PhotoAnnonce[]
     */
    public function getPhotoAnnonces(): Collection
    {
        return $this->photoAnnonces;
    }

    public function addPhotoAnnonce(PhotoAnnonce $photoAnnonce): self
    {
        if (!$this->photoAnnonces->contains($photoAnnonce)) {
            $this->photoAnnonces[] = $photoAnnonce;
            $photoAnnonce->setAnnonce($this);
        }

        return $this;
    }

    public function removePhotoAnnonce(PhotoAnnonce $photoAnnonce): self
    {
        if ($this->photoAnnonces->removeElement($photoAnnonce)) {
            // set the owning side to null (unless already changed)
            if ($photoAnnonce->getAnnonce() === $this) {
                $photoAnnonce->setAnnonce(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Favoris[]
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavoris(Favoris $favoris): self
    {
        if (!$this->favoris->contains($favoris)) {
            $this->favoris[] = $favoris;
            $favoris->addAnnonce($this);
        }

        return $this;
    }

    public function removeFavoris(Favoris $favoris): self
    {
        if ($this->favoris->removeElement($favoris)) {
            $favoris->removeAnnonce($this);
        }

        return $this;
    }

    public function getPoidsAnnonce(): ?float
    {
        return $this->poids_annonce;
    }

    public function setPoidsAnnonce(?float $poids_annonce): self
    {
        $this->poids_annonce = $poids_annonce;

        return $this;
    }
}
