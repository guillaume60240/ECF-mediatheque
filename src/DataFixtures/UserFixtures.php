<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setName('user'.$i);
            $user->setFirstname('firstname'.$i);
            $user->setEmail('test'.$i.'@test.fr');
            if($i === 9) {
                $user->setPassword('$2y$10$uEZ.OJ18aOvWF9qeG2yAh.zSW0M9uH3jaGkz1vODJP9jWxbXzQlli');
                $user->setRoles(['ROLE_USER', 'ROLE_MEMBER']);
            } else {
                $user->setPassword('test');
                $user->setRoles(['ROLE_USER']);
            }
            $user->setAddress('adress'.$i);
            $user->setMailValidate(false);
            $user->setAccountValidate(false);
            $user->setLocation(0);
            $user->setBirthday(new \DateTimeImmutable());
            $user->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}