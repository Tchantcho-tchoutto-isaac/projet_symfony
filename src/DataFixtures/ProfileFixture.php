<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Profile;

class ProfileFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $profile=new profile();
        $profile-> setRs(rs:'Facebook');
        $profile-> setUrl(url:'https://www.facebook.com/isaac.tchantcho/');

        $profile2=new profile();
        $profile2-> setRs(rs:'Linkedin');
        $profile2-> setUrl(url:'https://www.linkedin.com/in/isaac-tchantcho-tchoutto/');

        $profile1=new profile();
        $profile1-> setRs(rs:'Github');
        $profile1-> setUrl(url:'https://github.com/Tchantcho-tchoutto-isaac/projet_symfony');

         $manager->persist($profile);
         $manager->persist($profile1);
         $manager->persist($profile2);

        $manager->flush();
    }
}
