<?php

namespace App\DataFixtures;

use App\Entity\Marque;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MarqueFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker=\Faker\Factory::create('fr_FR');
        for ($i=0; $i < 9; $i++) { 
            $marque=new Marque();
            $marque->setNomMarque($faker->word);
            $manager->persist($marque);
        }
        
        $manager->flush();
    }
}
