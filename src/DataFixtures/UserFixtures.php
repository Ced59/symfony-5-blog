<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Bundle\SecurityBundle\Command\UserPasswordEncoderCommand;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;


class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $admin = new User();
        $admin->setEmail('admin@admin.com')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setUsername($faker->firstName())
            ->setPassword(password_hash('adminadmin', PASSWORD_BCRYPT));


        $manager->persist($admin);

        for ($i = 1; $i <= 100; $i++)
        {
            $user = new User();
            $user->setEmail($faker->freeEmail)
                ->setRoles(['ROLE_USER'])
                ->setUsername($faker->firstName())
                ->setPassword(password_hash('useruser', PASSWORD_BCRYPT));


            $manager->persist($user);
        }


        $manager->flush();
    }
}
