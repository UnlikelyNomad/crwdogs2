<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Event;

class EventController extends AbstractController
{
    /**
     * @Route("/event", name="event_list")
     */
    public function event_list()
    {
        return $this->render('events/list.html.twig');
    }

    /**
     * @Route("/event/{id}", name="event")
     */
    public function event(Event $event) {
        
    }
}
