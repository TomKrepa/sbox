<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Form\RegisterType;

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="sign_in")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/register", name="sign_up")
     */
    public function register(Request $request)
    {
        $manager = $this -> getDoctrine() -> getManager();

        $user = new User();

        $form = $this -> createForm(RegisterType::class, $user);

        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()) {
            $manager -> persist($user);
            $manager -> flush();
            
            $this -> addFlash('success Le User a bien été enregisté');
            return $this -> redirectToRoute('sign_in');
        }

        return $this -> render('admin/register.html.twig', [
            'form' => $form -> createView()
        ]);
    }
}
