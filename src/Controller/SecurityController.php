<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\Utilisateur;
use App\Form\SeConnecterType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    // /**
    //  * @Route("/cconnexion", name="secondLife_connexion")
    //  */
    // public function login(AuthenticationUtils $authenticationUtils): Response
    // {
        
    //     // if ($this->getUser()) {
    //     //     return $this->redirectToRoute('target_path');
    //     // }

    //     // get the login error if there is one
    //     $error = $authenticationUtils->getLastAuthenticationError();
    //     // last username entered by the user
    //     $lastUsername = $authenticationUtils->getLastUsername();

    //     return $this->render('second_life/connexion_inscription.html.twig', [
    //         'last_username' => $lastUsername,
    //         'error' => $error,
    //         'titre_page'=>'connexion/inscription',
    //         'sous_titre_connexion'=>'Dejà membre?',
    //         'sous_titre_inscription'=>'Pas encore membre?'
    //     ]);
    // }

    // /**
    //  * @Route("/deconnexion", name="secondLife_deconnexion")
    //  */
    // public function logout()
    // {
    //     throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    // }
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(AuthenticationUtils $authenticationUtils, Request $requete, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response{
        $user = new Utilisateur();

        $formInscription = $this->createForm(RegistrationType::class, $user);
        // $formConnexion = $this->createForm(SeConnecterType::class, $user);
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $formInscription->handleRequest($requete);
        // $formConnexion->handleRequest($requete);

        if($formInscription->isSubmitted() && $formInscription->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setMdpPersonne($hash);
            if($user->getLienImagePersonne()== null){
                $user->setLienImagePersonne("logo_site.png");
            }
            
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('secondlife_connexion');
        }


        return $this->render('security/registration.html.twig', [
            'formInscription' =>  $formInscription->createView(),
                'last_username' => $lastUsername,
                'error' => $error,
                'titre_page'=>'connexion/inscription',
                'sous_titre_connexion'=>'Dejà membre?',
                'sous_titre_inscription'=>'Pas encore membre?',
            // 'formConnexion' => $formConnexion->createView(),
        ]);
    }

    /**
     * @Route("/connexion", name="secondlife_connexion")
     */
    public function connexion(){
        return $this->render('security/login.html.twig');
    }

    

    /**
     * @Route("/login", name="app_login")
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

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
