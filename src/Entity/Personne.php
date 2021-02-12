<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PersonneRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=PersonneRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @DiscriminatorColumn(name="type", type="string")
 * @DiscriminatorMap({"personne" = "Personne","administrateur" ="Administrateur", "utilisateur" = "Utilisateur", "administrateur" ="Administrateur"})
 */
class Personne implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id_personne;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $nom_personne;

    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $prenom_personne;

    // , unique=true ---> à utiliser pour le mail mais bug quand on met 2 fois le meme email
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $mail_personne;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire au minimum 8 caractères")
     */
    protected $mdp_personne;

    /**
     * @Assert\EqualTo(propertyPath="mdp_personne",message="Vous n'avez pas saisi le même mot de passe.")
     */
    protected $verif_mdp_personne;

    /**
     * @ORM\Column(type="string", length=250)
     */
    protected $lien_image_personne;

    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPersonne(): ?string
    {
        return $this->nom_personne;
    }

    public function setNomPersonne(string $nom_personne): self
    {
        $this->nom_personne = $nom_personne;

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

    public function getMailPersonne(): ?string
    {
        return $this->mail_personne;
    }

    public function setMailPersonne(string $mail_personne): self
    {
        $this->mail_personne = $mail_personne;

        return $this;
    }

    public function getMdpPersonne(): ?string
    {
        return $this->mdp_personne;
    }

    public function setMdpPersonne(string $mdp_personne): self
    {
        $this->mdp_personne = $mdp_personne;

        return $this;
    }

    public function getVerifMdpPersonne(): ?string
    {
        return $this->verif_mdp_personne;
    }

    public function setVerifMdpPersonne(string $verif_mdp_personne): self
    {
        $this->verif_mdp_personne = $verif_mdp_personne;

        return $this;
    }

    public function getLienImagePersonne(): ?string
    {
        return $this->lien_image_personne;
    }

    public function setLienImagePersonne(string $lien_image_personne): self
    {
        $this->lien_image_personne = $lien_image_personne;

        return $this;
    }
    public function getPassword(){
        return $this->mdp_personne;
    }

    public function getUsername(){
        return $this->mail_personne;
    }
    public function eraseCredentials(){}

    public function getSalt() {}

    public function getRoles(){
        return ['ROLE_USER'];
    }

    public function getType(): ?string{
        return $this->type;
    }

    public function setType(string $type): self{
        $this->type = $type;

        return $this;
    }
}
