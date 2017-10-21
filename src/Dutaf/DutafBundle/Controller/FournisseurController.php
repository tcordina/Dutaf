<?php

namespace Dutaf\DutafBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
