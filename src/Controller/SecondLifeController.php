<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Data\FiltreAnnonceData;
use App\Entity\PhotoAnnonce;
use App\Form\CreerModifierAnnonceFormType;
use App\Repository\FAQRepository;
use App\Form\SearchAnnonceFormType;
use App\Repository\MarqueRepository;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use App\Repository\SousCategorieRepository;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;

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
            $annonces=$annonceRepository->findAnnoncesDisponibles();
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

    ///**
    // * @Route("/creerAnnonce", name="secondLife_creer_annonce")
    // * @Route("/annonces/modifier/{id}",name="secondLife_modifier_annonce")
    // */
    /*public function creerModifierAnnonce(Annonce $annonce=null,Request $request,AnnonceRepository $annonceRepository, MarqueRepository $marqueRepository,CategorieRepository $categorieRepository,SousCategorieRepository $sousCategorieRepository): Response
    {
        //RECUPERATION DES DONNEES POUR CONSTRUIRE LE FORMULAIRE DYNAMIQUEMENT
        $marques=$marqueRepository->findAll();
        $categories=$categorieRepository->findAll();
        $sous_categories=$sousCategorieRepository->findAll();

        $annonces=null;
        //$annonces=$annonceRepository->findMesAnnonces($this->getUser());
        $titre="Mes annonces";
        if($annonces==null){
            $titre="Quelques annonces";
            $annonces=$annonceRepository->findAnnoncesNonVendues();
        }
        
        if(!$annonce){
            $annonce=new Annonce();
        }

        //creation formulaire
        $form=$this->createForm(CreerModifierAnnonceFormType::class,$annonce);

        //recuperation des données du formulaire
        $form->handleRequest($request);
        //traitement données formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            //si c'est une creation d'annonce
            if(!$annonce->getIdAnnonce()){
                $annonce->setDatePubliAnnonce(new \DateTime());
            }

            //images
            $images=$form->get('images_annonce')->getData();
            foreach ($images as $image) {
                //generation nom de fichier
                $fichier=md5(uniqid()).'.'.$image->guessExtension();
                //copie de l'image dans images_annonces
                $image->move($this->getParameter('images_annonces'),$fichier);
                //creation de l'image dans la bd
                $photo=new PhotoAnnonce();
                $photo->setLienPhotoAnnonce($fichier);
                $annonce->addImagesAnnonce($photo);
                $entityManager->persist($photo);
            }
            
            $entityManager->persist($annonce);
            $entityManager->flush();
            $this->addFlash("success",'Ajout annonce '.$annonce->getTitreAnnonce() .'reussi');
            
            return $this->redirectToRoute('secondLife_gerer_mes_annonces');
        }
        return $this->render('second_life/creer_annonce.html.twig', [
            'titre_page'=>'Creer une annonce',
            'marques'=>$marques,
            'categories'=>$categories,
            'sous_categories'=>$sous_categories,
            'annonce'=>$annonce,
            'form'=>$form->createView(),
            'etat'=>$annonce->getIdAnnonce() !==null,
            'titre'=>$titre,
            'annonces'=>$annonces
        ]);
    }*/
    

    /**
     * @Route("/annonces/images/supprimer/{id}", name="secondLife_supprimer_image_annonce")
     */
    public function supprimerImageAnnonce(): Response
    {
        return $this->render('second_life/favoris.html.twig', [
            'titre_page'=>'Mes favoris'
        ]);
    }

    ///**
    // * @Route("/compte/mesAnnonces/", name="secondLife_gerer_mes_annonces")
    // */
    /*public function gererMesAnnonces(): Response
    {
        return $this->render('second_life/gerer_annonces.html.twig', [
            'titre_page'=>'Mes annonces'
        ]);
    }*/

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

   // /**
    // * @Route("/annonces/{id}", name="secondLife_afficher_annonce")
   //  */
    /*public function afficher_annonce(Annonce $annonce,AnnonceRepository $repository): Response
    {
        
        return $this->render('second_life/index.html.twig', [
            'titre_page'=>$annonce->getTitreAnnonce(),
            'annonce'=>$annonce
        ]);
    }*/



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