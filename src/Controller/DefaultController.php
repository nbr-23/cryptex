<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;

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
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article)
    {
       
        return $this->render('default/show.html.twig', [
            'article' => $article
        ]);
    }
}
