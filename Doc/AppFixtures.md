<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\TvShow;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        $faker = Factory::create('fr_FR');

        // je crée 100 series
        for($i = 0; $i < 100; $i++) {
            $tvShow = new TvShow();
            $tvShow->setTitle($faker->catchPhrase());
            $manager->persist($tvShow);

            // pour chaque serie je créer aleatoirement entre 1 et 20 personnage
            for($j = 0; $j < mt_rand(1,20); $j++)
            {
                $character = new Character();
                $character->setName($faker->name);
                $character->setTvShow($tvShow);
                $manager->persist($character);
            }

        }

       
        $manager->flush();
    }
}
