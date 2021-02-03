<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email_personne"}, message="There is already an account with this email_personne")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $nom_personne;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $prenom_personne;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Email()
     */
    protected $email_personne;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $password;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    protected $date_inscription_personne;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="expediteur", orphanRemoval=true)
     */
    private $messages_envoyes;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="destinataire", orphanRemoval=true)
     */
    private $messages_recus;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $pseudo_user;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $adresse_user;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    private $date_naissance_user;

    /**
     * @ORM\OneToOne(targetEntity=PhotoUser::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $photoUser;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="utilisateur", orphanRemoval=true)
     */
    private $annonces;

    /**
     * @ORM\OneToOne(targetEntity=Favoris::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $favoris;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $jeton;

    /**
     * @ORM\Column(type="boolean")
     */
    private $verification;


    public function __construct()
    {
        $this->roles=['ROLE_USER'];
        $this->date_inscription_personne=new \DateTime();
        $this->verification=false;
        $this->annonces = new ArrayCollection();
        $this->messages_envoyes = new ArrayCollection();
        $this->messages_recus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateNaissanceUser(): ?\DateTimeInterface
    {
        return $this->date_naissance_user;
    }

    public function setDateNaissanceUser(\DateTimeInterface $date_naissance_user): self
    {
        $this->date_naissance_user = $date_naissance_user;

        return $this;
    }

    public function getPhotoUser(): ?PhotoUser
    {
        return $this->photoUser;
    }

    public function setPhotoUser(PhotoUser $photoUser): self
    {
        // set the owning side of the relation if necessary
        if ($photoUser->getUser() !== $this) {
            $photoUser->setUser($this);
        }

        $this->photoUser = $photoUser;

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
            $annonce->setUser($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getUser() === $this) {
                $annonce->setUser(null);
            }
        }

        return $this;
    }

    public function getFavoris(): ?Favoris
    {
        return $this->favoris;
    }

    public function setFavoris(Favoris $favoris): self
    {
        // set the owning side of the relation if necessary
        if ($favoris->getUser() !== $this) {
            $favoris->setUser($this);
        }

        $this->favoris = $favoris;

        return $this;
    }
    public function getNomPersonne(): ?string
    {
        return $this->nom_personne;
    }

    public function setNomPersonne(string $nom_personne): self
    {
        $this->nom = $nom_personne;

        return $this;
    }

    public function getPrenomPersonne(): ?string
    {
        return $this->prenom_personne;
    }

    public function setPrenomPersonne(string $prenom_personne): self
    {
        $this->prenom_personne = $prenom_personne;

        return $this;
    }

    public function getEmailPersonne(): ?string
    {
        return $this->email_personne;
    }

    public function setEmailPersonne(string $email_personne): self
    {
        $this->email_personne = $email_personne;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $mdp): self
    {
        $this->mdp_persoone = $mdp;

        return $this;
    }

    public function getDateInscriptionPersonne(): ?\DateTimeInterface
    {
        return $this->date_inscription_personne;
    }

    public function setDateInscriptionPersonne(\DateTimeInterface $date_inscription_personne): self
    {
        $this->date_inscription_personne = $date_inscription_personne;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessagesEnvoyes(): Collection
    {
        return $this->messages_envoyes;
    }

    public function addMessagesEnvoye(Message $messagesEnvoye): self
    {
        if (!$this->messages_envoyes->contains($messagesEnvoye)) {
            $this->messages_envoyes[] = $messagesEnvoye;
            $messagesEnvoye->setExpediteur($this);
        }

        return $this;
    }

    public function removeMessagesEnvoye(Message $messagesEnvoye): self
    {
        if ($this->messages_envoyes->removeElement($messagesEnvoye)) {
            // set the owning side to null (unless already changed)
            if ($messagesEnvoye->getExpediteur() === $this) {
                $messagesEnvoye->setExpediteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessagesRecus(): Collection
    {
        return $this->messages_recus;
    }

    public function addMessagesRecu(Message $messagesRecu): self
    {
        if (!$this->messages_recus->contains($messagesRecu)) {
            $this->messages_recus[] = $messagesRecu;
            $messagesRecu->setDestinataire($this);
        }

        return $this;
    }

    public function removeMessagesRecu(Message $messagesRecu): self
    {
        if ($this->messages_recus->removeElement($messagesRecu)) {
            // set the owning side to null (unless already changed)
            if ($messagesRecu->getDestinataire() === $this) {
                $messagesRecu->setDestinataire(null);
            }
        }

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    public function getSalt()
    {
    }
    public function eraseCredentials()
    {
    }
    public function getUsername()
    {
        return $this->email_personne;
    }

    public function getJeton(): ?string
    {
        return $this->jeton;
    }

    public function setJeton(?string $jeton): self
    {
        $this->ijeton = $jeton;

        return $this;
    }

    public function getVerification(): ?bool
    {
        return $this->verification;
    }

    public function setVerification(bool $verification): self
    {
        $this->verification = $verification;

        return $this;
    }
}
