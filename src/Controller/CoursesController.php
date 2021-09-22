<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursesController extends AbstractController
{
    /**
     * @Route("/", name="courses")
     */
    public function recupererListeCourses(ArticleRepository $rep, Request $request): Response
    {
        $article = new Article();
        // associe obj personne au Form.
        $formArticle = $this->createForm(ArticleType::class,$article);
        $list_courses = $rep->findAll();
        return $this->render('courses/index.html.twig', [
            'list_courses' => $list_courses,
            'formArticle'=> $formArticle->createView()
        ],
    );
    }

    /**
     * @Route("/delete_article/{id}", name="delete_article")
     */
    public function enlever(Article $article, EntityManagerInterface $em): Response
    {
       // $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('courses');
    }


    
    /**
     * @Route("/update_article/{id}", name="update_article")
     */
    public function rendreAchete(Article $article, EntityManagerInterface $em): Response
    {
       // $em = $this->getDoctrine()->getManager();
        $article->setEstAchete(true);
        
        $em->flush();
        return $this->redirectToRoute('courses');
    }

    /**
     * @Route("/add_article", name="add_article")
     */
    public function ajouterArticle(Request $req): Response
    {
        $article = new Article();
        // associe obj personne au Form.
        $formArticle = $this->createForm(ArticleType::class,$article);
        // hydraté $personne en fct du formulaire
        $formArticle->handleRequest($req);
        // si le form est validé.
       
            $em = $this->getDoctrine()->getManager();
            $article->setEstAchete(false);
            $em->persist($article);
            
            $em->flush();
            // je redirig\
            return $this->redirectToRoute('courses');
        
       

    }


      
   
}
