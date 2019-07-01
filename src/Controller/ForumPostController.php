<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ForumPostController extends AbstractController
{
    /**
     * @Route("/forum/post", name="forum_post")
     */
    public function index()
    {
        return $this->render('forum_post/index.html.twig', [
            'controller_name' => 'ForumPostController',
        ]);
    }
}
