<?php

namespace App\Controller;


use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(ArticleRepository $repo)
    {

        $articles = $repo->findAll();
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'articles' => $articles
        ]);
    }
    
    /**
     * @Route("/home", name="home")
     */
    public function home()
    {
        return $this->render('default/home.html.twig');
    }

    /**
     * @Route("/blog/new", name="blog_create")
     */
    public function create(Request $request){

       $article = new Article();
       
       $form = $this->createFormBuilder($article)
                    ->add('title')
                    ->add('content')
                    ->add('image')
                    ->getForm();

        return $this->render('default/create.html.twig', [
            'formArticle' => $form->createView()
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article)
    {
       
        return $this->render('default/show.html.twig', [
            'article' => $article
        ]);
    }
    
    
}
