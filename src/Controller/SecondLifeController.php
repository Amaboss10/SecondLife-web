<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Data\FiltreAnnonceData;
use App\Repository\FAQRepository;
use App\Form\SearchAnnonceFormType;
use App\Repository\MarqueRepository;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use App\Repository\SousCategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecondLifeController extends AbstractController
{
    /**
     * @Route("/", name="secondLife_accueil")
     */
    public function index(Request $request,AnnonceRepository $annonceRepository, MarqueRepository $marqueRepository,CategorieRepository $categorieRepository,SousCategorieRepository $sousCategorieRepository): Response
    {
        //RECUPERATION DES DONNEES POUR CONSTRUIRE LE FORMULAIRE DYNAMIQUEMENT
        $marques=$marqueRepository->findAll();
        $categories=$categorieRepository->findAll();
        $sous_categories=$sousCategorieRepository->findAll();
    
        //FILTRE ANNONCES
        $data=new FiltreAnnonceData();
        
        //$data->page=$request->get('page',1);
        
        //creation formulaire de filtre
        $form=$this->createForm(SearchAnnonceFormType::class,$data);
        
        //recuperation données formulaire de filtre
        $form->handleRequest($request);
        
        //traitement formulaire de filtre
        if($form->isSubmitted() and $form->isValid()){
            //a corriger
            $annonces=$annonceRepository->findAnnoncesFiltrees($data);
        }
        else {
            $annonces=$annonceRepository->findAnnoncesNonVendues();
        }
        
        return $this->render('second_life/index.html.twig', [
            'titre_page'=>'Accueil', 
            'marques'=>$marques,
            'categories'=>$categories,
            'sous_categories'=>$sous_categories,
            'annonces'=>$annonces,
            'nb_results'=>count($annonces),
            'form'=>$form->createView()
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

    /**
     * @Route("/annonces/{id}", name="secondLife_afficher_annonce")
     */
    public function afficher_annonce(Annonce $annonce,AnnonceRepository $repository): Response
    {
        
        return $this->render('second_life/index.html.twig', [
            'titre_page'=>$annonce->getTitreAnnonce(),
            'annonce'=>$annonce
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