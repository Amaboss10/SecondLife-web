<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur extends Personne 
{
    /**
     * @ORM\Column(type="string", length=20)
     */
    private $pseudo_user;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $adresse_user;

    /**
     * @ORM\Column(type="date")
     */
    private $date_naiss_user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_inscription_user;

    /**
     * @ORM\OneToMany(targetEntity=Conversation::class, mappedBy="expediteur")
     * @ORM\JoinColumn(name="conversations", referencedColumnName="id")
     */
    private $conversations;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="utilisateur")
     * @ORM\JoinColumn(name="annonces", referencedColumnName="id") 
     */
    private $annonces;

    public function __construct(){
        $this->date_inscription_user = new \DateTime('now');
        $this->conversations = new ArrayCollection();
        $this->annonces = new ArrayCollection();
    }

    public function getPseudoUser(): ?string
    {
        return $this->pseudo_user;
    }

    public function setPseudoUser(string $pseudo_user): self
    {
        $this->pseudo_user = $pseudo_user;

        return $this;
    }

    public function getAdresseUser(): ?string
    {
        return $this->adresse_user;
    }

    public function setAdresseUser(string $adresse_user): self
    {
        $this->adresse_user = $adresse_user;

        return $this;
    }

    public function getDateNaissUser(): ?\DateTimeInterface
    {
        return $this->date_naiss_user;
    }

    public function setDateNaissUser(\DateTimeInterface $date_naiss_user): self
    {
        $this->date_naiss_user = $date_naiss_user;

        return $this;
    }

    public function getDateInscriptionUser(): ?\DateTimeInterface
    {
        return $this->date_inscription_user;
    }

    public function setDateInscriptionUser(\DateTimeInterface $date_inscription_user): self
    {
        $this->date_inscription_user = $date_inscription_user;

        return $this;
    }
    /**
     * @return Collection|Conversation[]
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversation $conversation): self
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations[] = $conversation;
            $conversation->setExpediteur($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): self
    {
        if ($this->conversations->removeElement($conversation)) {
            // set the owning side to null (unless already changed)
            if ($conversation->getExpediteur() === $this) {
                $conversation->setExpediteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setUtilisateur($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getUtilisateur() === $this) {
                $annonce->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getRoles(){
        return ['ROLE_USER'];
    }
}
