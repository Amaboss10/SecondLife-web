<?php

namespace App\Entity;

use App\Repository\ReponseFaqRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReponseFaqRepository::class)
 */
class ReponseFaq
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=faq::class, inversedBy="reponseFaqs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_faq;

    /**
     * @ORM\Column(type="text")
     */
    private $texte_reponse;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_reponse;

    /**
     * @ORM\OneToOne(targetEntity=Personne::class, inversedBy="reponseFaq", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="utilisateur", referencedColumnName="id_personne")
     */
    private $id_personne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdFaq(): ?faq
    {
        return $this->id_faq;
    }

    public function setIdFaq(?faq $id_faq): self
    {
        $this->id_faq = $id_faq;

        return $this;
    }

    public function getTexteReponse(): ?string
    {
        return $this->texte_reponse;
    }

    public function setTexteReponse(string $texte_reponse): self
    {
        $this->texte_reponse = $texte_reponse;

        return $this;
    }

    public function getDateReponse(): ?\DateTimeInterface
    {
        return $this->date_reponse;
    }

    public function setDateReponse(\DateTimeInterface $date_reponse): self
    {
        $this->date_reponse = $date_reponse;

        return $this;
    }

    public function getIdPersonne(): ?Personne
    {
        return $this->id_personne;
    }

    public function setIdPersonne(Personne $id_personne): self
    {
        $this->id_personne = $id_personne;

        return $this;
    }
}
