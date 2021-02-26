<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use App\Repository\FavorisRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/secondLife", name="secondLife_")
 */
class MonCompteController extends AbstractController
{
    /**
     * @Route("/user/monCompte", name="mon_compte")
     */
    public function monCompte(UserInterface $user,UtilisateurRepository $utilisateurRepository): Response
    {
        
        return $this->render('mon_compte/user/mon_compte.html.twig', [
            'titre_page'=>'Mon compte',
            'utilisateur'=>$utilisateur=$utilisateurRepository->find($user),
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
}
