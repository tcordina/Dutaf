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
        return $this->render('DutafBundle:Articles:index.html.twig');
    }

    public function viewAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em
            ->getRepository('DutafBundle:Article')
            ->findAll()
        ;

        return $this->render('DutafBundle:Articles:view.html.twig', array(
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

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return new Response('Article'.$id.'modifié avec succès !');
        }

        $formView = $form->createView();

        return $this->render('DutafBundle:Articles:add.html.twig', array(
            'article' => $article,
            'form' => $formView

        ));
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

        return $this->redirectToRoute('admin_index');
    }

    public function budgetAction($prix)
    {
        $article = $this->getDoctrine()->getManager()->getRepository('DutafBundle:Article');

        $qb = $article->createQueryBuilder('a');
        $qb ->select('a')
            ->innerJoin('DutafBundle:Fournisseur', 'f', 'WITH', 'f.id = a.fournisseur')
            ->where('a.prix <= ?1')
            ->orderBy('a.prix', 'DESC')
            ->setParameter(1, $prix)
        ;

        $query = $qb->getQuery();
        $result = $query->getResult();

        return $this->render('DutafBundle:Articles:budget.html.twig', array(
            'articles' => $result
        ));
    }
}
