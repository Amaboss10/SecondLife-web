<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use App\Repository\AnnonceRepository;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
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
     * @ORM\Column(type="string", length=50)
     */
    private $titre_annonce;

    /**
     * @ORM\Column(type="text")
     */
    private $description_annonce;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix_annonce;

    /**
     * @ORM\Column(type="integer")
     */
    private $poids_annonce;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $etat_annonce;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_publi_annonce;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="annonces")
     * @ORM\JoinColumn(name="categorie", referencedColumnName="id", nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=Marque::class, inversedBy="annonces")
     * @ORM\JoinColumn(name="marque", referencedColumnName="id", nullable=false)
     */
    private $marque;

    /**
     * @ORM\OneToMany(targetEntity=PhotoAnnonce::class, mappedBy="annonce",cascade={"persist"})
     * @ORM\JoinColumn(name="images_annonce", referencedColumnName="id")
     */
    private $images_annonce;

    /**
     * @ORM\ManyToOne(targetEntity=SousCategorie::class, inversedBy="annonces")
     * @ORM\JoinColumn(name="sous_categorie", referencedColumnName="id", nullable=false)
     */
    private $sous_categorie;

    /**
     * @ORM\Column(type="boolean")
     */
    private $est_valide;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="annonces")
     * @ORM\JoinColumn(name="utilisateur", referencedColumnName="id_personne", nullable=false)
     */
    private $utilisateur;

    public function __construct()
    {
        $this->images_annonce = new ArrayCollection();
        //image_annonce par defaut
        $imageAnnonce=new PhotoAnnonce();
        $imageAnnonce->setLienPhotoAnnonce("https://placehold.it/130x130?text=IMG")
                     ->setAnnonce($this);
        $this->images_annonce[] = $imageAnnonce;
        
        $this->est_valide=false;
        $this->etat_annonce='Pas vendu';
        $this->date_publi_annonce=new DateTime();
    }

    public function getIdAnnonce(): ?int
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

    public function getPrixAnnonce(): ?int
    {
        return $this->prix_annonce;
    }

    public function setPrixAnnonce(int $prix_annonce): self
    {
        $this->prix_annonce = $prix_annonce;

        return $this;
    }

    public function getPoidsAnnonce(): ?int
    {
        return $this->poids_annonce;
    }

    public function setPoidsAnnonce(int $poids_annonce): self
    {
        $this->poids_annonce = $poids_annonce;

        return $this;
    }

    public function getEtatAnnonce(): ?string
    {
        return $this->etat_annonce;
    }

    public function setEtatAnnonce(string $etat_annonce): self
    {
        $this->etat_annonce = $etat_annonce;

        return $this;
    }

    public function getDatePubliAnnonce(): ?\DateTimeInterface
    {
        return $this->date_publi_annonce;
    }

    public function setDatePubliAnnonce(\DateTimeInterface $date_publi_annonce): self
    {
        $this->date_publi_annonce = $date_publi_annonce;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

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

    /**
     * @return Collection|PhotoAnnonce[]
     */
    public function getImagesAnnonce(): Collection
    {
        return $this->images_annonce;
    }

    public function addImagesAnnonce(PhotoAnnonce $imagesAnnonce): self
    {
        if (!$this->images_annonce->contains($imagesAnnonce)) {
            $this->images_annonce[] = $imagesAnnonce;
            $imagesAnnonce->setAnnonce($this);
        }

        return $this;
    }

    public function removeImagesAnnonce(PhotoAnnonce $imagesAnnonce): self
    {
        if ($this->images_annonce->removeElement($imagesAnnonce)) {
            // set the owning side to null (unless already changed)
            if ($imagesAnnonce->getAnnonce() === $this) {
                $imagesAnnonce->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getSousCategorie(): ?SousCategorie
    {
        return $this->sous_categorie;
    }

    public function setSousCategorie(?SousCategorie $sous_categorie): self
    {
        $this->sous_categorie = $sous_categorie;

        return $this;
    }

    public function getEstValide(): ?bool
    {
        return $this->est_valide;
    }

    public function setEstValide(bool $est_valide): self
    {
        $this->est_valide = $est_valide;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

}
