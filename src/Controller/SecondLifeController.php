<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\PhotoAnnonce;
use App\Data\FiltreAnnonceData;
use App\Repository\FAQRepository;
use Doctrine\DBAL\Types\TextType;
use App\Form\SearchAnnonceFormType;
use App\Repository\MarqueRepository;
use App\Repository\AnnonceRepository;
use App\Repository\FavorisRepository;
use App\Repository\CategorieRepository;
use App\Form\CreerModifierAnnonceFormType;
use App\Repository\SousCategorieRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;

/**
 * @Route("/secondLife", name="secondLife_")
 */
class SecondLifeController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
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
    // * @Route("/creerAnnonce", name="creer_annonce")
    // * @Route("/annonces/modifier/{id}",name="modifier_annonce")
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
     * @Route("/annonces/images/supprimer/{id}", name="supprimer_image_annonce")
     */
    public function supprimerImageAnnonce(): Response
    {
        return $this->render('second_life/favoris.html.twig', [
            'titre_page'=>'Mes favoris'
        ]);
    }

    ///**
    // * @Route("/user/monCompte/mesAnnonces/", name="gerer_mes_annonces")
    // */
    /*public function gererMesAnnonces(): Response
    {
        return $this->render('second_life/gerer_annonces.html.twig', [
            'titre_page'=>'Mes annonces'
        ]);
    }*/

   // /**
     //* @Route("/favoris", name="secondLife_favoris")
    // */
    /*public function favoris(): Response
    {
        return $this->render('favoris/user/afficher_favoris.html.twig', [
            'titre_page'=>'Mes favoris'
        ]);
    }*/

    /**
     * @Route("/messagerie", name="messagerie")
     */
    public function messagerie(): Response
    {
        return $this->render('second_life/messagerie.html.twig', [
            'titre_page'=>'Messagerie'
        ]);
    }
    
    /**
     * @Route("/user/monCompte", name="mon_compte")
     */
    public function monCompte(UserInterface $user): Response
    {
        
        return $this->render('second_life/mon_compte.html.twig', [
            'titre_page'=>'Mon compte'
        ]);
    }

    /**
     * @Route("/user/monCompte/monProfil", name="afficher_mon_profil")
     */
    public function afficherMonProfil(UserInterface $user,UtilisateurRepository $userRepos,AnnonceRepository $annonceRepos,FavorisRepository $favorisRepos): Response
    {
        $utilisateur=$userRepos->find($user);
        
        $fav=$favorisRepos->findOneBy(['id_utilisateur'=>$utilisateur]);
        
        if($fav!=null){
            if($annoncetype=$fav->getIdAnnonce()){
                //on recupere la categorie d'un des fav et on affiche 4 annonces de cette categorie   
                if($annonceRepos->findBy(['categorie'=>$annoncetype->getCategorie()]) && $annonceRepos->findBy(['categorie'=>$annoncetype->getCategorie()])>1  ){
                    $annoncesSuggerees=$annonceRepos->findBy(['categorie'=>$annoncetype->getCategorie()],null,4,null);
                }
                else $annoncesSuggerees=$annonceRepos->findBy(['marque'=>$annoncetype->getMarque()],null,4,null);
            }
        }
        else{
            //on prend les 4 dernieres annonces publiées
            $annoncesSuggerees=$annonceRepos->findXAnnoncesNotUtilisateur(4,$utilisateur);
        }

        return $this->render('utilisateur/user/afficher_utilisateur.html.twig', [
            'titre_page'=>'Profil de '.$utilisateur->getPseudoUser() ,
            'utilisateur' => $utilisateur,
            'annoncesSuggerees'=>$annoncesSuggerees
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
     * @Route("/quiSommesNous", name="qui_sommes_nous")
     */
    public function qui_sommes_nous(): Response
    {
        return $this->render('second_life/qui_sommes_nous.html.twig', [
            'titre_page'=>'Qui sommes nous?'
        ]);
    }

    /**
     * @Route("/mentionsLegales", name="mentions_legales")
     */
    public function mentions_legales(): Response
    {
        return $this->render('second_life/index.html.twig', [
            'titre_page'=>'Mentions légales'
        ]);
    }

    /**
     * @Route("/conditionsGeneralesUtilisation", name="conditions_generales_utilisation")
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

   // /**
    // * @Route("/annonces/{id}", name="afficher_annonce")
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
    //  * @Route("/inscriptionp", name="inscription")
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