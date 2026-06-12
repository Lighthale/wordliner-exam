<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@wordliner.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword('$2y$13$DcgSbp4ZprC2JKzi.2.ZnutUJxbQsL8EnUdoZOCaiGKuQJ05m5ZxG');
        $manager->persist($user);

        $manager->flush();
    }
}
