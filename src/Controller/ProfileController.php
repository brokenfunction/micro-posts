<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_profile')]
    public function index(User $user): Response
    {
        return $this->render('profile/show.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/profile/follows/{id}', name: 'app_profile_follows')]
    public function follows(User $user): Response
    {
        return $this->render('profile/follows.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/profile/followers/{id}', name: 'app_profile_followers')]
    public function followers(User $user): Response
    {
        return $this->render('profile/followers.html.twig', [
            'user' => $user
        ]);
    }
}
