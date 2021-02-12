<?php

namespace App\Entity;

use App\Repository\FAQRepository;

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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description_probleme;

    /**
     * @ORM\Column(type="text")
     */
    private $solution_probleme;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $lien_tutoriel;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_probleme;

    public function __construct()
    {
        $this->date_probleme=new \DateTime();
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

    public function setDescriptionProbleme(?string $description_probleme): self
    {
        $this->description_probleme = $description_probleme;

        return $this;
    }

    public function getSolutionProbleme(): ?string
    {
        return $this->solution_probleme;
    }

    public function setSolutionProbleme(string $solution_probleme): self
    {
        $this->solution_probleme = $solution_probleme;

        return $this;
    }

    public function getLienTutoriel(): ?string
    {
        return $this->lien_tutoriel;
    }

    public function setLienTutoriel(?string $lien_tutoriel): self
    {
        $this->lien_tutoriel = $lien_tutoriel;

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

}
