<?php

namespace App\Controller;
 
use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Entity\PhotoAnnonce;
use App\Repository\MarqueRepository;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use App\Form\CreerModifierAnnonceFormType;
use App\Repository\FavorisRepository;
use App\Repository\PhotoAnnonceRepository;
use App\Repository\SousCategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/secondLife", name="secondLife_")
 */
class AnnonceController extends AbstractController
{
    //ADMIN
    /**
     * @Route("/admin/annonces", name="admin_gerer_annonces", methods={"GET"})
     */
    public function gererAnnonces(AnnonceRepository $annonceRepository,PhotoAnnonceRepository $photoRepo): Response
    {
        $annonces=$annonceRepository->findAll();
        return $this->render('annonce/admin/gerer_annonces_admin.html.twig', [
            'annonces' =>$annonces ,
            'nb_annonces'=>count($annonces),
            'titre_page'=>'Annonces'
        ]);
    }

    /**
     * @Route("/admin/annonces/{id}/valider", name="admin_valider_annonce", methods={"GET"})
     */
    public function validerAnnonce(Annonce $annonce,AnnonceRepository $annonceRepository): Response
    {

        $annonce->setEstValide(true);

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->persist($annonce);
        $entityManager->flush();

        return $this->redirectToRoute('secondLife_admin_afficher_annonce',array(
            'id'=>$annonce->getIdAnnonce()
        ));    

        /*return $this->render('annonce/admin/afficher_annonce_admin.html.twig', [
            //'annonces' =>$annonces ,
            //'nb_annonces'=>count($annonces),
            'titre_page'=>$annonce->getTitreAnnonce(),
            'annonce'=>$annonce
        ]);*/
    }

    /**
     * @Route("/admin/annonces/{id}/afficher", name="admin_afficher_annonce", methods={"GET"})
     */
    public function afficherAnnonceAdmin(Annonce $annonce,AnnonceRepository $annonceRepository): Response
    {   
        if( $annonceRepository->findBy(['sous_categorie'=>$annonce->getSousCategorie()]) && count($annonceRepository->findBy(['sous_categorie'=>$annonce->getSousCategorie()]))>1 )
        {
            $annonces=$annonceRepository->findBy(['sous_categorie'=>$annonce->getSousCategorie()],null,4,null);
        }
        else if( $annonceRepository->findBy(['categorie'=>$annonce->getCategorie()]) && count($annonceRepository->findBy(['categorie'=>$annonce->getCategorie()]))>1  ){
            $annonces=$annonceRepository->findBy(['categorie'=>$annonce->getCategorie()],null,4,null) ;
        }
        else if($annonceRepository->findBy(['marque'=>$annonce->getMarque()]) && count($annonceRepository->findBy(['marque'=>$annonce->getMarque()]))>1){
            $annonces=$annonceRepository->findBy(['marque'=>$annonce->getMarque()],null,4,null);
        }
        else if($annonceRepository->findBy(['utilisateur'=>$annonce->getUtilisateur()]) && count($annonceRepository->findBy(['utilisateur'=>$annonce->getUtilisateur()]))>1){
            $annonces=$annonceRepository->findBy(['utilisateur'=>$annonce->getUtilisateur()],null,4,null);
        }
        else{
            $annonces=$annonceRepository->findAll();
        }

        return $this->render('annonce/admin/afficher_annonce_admin.html.twig', [
            'titre_page'=>$annonce->getTitreAnnonce(),
            'annonce'=>$annonce,
            'annonces'=>$annonces
        ]);
    }

    
    /**
     * @Route("/admin/annonces/{id}/supprimer", name="admin_supprimer_annonce", methods={"DELETE"})
     */
    public function supprimerAnnonceAdmin(Request $request, Annonce $annonce,FavorisRepository $favorisRepos): Response
    {
        //on fait appel à supprimerAnnonce et on envoie une notification à l'utilisateur
        if ($this->isCsrfTokenValid('delete'.$annonce->getIdAnnonce(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            
            //on retire l'annonce de tous les listes d'annonces favorites
            $lesfavoris=$favorisRepos->findBy(['id_annonce'=>$annonce]);
            foreach ($lesfavoris as $favoris) {
                $entityManager->remove($favoris);
            }

            //on supprime les photos de l'annonce
            foreach ($annonce->getImagesAnnonce() as $photo) {
                //on detache la photo de l'annonce
                $annonce->removeImagesAnnonce($photo);
                //on supprime la photo de nos dossiers
                $entityManager->remove($photo);
            }
            
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('secondLife_admin_gerer_annonces');
    }

    ///**
     //* @Route("/admin/annonces/{id}/supprimer", name="admin_supprimer_annonce", methods={"DELETE"})
     //*/
    public function supprimerAnnonce(Request $request, Annonce $annonce,FavorisRepository $favorisRepos): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getIdAnnonce(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            
            //on retire l'annonce de tous les listes d'annonces favorites
            $lesfavoris=$favorisRepos->findBy(['id_annonce'=>$annonce]);
            foreach ($lesfavoris as $favoris) {
                $entityManager->remove($favoris);
            }

            //on supprime les photos de l'annonce
            foreach ($annonce->getImagesAnnonce() as $photo) {
                //on detache la photo de l'annonce
                $annonce->removeImagesAnnonce($photo);
                //on supprime la photo de nos dossiers
                $entityManager->remove($photo);
            }
            
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('secondLife_admin_gerer_annonces');
    }

    //UTILISATEUR
    //annonces/marque

    /**
     * @Route("/user/annonces/creer", name="creer_annonce")
     * @Route("/user/annonces/modifier/{id}",name="modifier_annonce")
     */
    public function creerModifierAnnonce(Annonce $annonce=null,Request $request,AnnonceRepository $annonceRepository, MarqueRepository $marqueRepository,CategorieRepository $categorieRepository,SousCategorieRepository $sousCategorieRepository): Response
    {
        //RECUPERATION DES DONNEES POUR CONSTRUIRE LE FORMULAIRE DYNAMIQUEMENT
        $marques=$marqueRepository->findAll();
        $categories=$categorieRepository->findAll();
        $sous_categories=$sousCategorieRepository->findAll();

        $annonces=null;
        //$annonces=$annonceRepository->findBy(['utilisateur'=>$this->getUser()]);
        $titre="Mes annonces";
        if($annonces==null){
            $titre="Quelques annonces";
            //$annonces=$annonceRepository->findAnnoncesDisponibles();
            $annonces=$annonceRepository->findBy(['etat_annonce'=>'Disponible'],['date_publi_annonce'=>'DESC'],6,null);
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
                //$entityManager->persist($photo);
            }
            
            $entityManager->persist($annonce);
            $entityManager->flush();
            $this->addFlash("success",'Ajout annonce '.$annonce->getTitreAnnonce() .'reussi');
            
            return $this->redirectToRoute('secondLife_gerer_mes_annonces');
        }
        return $this->render('annonce/user/creer_modifier_annonce.html.twig', [
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
    }

    /**
     * @Route("/user/annonces/{id}/afficher", name="afficher_annonce")
     */
    public function afficherAnnonceUser(Annonce $annonce,AnnonceRepository $annonceRepository): Response
    {
        if( $annonceRepository->findBy(['sous_categorie'=>$annonce->getSousCategorie()]) && count($annonceRepository->findBy(['sous_categorie'=>$annonce->getSousCategorie()]))>1 )
        {
            $annonces=$annonceRepository->findBy(['sous_categorie'=>$annonce->getSousCategorie()],null,4,null);
        }
        else if( $annonceRepository->findBy(['categorie'=>$annonce->getCategorie()]) && count($annonceRepository->findBy(['categorie'=>$annonce->getCategorie()]))>1  ){
            $annonces=$annonceRepository->findBy(['categorie'=>$annonce->getCategorie()],null,4,null) ;
        }
        else if($annonceRepository->findBy(['marque'=>$annonce->getMarque()]) && count($annonceRepository->findBy(['marque'=>$annonce->getMarque()]))>1){
            $annonces=$annonceRepository->findBy(['marque'=>$annonce->getMarque()],null,4,null);
        }
        else if($annonceRepository->findBy(['utilisateur'=>$annonce->getUtilisateur()]) && count($annonceRepository->findBy(['utilisateur'=>$annonce->getUtilisateur()]))>1){
            $annonces=$annonceRepository->findBy(['utilisateur'=>$annonce->getUtilisateur()],null,4,null);
        }
        else{
            $annonces=$annonceRepository->findAll();
        }
        return $this->render('annonce/user/afficher_annonce.html.twig', [
            'titre_page'=>$annonce->getTitreAnnonce(),
            'annonce'=>$annonce,
            'annonces'=>$annonces

        ]);
    }

    /**
     * @Route("/user/monCompte/mesAnnonces/{id}/supprimer", name="supprimer_mon_annonce")
     */
    public function supprimerMonAnnonceUser(Annonce $annonce,UserInterface $user,AnnonceRepository $annonceRepository): Response
    {
        if($annonce->getUtilisateur()==$user){
            //on supprime
        }
        if( $annonceRepository->findBy(['sous_categorie'=>$annonce->getSousCategorie()]) && count($annonceRepository->findBy(['sous_categorie'=>$annonce->getSousCategorie()]))>1 )
        {
            $annonces=$annonceRepository->findBy(['sous_categorie'=>$annonce->getSousCategorie()],null,4,null);
        }
        else if( $annonceRepository->findBy(['categorie'=>$annonce->getCategorie()]) && count($annonceRepository->findBy(['categorie'=>$annonce->getCategorie()]))>1  ){
            $annonces=$annonceRepository->findBy(['categorie'=>$annonce->getCategorie()],null,4,null) ;
        }
        else if($annonceRepository->findBy(['marque'=>$annonce->getMarque()]) && count($annonceRepository->findBy(['marque'=>$annonce->getMarque()]))>1){
            $annonces=$annonceRepository->findBy(['marque'=>$annonce->getMarque()],null,4,null);
        }
        else if($annonceRepository->findBy(['utilisateur'=>$annonce->getUtilisateur()]) && count($annonceRepository->findBy(['utilisateur'=>$annonce->getUtilisateur()]))>1){
            $annonces=$annonceRepository->findBy(['utilisateur'=>$annonce->getUtilisateur()],null,4,null);
        }
        else{
            $annonces=$annonceRepository->findAll();
        }
        return $this->render('annonce/user/afficher_annonce.html.twig', [
            'titre_page'=>$annonce->getTitreAnnonce(),
            'annonce'=>$annonce,
            'annonces'=>$annonces

        ]);
    }

    /**
     * @Route("/user/monCompte/mesAnnonces", name="gerer_mes_annonces")
     */
    public function gererMesAnnonces(AnnonceRepository $annonceRepository,UserInterface $user): Response
    {
        $mesAnnonces=$annonceRepository->findBy(['utilisateur'=>$user]);

        return $this->render('annonce/user/gerer_mes_annonces.html.twig', [
            'titre_page'=>'Mes annonces',
            'nb_annonces'=>count($mesAnnonces),
            'mesAnnonces'=>$mesAnnonces
        ]);
    }

    /**
     * @Route("/user/monCompte/mesAnnonces/{id}/confirmerVente", name="confirmer_vente", methods={"GET"})
     */
    public function confirmerVenteAnnonce(Annonce $annonce,AnnonceRepository $annonceRepository): Response
    {

        $annonce->setEtatAnnonce('Vendu');

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->persist($annonce);
        $entityManager->flush();

        return $this->redirectToRoute('secondLife_afficher_annonce',array(
            'id'=>$annonce->getIdAnnonce()
        ));    

    }

    ///**
    // * @Route("/new", name="annonce_new", methods={"GET","POST"})
    // */
    /*public function new(Request $request): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('annonce_index');
        }

        return $this->render('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }*/

    ///**
    // * @Route("/{id}", name="annonce_show", methods={"GET"})
    // */
    /*public function show(Annonce $annonce): Response
    {
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }*/

}
