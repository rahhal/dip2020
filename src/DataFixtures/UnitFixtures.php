<?php

namespace App\DataFixtures;

use App\Entity\Unit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
class UnitFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('ar_AR');

        $unitts = array("كغ", "ل", "1/2 ل", "قارورة", "علبة");
        foreach ($unitts as $unitt) {
            $unit = new Unit();
            $unit->setName($unitt);
            $manager->persist($unit);
        }
        $manager->flush();

    }
}
