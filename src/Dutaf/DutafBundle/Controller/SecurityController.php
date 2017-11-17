<?php

namespace Dutaf\DutafBundle\Controller;

use Dutaf\DutafBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    public function loginAction()
    {

        /*$user = new User();
        $em = $this->getDoctrine()->getManager();
        $encoder = $this->get('security.password_encoder');
        $user->setUsername('admin');
        $user->setPassword($encoder->encodePassword($user, 'admin'));
        $em->persist($user);
        $em->flush();*/

        $utils = $this->get('security.authentication_utils');
        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();

        return $this->render('DutafBundle:Security:login.html.twig', array(
            'username' => $lastUsername,
            'error' => $error
        ));
    }
}