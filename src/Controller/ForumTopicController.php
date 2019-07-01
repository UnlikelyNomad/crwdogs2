<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\ForumTopic;

class ForumTopicController extends AbstractController
{
    /**
     * @Route("/topic/{id}", name="forum_topic")
     */
    public function topic(ForumTopic $topic)
    {
        return $this->render('forum/topic.html.twig', [
            'topic' => $topic,
        ]);
    }
}
