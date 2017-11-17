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

        return $this->render('DutafBundle:Fournisseur:add.html.twig', array(
            'form' => $formView
        ));
    }
}
