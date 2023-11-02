<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserProfile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {

    }

    public function load(ObjectManager $manager): void
    {
        $generator = Factory::create();
        for ($i = 0; $i <= 30; $i++) {
            $user = new User();
            $user->setEmail($generator->email);
            $user->setPassword($this->userPasswordHasher->hashPassword($user, '123456'));
            $user->setIsVerified(true);
            $userProfile = new UserProfile();
            $userProfile->setName($generator->name);
            $userProfile->setBio($generator->paragraph(2));
            $userProfile->setWebsiteUrl($generator->url);
            $userProfile->setCompany($generator->company);
            $userProfile->setLocation($generator->country);
            $userProfile->setDateOfBirth($generator->dateTimeBetween('-50 years', '-18 years'));
            $user->setUserProfile($userProfile);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
