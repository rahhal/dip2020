<?php

namespace App\DataFixtures;

use App\Entity\Institution;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
class InstitutionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');
        $institution = new Institution();

        $institution->setMinistry('ministry');
        $institution->setOffice('office');
        $institution->setDirector('director');
        $institution->setEconomist('economist');
        $institution->setAdministrator('administrator');
        $institution->setName('company');
        $institution->setAddress('address');
        $institution->setPhone('71000100');
        $institution->setFax('71000100');
        $institution->setYear('2019');
        $institution->setCity('city');
        $institution->setType('company');

        $manager->persist($institution);
        $manager->flush();

        $manager->flush();




    }
}
