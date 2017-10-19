<?php

namespace Dutaf\DutafBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DutafBundle:Default:index.html.twig');
    }
}
