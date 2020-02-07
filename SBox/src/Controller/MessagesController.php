<?php

namespace App\Controller;

use App\Entity\Groups;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MessagesController extends AbstractController
{
    /**
     * @Route("/messages", name="messages")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Groups::class);
        $groups = $repository->findAll();
        return $this->render('messages/index.html.twig', [
            'groups' => $groups,
        ]);
    }

    /**
     * @Route("/conversation/{id}", name="conversation")
     */

    public function conversation($id)
    {
        //1 : Récupérer les infos du post
        $groupe = $this->getDoctrine()->getRepository(Groups::class)->find($id);
    

        //2 : Afficher la vue avec les infos

        return $this->render('messages/conversation.html.twig', array('groupe' => $groupe));
    }
}
