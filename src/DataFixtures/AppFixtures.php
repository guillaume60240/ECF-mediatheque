<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends DoctrineFixturesBundle
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}


