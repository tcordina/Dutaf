<?php

namespace Dutaf\DutafBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->viewArticleAction();
    }

    public function viewArticleAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em
            ->getRepository('DutafBundle:Article')
            ->findAll()
        ;
        return $this->render('DutafBundle:Admin:articles.html.twig', array(
            'articles' => $articles
        ));
    }
}