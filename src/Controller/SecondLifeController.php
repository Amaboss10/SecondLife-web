<?php

namespace App\Controller;

use App\Data\FiltreAnnonceData;
use App\Form\SearchAnnonceFormType;
use App\Repository\AnnonceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route( name="secondLife_")
 */
class SecondLifeController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(Request $request,AnnonceRepository $annonceRepository,PaginatorInterface $paginator): Response
    {
        //FILTRE ANNONCES
        $data=new FiltreAnnonceData();
        
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
            $annonces=$annonceRepository->findAnnoncesDisponibles();
        }
        $annoncesPaginator=$paginator->paginate($annonces,$request->query->getInt('page',1),8);
        
        return $this->render('second_life/index.html.twig', [
            'titre_page'=>'Accueil', 
            'annonces'=>$annoncesPaginator,
            'nb_results'=>count($annonces),
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("secondLife/annonces/images/supprimer/{id}", name="supprimer_image_annonce")
     */
    public function supprimerImageAnnonce(): Response
    {
        return $this->render('second_life/favoris.html.twig', [
            'titre_page'=>'Mes favoris'
        ]);
    }
    
    /**
     * @Route("secondLife/messagerie", name="messagerie")
     */
    public function messagerie(): Response
    {
        return $this->render('second_life/messagerie.html.twig', [
            'titre_page'=>'Messagerie'
        ]);
    }
    
    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion(): Response
    {
        return $this->render('second_life/index.html.twig', [
            'titre_page'=>'Accueil'
        ]);
    }

    /**
     * @Route("secondLife/quiSommesNous", name="qui_sommes_nous")
     */
    public function qui_sommes_nous(): Response
    {
        return $this->render('second_life/qui_sommes_nous.html.twig', [
            'titre_page'=>'Qui sommes nous?'
        ]);
    }

    /**
     * @Route("secondLife/mentionsLegales", name="mentions_legales")
     */
    public function mentions_legales(): Response
    {
        return $this->render('second_life/index.html.twig', [
            'titre_page'=>'Mentions légales'
        ]);
    }

    /**
     * @Route("secondLife/conditionsGeneralesUtilisation", name="conditions_generales_utilisation")
     */
    public function conditions_generales_utilisation(): Response
    {
        return $this->render('second_life/index.html.twig', [
            'titre_page'=>'Conditions générales d\'utilisation'
        ]);
    }

    /**
     * @Route("/barre_recherche", name="barre_recherche")
     */
    public function barre_recherche(): Response
    {
        return $this->render('second_life/index.html.twig', [
            'titre_page'=>'Resultats de la recherche'
        ]);
    }

   
}