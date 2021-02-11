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
     * @ORM\ManyToOne(targetEntity=Conversation::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_conversation;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @ORM\JoinColumn(name="utilisateur", referencedColumnName="id_personne")
     */
    private $id_utilisateur;

    /**
     * @ORM\Column(type="text")
     */
    private $texte_message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_message;

    /**
     * @ORM\Column(type="integer")
     */
    private $etat_envoi;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdConversation(): ?Conversation
    {
        return $this->id_conversation;
    }

    public function setIdConversation(?Conversation $id_conversation): self
    {
        $this->id_conversation = $id_conversation;

        return $this;
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

    public function getTexteMessage(): ?string
    {
        return $this->texte_message;
    }

    public function setTexteMessage(string $texte_message): self
    {
        $this->texte_message = $texte_message;

        return $this;
    }

    public function getDateMessage(): ?\DateTimeInterface
    {
        return $this->date_message;
    }

    public function setDateMessage(\DateTimeInterface $date_message): self
    {
        $this->date_message = $date_message;

        return $this;
    }

    public function getEtatEnvoi(): ?int
    {
        return $this->etat_envoi;
    }

    public function setEtatEnvoi(int $etat_envoi): self
    {
        $this->etat_envoi = $etat_envoi;

        return $this;
    }
}
