<?php

namespace App\Entity;

use App\Repository\AdministrateurRepository;
use App\Repository\CategorieFAQRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieFAQRepository::class)
 */
class CategorieFAQ
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
     * @ORM\OneToMany(targetEntity=FAQ::class, mappedBy="categorie_faq")
     * @ORM\JoinColumn(name="faqs", referencedColumnName="id", nullable=false)
     */
    private $faqs;

    /**
     * @ORM\ManyToOne(targetEntity=Administrateur::class)
     * @ORM\JoinColumn(name="administrateur", referencedColumnName="id_personne", nullable=false)
     */
    private $id_administrateur;

    public function __construct()
    {
        // $this->id_administrateur=$adminRepos->findOneBy(['id_personne'=>'1']);
        $this->faqs = new ArrayCollection();
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
     * @return Collection|FAQ[]
     */
    public function getFAQs(): Collection
    {
        return $this->faqs;
    }

    public function addFAQ(FAQ $fAQ): self
    {
        if (!$this->faqs->contains($fAQ)) {
            $this->faqs[] = $fAQ;
            $fAQ->setCategorieFaq($this);
        }

        return $this;
    }

    public function removeFAQ(FAQ $fAQ): self
    {
        if ($this->faqs->removeElement($fAQ)) {
            // set the owning side to null (unless already changed)
            if ($fAQ->getCategorieFaq() === $this) {
                $fAQ->setCategorieFaq(null);
            }
        }

        return $this;
    }

    public function getIdAdministrateur(): ?Administrateur
    {
        return $this->id_administrateur;
    }

    public function setIdAdministrateur(?Administrateur $id_administrateur): self
    {
        $this->id_administrateur = $id_administrateur;

        return $this;
    }

    public function __toString()
    {
        return $this->nom_categorie;
    }
}
