<?php

namespace App\DataFixtures;

use App\Entity\Stock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
class StockFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');
        $stock = new Stock();

        $stock->setName('المغازة');
        $stock->setType('magasin');

        $manager->persist($stock);
        $manager->flush();

        $manager->flush();




    }
}
