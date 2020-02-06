<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegisterType;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
    * @Route("/register",name = "register")
    *
    */
    public function register(Request $request, UserPasswordEncoderInterface $encoder){
        $manager = $this -> getDoctrine() -> getManager();
        $user = new User;

        $form = $this -> createForm(RegisterType::class, $user);
        $form -> handleRequest($request);

    if($form -> isSubmitted() && $form -> isValid()){
        $manager -> persist($user);

        //Encodage du password
        $password = $user -> getPassword();
        $user -> setPassword($encoder -> encodePassword($user, $password));

        $manager -> flush();
        $this -> addFlash('success','Le User N°' . $user -> getId() . ' a bien été enregisté');
        return $this -> redirectToRoute('homepage');
    }
    return $this -> render('user/register.html.twig', ['postForm' => $form -> createView()]);
    }

    /**
    * @Route("/login",name = "login")
    *
    */

    public function login(AuthenticationUtils $auth){
        
        $lastUsername = $auth -> getLastUsername();
        // Le username de la personne qui se connecte
        $error = $auth -> getLastAuthenticationError();
        // Erreur d'identification
        if($error){
            $this -> addFlash('errors','Problème d\'identifiant');
        }
        
        return $this -> render('user/login.html.twig',
            array(
                'lastUsername' => $lastUsername,
            ));
    }

    /**
    * @Route("/profil",name = "profil")
    *
    */

    public function profil(){
        return $this -> render('user/profil.html.twig',
            array());
    }
    /**
    * @Route("/logout",name = "logout")
    *
    */
    
    public function logout(){
        return $this -> redirectToRoute('login');
    }

    /**
     * Route nécessaire pour le fonctionnement de la sécurité de connexion
    * @Route("/login_check",name = "login_check")
    *
    */
    
    public function loginCheck(){}
}
