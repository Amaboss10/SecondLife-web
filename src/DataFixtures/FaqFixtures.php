<?php

namespace App\DataFixtures;

use App\Entity\FAQ;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FaqFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker=\Faker\Factory::create('fr_FR');
        //on cree 5 rubriques FAQ
        for($i=0;$i<5;$i++){
            $faq=new FAQ();
            $faq->setTitreProbleme($faker->sentence(mt_rand(5,10),true))//phrases de 5 à 10 mots
                ->setDescriptionProbleme($faker->text(mt_rand(10,200)))//texte de 10 à 200 caracteres
                ->setSolutionProbleme($faker->text(mt_rand(10,200)))
                ->setDateProbleme($faker->dateTime('now',null))
                ->setLienTutoriel('video');
            $manager->persist($faq);
        }

        $manager->flush();
    }
}
