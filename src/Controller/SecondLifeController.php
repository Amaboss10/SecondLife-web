<?php

namespace App\Controller;


use App\Repository\FAQRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecondLifeController extends AbstractController
{
    /**
     * @Route("/", name="secondLife_accueil")
     */
    public function index(): Response
    {
        return $this->render('second_life/index.html.twig', [
            'titre_page'=>'Accueil'
        ]);
    }

    /**
     * @Route("/creerAnnonce", name="secondLife_creer_annonce")
     */
    public function creer_annonce(): Response
    {
        return $this->render('second_life/creer_annonce.html.twig', [
            'titre_page'=>'Creer une annonce'
        ]);
    }

    /**
     * @Route("/favoris", name="secondLife_favoris")
     */
    public function favoris(): Response
    {
        return $this->render('second_life/favoris.html.twig', [
            'titre_page'=>'Mes favoris'
        ]);
    }

    /**
     * @Route("/messagerie", name="secondLife_messagerie")
     */
    public function messagerie(): Response
    {
        return $this->render('second_life/messagerie.html.twig', [
            'titre_page'=>'Messagerie'
        ]);
    }
    
    /**
     * @Route("/monCompte", name="secondLife_mon_compte")
     */
    public function mon_compte(): Response
    {
        return $this->render('second_life/mon_compte.html.twig', [
            'titre_page'=>'Mon compte'
        ]);
    }

    /**
     * @Route("/faq", name="secondLife_faq")
     */
    public function faq(FAQRepository $repository): Response
    {
        $rubriques=$repository->findAll();
        return $this->render('second_life/faq.html.twig', [
            'titre_page'=>'FAQ/Aide',
            'rubriques' => $rubriques
        ]);
    }

    /**
     * @Route("/deconnexion", name="secondLife_deconnexion")
     */
    public function deconnexion(): Response
    {
        return $this->render('second_life/index.html.twig', [
            'titre_page'=>'Accueil'
        ]);
    }

    /**
     * @Route("/quiSommesNous", name="secondLife_qui_sommes_nous")
     */
    public function qui_sommes_nous(): Response
    {
        return $this->render('second_life/qui_sommes_nous.html.twig', [
            'titre_page'=>'Qui sommes nous?'
        ]);
    }

    /**
     * @Route("/mentionsLegales", name="secondLife_mentions_legales")
     */
    public function mentions_legales(): Response
    {
        return $this->render('second_life/index.html.twig', [
            'titre_page'=>'Mentions légales'
        ]);
    }

    /**
     * @Route("/conditionsGeneralesUtilisation", name="secondLife_conditions_generales_utilisation")
     */
    public function conditions_generales_utilisation(): Response
    {
        return $this->render('second_life/index.html.twig', [
            'titre_page'=>'Conditions générales d\'utilisation'
        ]);
    }

    /**
     * @Route("/barre_recherche", name="secondLife_barre_recherche")
     */
    public function barre_recherche(): Response
    {
        return $this->render('second_life/index.html.twig', [
            'titre_page'=>'Resultats de la recherche'
        ]);
    }
    //temporaire
    // /**
    //  * @Route("/inscriptionp", name="secondLife_inscription")
    //  */
    // public function inscription(): Response
    // {
    //     return $this->render('second_life/connexion_inscription.html.twig', [
    //         'titre_page'=>'connexion/inscription',
    //         'sous_titre_connexion'=>'Dejà membre?',
    //         'sous_titre_inscription'=>'Pas encore membre?'
    //     ]);
    // }
}