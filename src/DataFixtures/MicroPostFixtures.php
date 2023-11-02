<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MicroPostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();
        $users = $manager->getRepository(User::class)->findAll();
        for ($i = 0; $i <= 60; $i++) {
            $microPost = new MicroPost();
            $microPost->setTitle($generator->words(rand(1, 4), true));
            $microPost->setText($generator->realText(200));
            $microPost->setCreated($generator->dateTime());
            $microPost->setAuthor($generator->randomElement($users));
            for ($j = 0; $j <= rand(1,5); $j++) {
                $microPost->addLikedBy($generator->randomElement($users));
            }
            $manager->persist($microPost);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}
