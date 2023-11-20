<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\MicroPostRepository;
use App\Service\PaginatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_profile')]
    public function index(User $user, MicroPostRepository $posts, PaginatorService $paginatorService, Request $request): Response
    {
        return $this->render('profile/show.html.twig', [
            'user' => $user,
            'posts' => $paginatorService->paginate($posts->findAllByAuthor($user), $request)
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
