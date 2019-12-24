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

        $institution->setMinistry('اسم الوزارة');
        $institution->setOffice('اسم الديوان');
        $institution->setDirector('اسم المدير');
        $institution->setEconomist('اسم المقتصد');
        $institution->setAdministrator('اسم منسق المطعم');
        $institution->setName('اسم المؤسسة');
        $institution->setAddress('العنوان');
        $institution->setPhone('00000000');
        $institution->setFax('00000000');
        $institution->setYear('السنة الدراسية');
        $institution->setCity('المدينة');
        $institution->setType('company');

        $manager->persist($institution);
        $manager->flush();

        $manager->flush();




    }
}
