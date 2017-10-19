<?php

namespace Dutaf\DutafBundle\Controller;

use Dutaf\DutafBundle\Entity\Article;
use Dutaf\DutafBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleController extends Controller
{
    public function indexAction()
    {
        return $this->render('DutafBundle:Articles:index.html.twig', array(
            //
        ));
    }

    public function viewAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em
            ->getRepository('DutafBundle:Article')
            ->findAll()
        ;

        return $this->render('DutafBundle:Articles:view_article.html.twig', array(
            'articles' => $articles
        ));
    }

    public function addAction(Request $request)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return new Response('Article ajouté avec succès !');
        }

        $formView = $form->createView();

        return $this->render('DutafBundle:Articles:add.html.twig', array(
            'form' => $formView
        ));
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('DutafBundle:Article')->find($id);

        if($article === NULL) {
            throw new NotFoundHttpException("L'article numéro ".$id." n'éxiste pas.");
        }
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('DutafBundle:Article')->find($id);

        if($article === NULL) {
            throw new NotFoundHttpException("L'article numéro ".$id." n'éxiste pas.");
        }

        $em->remove($article);

        $em->flush();

        return $this->redirectToRoute('dutaf_view');
    }
}
