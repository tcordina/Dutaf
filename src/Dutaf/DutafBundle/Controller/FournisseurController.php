<?php

namespace Dutaf\DutafBundle\Controller;

use Dutaf\DutafBundle\Entity\Fournisseur;
use Dutaf\DutafBundle\Form\FournisseurType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FournisseurController extends Controller
{
    public function viewAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fournisseurs = $em->getRepository('DutafBundle:Fournisseur')->findAll();

        return $this->render('DutafBundle:Fournisseurs:view.html.twig', array(
            'fournisseurs' => $fournisseurs
        ));
    }

    public function addAction(Request $request)
    {
        $fournisseur = new Fournisseur();

        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fournisseur);
            $em->flush();
            return new Response('Fournisseur ajouté avec succès !');
        }

        $formView = $form->createView();

        return $this->render('DutafBundle:Fournisseurs:add.html.twig', array(
            'form' => $formView
        ));
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fournisseur = $em->getRepository('DutafBundle:Fournisseur')->find($id);

        if($fournisseur === NULL) {
            throw new NotFoundHttpException("Le fournisseur numéro ".$id." n'éxiste pas.");
        }

        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fournisseur);
            $em->flush();
            return new Response('Fournisseur '.$id.' modifié avec succès !');
        }

        $formView = $form->createView();

        return $this->render('DutafBundle:Fournisseurs:edit.html.twig', array(
            'fournisseur' => $fournisseur,
            'form' => $formView

        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $fournisseur = $em->getRepository('DutafBundle:Fournisseur')->find($id);

        if($fournisseur === NULL) {
            throw new NotFoundHttpException("Le fournisseur numéro ".$id." n'éxiste pas.");
        }

        $em->remove($fournisseur);
        $em->flush();

        return $this->redirectToRoute('admin_fournisseur_view');
    }
}
