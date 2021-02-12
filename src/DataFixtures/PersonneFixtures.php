<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Personne;

class PersonneFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
            /*$personne = new Personne();
            $date = new \DateTime();
            $dateTime= new \DateTime();
            $personne->setNomPersonne("Tom")
                        ->setPrenomPersonne("Tom")
                        ->setMailPersonne("Tom@gmail.com")
                        ->setMdpPersonne("Tom")
                        ->setPseudoUser("Tom")
                        ->setType("user")
                        ->setAdresseUser("87 rue de tom, 87000 Limoges")
                        ->setDateNaissUser($date)
                        ->setDateInscriptionUser($dateTime)
                        ->setIdPhotoUser(0);

        
            $manager->persist($personne);

        $manager->flush();
        */
    }
}
