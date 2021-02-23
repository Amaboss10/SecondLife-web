<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Annonce;
use App\Form\UtilisateurType;
use App\Repository\AnnonceRepository;
use App\Repository\FavorisRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/secondLife", name="secondLife_")
 */
class UtilisateurController extends AbstractController
{
    //admin

    /**
     * @Route("/admin/utilisateurs/", name="admin_gerer_utilisateurs", methods={"GET"})
     */
    public function gererUtilisateurs(UtilisateurRepository $utilisateurRepository): Response
    {
        return $this->render('utilisateur/admin/gerer_utilisateurs.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
        ]);
    }

    /**
     * @Route("admin/utilisateurs/{id_personne}/afficher", name="admin_afficher_utilisateur", methods={"GET"})
     */
    public function afficherUtilisateurAdmin(Utilisateur $utilisateur,AnnonceRepository $annonceRepos,FavorisRepository $favorisRepos): Response
    {
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

        return $this->render('utilisateur/admin/afficher_utilisateur.html.twig', [
            'titre_page'=>'Profil de '.$utilisateur->getPseudoUser() ,
            'utilisateur' => $utilisateur,
            'annoncesSuggerees'=>$annoncesSuggerees
        ]);
    }

    /**
     * @Route("/admin/utilisateurs/{id_personne}/supprimer", name="admin_supprimer_utilisateur", methods={"DELETE"})
     */
    public function supprimerUtilisateurAdmin(Request $request, Utilisateur $utilisateur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getIdPersonne(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            
            foreach ($utilisateur->getAnnonces() as $annonce) {
                foreach ($annonce->getImagesAnnonce() as $imageannonce) {
                    $annonce->removeImagesAnnonce($imageannonce);
                    $entityManager->remove($imageannonce);
                }
                $utilisateur->removeAnnonce($annonce);
                $entityManager->remove($annonce);
            }

            foreach($utilisateur->getConversations() as $conversation){
                $utilisateur->removeConversation($conversation);
                //$entityManager->remove($conversation);
            }
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }
        //return $this->redirectToRoute('secondLife_admin_envoi_mail_motif_suppression')
        return $this->redirectToRoute('secondLife_admin_gerer_utilisateurs');
    }

    public function envoiMailUtilisateur(string $destinataire,string $expediteur){

    }

    ///**
    // * @Route("/new", name="utilisateur_new", methods={"GET","POST"})
    // */
    /*public function new(Request $request): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }*/

    //USER
    /**
     * @Route("user/utilisateurs/{id_personne}/afficher", name="afficher_utilisateur", methods={"GET"})
     */
    public function afficherUtilisateurUser(Utilisateur $utilisateur,AnnonceRepository $annonceRepos,FavorisRepository $favorisRepos): Response
    {
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
     * @Route("/{id_personne}/edit", name="utilisateur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Utilisateur $utilisateur): Response
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }

    

    /**
     * @Route("/user/monCompte/supprimerMonCompte", name="supprimer_mon_compte", methods={"DELETE"})
     */
    public function supprimerUtilisateurUser(Request $request, UserInterface $user,UtilisateurRepository $utilisateurRepository): Response
    {
        $utilisateur=$utilisateurRepository->find($user);
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getIdPersonne(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            
            foreach ($utilisateur->getAnnonces() as $annonce) {
                $utilisateur->removeAnnonce($annonce);
                $entityManager->remove($annonce);
            }

            foreach($utilisateur->getConversations() as $conversation){
                $utilisateur->removeConversation($conversation);
                //$entityManager->remove($conversation);
            }
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_logout');
    }

}
