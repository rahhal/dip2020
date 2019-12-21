<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('ar_AR');

        $countries = array("القصرين", "قابس", " سيدي بوزيد", "سوسة", "سليانة", "زغوان", "جندوبة", "توزر", "تطاوين", "بن عروس", "باجة", "أريانة", "بنزرت", "تونس", "صفاقس", "قبلي", "قفصة", "القيروان", "الكاف", "مدنين", "المنستير", "منوبة", "المهدية", "نابل");
        foreach ($countries as $country) {
            $city = new City();
            $city->setName($country);
            $manager->persist($city);
        }

        $manager->flush();

    }
}
