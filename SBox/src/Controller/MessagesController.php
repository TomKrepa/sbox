<?php

namespace App\Controller;

use App\Entity\Group;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MessagesController extends AbstractController
{
    /**
     * @Route("/messages", name="messages")
     */
    public function index()
    {
       /* $repository = $this->getDoctrine()->getRepository(Group::class);
        $manager=$this ->getDoctrine()->getManager();
        $groups = $repository->findAll();*/
        return $this->render('messages/index.html.twig', [
            /*'groups' => $groups,*/
        ]);
    }
}
