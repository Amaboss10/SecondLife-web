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
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="faqs")
     * @ORM\JoinColumn(name="utilisateur", referencedColumnName="id_personne")
     */
    private $id_utilisateur;

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
     * @ORM\Column(type="boolean")
     */
    private $est_resolue;

    public function __construct()
    {
        $this->reponseFaqs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEstResolue(): ?bool
    {
        return $this->est_resolue;
    }

    public function setEstResolue(bool $est_resolue): self
    {
        $this->est_resolue = $est_resolue;

        return $this;
    }
    
}
