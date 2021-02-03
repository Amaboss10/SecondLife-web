<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="secondLife_connexion")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('second_life/connexion_inscription.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'titre_page'=>'connexion/inscription',
            'sous_titre_connexion'=>'Dejà membre?',
            'sous_titre_inscription'=>'Pas encore membre?'
        ]);
    }

    /**
     * @Route("/deconnexion", name="secondLife_deconnexion")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
