<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Entity\User;
use App\Form\CommentType;
use App\Form\MicroPostType;
use App\Repository\CommentRepository;
use App\Repository\MicroPostRepository;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts): Response
    {
        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts->findAllWithComments()
        ]);
    }

    #[Route('/micro-post/top-liked', name: 'app_micro_post_topliked')]
    public function topLiked(MicroPostRepository $posts): Response
    {
        return $this->render('micro_post/top_liked.html.twig', [
            'posts' => $posts->findAllWithMinLikes(5)
        ]);
    }

    #[Route('/micro-post/follows', name: 'app_micro_post_follows')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function follows(MicroPostRepository $posts): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        return $this->render('micro_post/follows.html.twig', [
            'posts' => $posts->findAllByAuthors($currentUser->getFollows())
        ]);
    }

    #[Route('/micro-post/{post}', name: 'app_micro_post_show')]
    #[IsGranted(MicroPost::VIEW, 'post')]
    public function showOne(MicroPost $post, Request $request, CommentRepository $comments): Response
    {
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setPost($post);
            $comment->setAuthor($this->getUser());
            $comments->add($comment, true);

            $this->addFlash('success', 'Your comment have been added');
            return $this->redirectToRoute('app_micro_post_show', ['post' => $post->getId()]);
        }
        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }

    #[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)]
    #[IsGranted('ROLE_VERIFIED')]
    public function add(Request $request, MicroPostRepository $posts): Response
    {
        $form = $this->createForm(MicroPostType::class, new MicroPost());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setAuthor($this->getUser());
            $posts->add($post, true);

            $this->addFlash('success', 'Your micro post have been added');
            return $this->redirectToRoute('app_micro_post');
        }

        return $this->renderForm('micro_post/add.html.twig',
        [
            'form' => $form
        ]);
    }


    #[Route('/micro-post/remove/{post}', name: 'app_micro_post_remove')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function remove(MicroPost $post, MicroPostRepository $posts): Response
    {
        if ($post->getAuthor() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $posts->remove($post ,true);
        $this->addFlash('success', 'Your post have been removed');
        return $this->redirectToRoute('app_micro_post');
    }

    #[Route('/micro-post/edit/{post}', name: 'app_micro_post_edit')]
    #[IsGranted(MicroPost::EDIT, 'post')]
    public function edit(MicroPost $post, Request $request, MicroPostRepository $posts): Response
    {
        $form = $this->createForm(MicroPostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setEdited(new DateTime());
            $posts->add($post, true);

            $this->addFlash('success', 'Your micro post have been updated');
            return $this->redirectToRoute('app_micro_post_show', ['post' => $post->getId()]);
        }

        return $this->renderForm('micro_post/edit.html.twig',
            [
                'form' => $form,
                'post' => $post
            ]);
    }

    #[Route('/micro-post/comment/{post}', name: 'app_micro_post_comment')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function addComment(MicroPost $post, Request $request, CommentRepository $comments): Response
    {
        $form = $this->createForm(CommentType::class, new Comment());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setPost($post);
            $comment->setAuthor($this->getUser());
            $comments->add($comment, true);

            $this->addFlash('success', 'Your comment have been updated');
            return $this->redirectToRoute('app_micro_post_show', ['post' => $post->getId()]);
        }

        return $this->renderForm('micro_post/comment.html.twig',
            [
                'form' => $form,
                'post' => $post
            ]);
    }

    #[Route('/micro-post/edit/comment/{comment}', name: 'app_micro_post_edit_comment')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function editComment(Comment $comment, Request $request, CommentRepository $comments): Response
    {
        if ($comment->getAuthor() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $post = $comment->getPost();

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setEdited(new DateTime());
            $comments->add($comment, true);


            $this->addFlash('success', 'Your comment have been updated');
            return $this->redirectToRoute('app_micro_post_show', ['post' => $post->getId()]);
        }

        return $this->renderForm('micro_post/edit_comment.html.twig',
            [
                'form' => $form,
                'comment' => $comment,
                'post' => $post
            ]);
    }

    #[Route('/micro-post/remove/comment/{comment}', name: 'app_micro_post_remove_comment')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function deleteComment(Comment $comment, CommentRepository $comments): Response
    {
        if ($comment->getAuthor() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $post = $comment->getPost();
        $comments->remove($comment ,true);
        $this->addFlash('success', 'Your comment have been removed');
        return $this->redirectToRoute('app_micro_post_show', ['post' => $post->getId()]);
    }
}
