<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserProfile;
use DateTime;
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

        $admin = new User();
        $admin->setEmail('admin@micropost.com');
        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, '123456'));
        $admin->setIsVerified(true);
        $adminProfile = new UserProfile();
        $adminProfile->setName('John Doe');
        $adminProfile->setBio('Cool as cucumber');
        $adminProfile->setTwitterUsername('twitter');
        $adminProfile->setWebsiteUrl('http://127.0.0.1/');
        $adminProfile->setCompany('IT Company');
        $adminProfile->setLocation('Ukraine');
        $adminProfile->setDateOfBirth(new DateTime('1995-04-24'));
        $adminProfile->setImage('photo-2023-10-23-11-35-35-65426bf6af06d.jpg');
        $admin->setUserProfile($adminProfile);
        $manager->persist($admin);

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
