<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\PostType;
use Symfony\Component\HttpFoundation\Request;


class AdminController extends AbstractController
{

    /**
     * @Route("/admin/post", name="admin_post")
     */
    public function adminPost(){
        $repo = $this -> getDoctrine() -> getRepository(Post::class);
        $posts = $repo -> findAll();

        return $this -> render('admin/post_list.html.twig', ['posts' => $posts]);
    }

    /**
     * @Route("/admin/post/add", name="admin_post_add")
     */
    public function adminPostAdd(Request $request){
        $manager = $this -> getDoctrine() -> getManager();
        $post = new Post;

        $form = $this -> createForm(PostType::class, $post);
        $form -> handleRequest($request);

    if($form -> isSubmitted() && $form -> isValid()){
        $manager -> persist($post);
        $post -> setRegisterDate(new \DateTime('now'));
        $post -> setUser('1');
        $post -> uploadFile();

        $manager -> flush();
        $this -> addFlash('success','Le post N°' . $post -> getId() . ' a bien été enregisté');
        return $this -> redirectToRoute('admin_post');
    }

        
        return $this -> render('admin/post_form.html.twig', ['postForm' => $form -> createView()]);
    }

    /**
     * @Route("/admin/post/update/{id}", name="admin_post_update")
     */
    public function adminPostUpdate($id, Request $request){

        //Recupérer le manager
        $manager = $this -> getDoctrine() -> getManager();

        //Recupérer l'objet
        $post = $manager -> find(Post::class, $id);

        $form = $this -> createForm(PostType::class, $post);
        //Notre objet hydrate le formulaire

        $form -> handleRequest($request);
        if($form -> isSubmitted() && $form -> isValid()){
        
            //Modifier
            $manager -> persist($post);

            if($post -> getFile()){
                $post -> removeFile();
                $post -> uploadFile();
            }

            $manager -> flush();

            //Message
            $this -> addFlash('success','Le post N°' . $post -> getId() . ' a bien été modifié'); 
            

            //Vue
            return $this -> redirectToRoute('admin_post');
        }

        return $this -> render('admin/post_form.html.twig', ['postForm' => $form -> createView()]);

    }

    /**
     * @Route("/admin/post/delete/{id}", name="admin_post_delete")
     */
    public function adminPostDelete($id){
        $manager = $this -> getDoctrine() -> getManager();
        $post = $manager -> find(Post::class, $id);
        $manager -> remove($post);
        $manager -> flush();

        $this -> addFlash('success','Le post N°' . $id . ' a bien été supprimé');
        return $this -> redirectToRoute('admin_post');
    }

}
