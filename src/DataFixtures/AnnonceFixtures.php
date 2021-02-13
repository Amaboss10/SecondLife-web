<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Repository\CategorieRepository;
use App\Repository\MarqueRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AnnonceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /*$faker=\Faker\Factory::create('fr_FR');
        for ($i=0; $i < mt_rand(2,10); $i++) { 
            $marque=$manager->getRepository('App:Marque')->findMarqueAleat(); 
            $categorie=$manager->getRepository('App:Categorie')->findCategorieAleat(); 
            $souscategorie=$manager->getRepository('App:SousCategorie')->findSousCategorieAleat(); 
            $modes=array('remise_en_main_propre','remise_via_transporteur');

            $annonce=new Annonce();
            $annonce->setTitreAnnonce($faker->sentence(mt_rand(5,10),true))
                    ->setCategorie($categorie)
                    ->setSousCategorie($souscategorie)
                    ->setMarque($marque)
                    ->setDescriptionAnnonce($faker->text(mt_rand(10,100)))
                    ->setPrixAnnonce($faker->randomNumber(4,false))
                    ->setPoidsAnnonce($faker->randomNumber(4,false))
                    ->setLieu($faker->word())
                    ->setDatePubliAnnonce($faker->dateTimeBetween('-10 years','now',null))
                    ->setModeLivraison($modes);

            $manager->persist($annonce);
        }
        $manager->flush();*/
    }
}
