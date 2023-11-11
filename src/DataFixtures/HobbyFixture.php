<?php

namespace App\DataFixtures;

use App\Entity\Hobby;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HobbyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $Hobbys = [
            "danse","lecture",
            "saut","gimnastique",
            "voyage" ,"vacance ","piscine","lancer de javelo",
            "saut en longueur"];
            for ($i=0; $i<count($Hobbys) ; $i++) {
                $Hobby = new Hobby();
                $Hobby->setDesignation($Hobbys[$i]);
                $manager->persist($Hobby);
            }

        $manager->flush();
    }
}
