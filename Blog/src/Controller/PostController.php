<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;

class PostController extends AbstractController
{
    /**
    * @Route("/",name = "homepage")
    *
    */
    public function index(){
        $repository = $this -> getDoctrine() -> getRepository(Post::class);
        $posts = $repository -> findAll();

        $categories = $repository -> findAllCategories();

      

        return $this -> render('post/index.html.twig', array(
            'posts' => $posts,
            'categories' => $categories
        ));
    }
    /**
    * @Route("/show/{id}",name = "show")
    *
    */
    public function show($id){
        $repo = $this -> getDoctrine() -> getRepository(Post::class);
        $post = $repo -> find($id);
        
        return $this -> render('post/show.html.twig',
            array('post' => $post));
    }
    
   /**
    * @Route("/category/{cat}",name ="category")
    *
    */
    public function category($cat){
        $repository = $this -> getDoctrine() -> getRepository(Post::class);
        $posts = $repository -> findAll();

        $categories = $repository -> findAllCategories();
        $posts = $repository -> findBy(['category' => $cat]);

        return $this -> render('post/index.html.twig',
        array('posts' => $posts, 'categories' => $categories));
    }
}
