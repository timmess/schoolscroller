<?php

namespace App\DataFixtures;

use App\Entity\Formation;
use App\Entity\Modules;
use App\Entity\School;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $schools = [];
        $formations = [];
        $modules = [];

        for ($nbSchool = 1; $nbSchool <= 5; $nbSchool++){
            $school = new School();
            $school->setAdress($faker->address);
            $school->setCity($faker->city);
            $school->setName($faker->word);
            $school->setPhoto($faker->imageUrl());
            $manager->persist($school);
            $schools[] = $school;
        }

        for($nbFormation = 1; $nbFormation <= 10; $nbFormation++){
            $i = rand(1, 10);

            $formation = new Formation();
            for ($a = $i; $a <= 10; $a++){
                $school = $schools[mt_rand(0, count($schools) - 1)];
                $formation->addSchool($school);
            }
            $formation->setName($faker->word);
            $manager->persist($formation);
            $formations[] = $formation;
        }

        for ($nbModule = 1; $nbModule <= 100; $nbModule++){
            $i = rand(1, 100);

            $module = new Modules();

            for ($a = $i; $a <= 100; $a++){
                $formation = $formations[mt_rand(0, count($formations) - 1)];
                $module->addFormation($formation);
            }

            $module->setName($faker->word);
            $module->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>');
            $module->setDuration(rand(8, 30));
            $manager->persist($module);
            $modules[] = $module;
        }

        $manager->flush();
    }
}
