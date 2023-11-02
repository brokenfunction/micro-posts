<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();
        $users = $manager->getRepository(User::class)->findAll();
        $posts = $manager->getRepository(MicroPost::class)->findAll();
        for ($i = 0; $i <= 200; $i++) {
            $comment = new Comment();
            $comment->setText($generator->realText(100));
            $comment->setCreated($generator->dateTime());
            $comment->setAuthor($generator->randomElement($users));
            $comment->setPost($generator->randomElement($posts));
            $manager->persist($comment);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            MicroPostFixtures::class
        ];
    }
}
