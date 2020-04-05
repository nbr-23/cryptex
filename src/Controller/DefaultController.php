<?php

namespace App\Controller;


use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ArticleType;

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
     * @ROute("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Article $article = null, Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();

        if (!$article) {
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            if (!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            }
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }

        return $this->render('default/create.html.twig', [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
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
