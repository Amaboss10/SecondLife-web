<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages_envoyes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $expediteur;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages_recus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $destinataire;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_envoi;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat_message;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $objet_message;

    /**
     * @ORM\Column(type="text")
     */
    private $texte_message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpediteur(): ?User
    {
        return $this->expediteur;
    }

    public function setExpediteur(?User $expediteur): self
    {
        $this->expediteur = $expediteur;

        return $this;
    }

    public function getDestinataire(): ?User
    {
        return $this->destinataire;
    }

    public function setDestinataire(?User $destinataire): self
    {
        $this->destinataire = $destinataire;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->date_envoi;
    }

    public function setDateEnvoi(\DateTimeInterface $date_envoi): self
    {
        $this->date_envoi = $date_envoi;

        return $this;
    }

    public function getEtatMessage(): ?bool
    {
        return $this->etat_message;
    }

    public function setEtatMessage(bool $etat_message): self
    {
        $this->etat_message = $etat_message;

        return $this;
    }

    public function getObjetMessage(): ?string
    {
        return $this->objet_message;
    }

    public function setObjetMessage(?string $objet_message): self
    {
        $this->objet_message = $objet_message;

        return $this;
    }

    public function getTexteMessage(): ?string
    {
        return $this->texte_message;
    }

    public function setTexteMessage(string $texte_message): self
    {
        $this->texte_message = $texte_message;

        return $this;
    }
}
