<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\SousCategorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorieSousCategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker=\Faker\Factory::create('fr_FR');
        for ($i=0; $i < mt_rand(2,5); $i++) { 
            $categorie=new Categorie();
            $categorie->setNomCategorie($faker->word());
            $manager->persist($categorie);

            for ($i=0; $i <mt_rand(0,4); $i++) { 
                $souscategorie=new SousCategorie();
                $souscategorie->setNomSousCategorie($faker->word());
                $categorie->addSousCategorie($souscategorie);
                $manager->persist($souscategorie);
            }
            
        }
        $manager->flush();
    }
}
