<?php

namespace App\Entity;

use App\Repository\FAQRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FAQRepository::class)
 */
class FAQ
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
    private $titre_probleme; 

    /**
     * @ORM\Column(type="text")
     */
    private $description_probleme;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_probleme;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieFAQ::class, inversedBy="faqs")
     * @ORM\JoinColumn(name="categorie_faq", referencedColumnName="id", nullable=false)
     */
    private $categorie_faq;

    /**
     * @ORM\ManyToOne(targetEntity=Administrateur::class)
     * @ORM\JoinColumn(name="administrateur", referencedColumnName="id_personne", nullable=false)
     */
    private $id_administrateur;

    public function __construct()
    {
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreProbleme(): ?string
    {
        return $this->titre_probleme;
    }

    public function setTitreProbleme(string $titre_probleme): self
    {
        $this->titre_probleme = $titre_probleme;

        return $this;
    }

    public function getDescriptionProbleme(): ?string
    {
        return $this->description_probleme;
    }

    public function setDescriptionProbleme(string $description_probleme): self
    {
        $this->description_probleme = $description_probleme;

        return $this;
    }

    public function getDateProbleme(): ?\DateTimeInterface
    {
        return $this->date_probleme;
    }

    public function setDateProbleme(\DateTimeInterface $date_probleme): self
    {
        $this->date_probleme = $date_probleme;

        return $this;
    }

    public function getCategorieFaq(): ?CategorieFAQ
    {
        return $this->categorie_faq;
    }

    public function setCategorieFaq(?CategorieFAQ $categorie_faq): self
    {
        $this->categorie_faq = $categorie_faq;

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
        return $this->titre_probleme;
    }
}
