<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use App\Repository\ConversationRepository;

/**
 * @ORM\Entity(repositoryClass=ConversationRepository::class)
 */
class Conversation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="conversations")
     * @ORM\JoinColumn(name="expediteur", referencedColumnName="id_personne")
    */
    private $expediteur;

    /**
     * @ORM\ManyToOne(targetEntity=utilisateur::class, inversedBy="conversations")
     * @ORM\JoinColumn(name="destinataire", referencedColumnName="id_personne")
     */
    private $destinataire;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="id_conversation")
     *  @ORM\JoinColumn(name="messages", referencedColumnName="id")
     */
    private $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpediteur(): ?Utilisateur
    {
        return $this->expediteur;
    }

    public function setExpediteur(?Utilisateur $expediteur): self
    {
        $this->expediteur = $expediteur;

        return $this;
    }

    public function getDestinataire(): ?utilisateur
    {
        return $this->destinataire;
    }

    public function setDestinataire(?utilisateur $destinataire): self
    {
        $this->destinataire = $destinataire;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setIdConversation($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getIdConversation() === $this) {
                $message->setIdConversation(null);
            }
        }

        return $this;
    }

}
