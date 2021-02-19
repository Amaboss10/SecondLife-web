<?php

namespace App\Controller;

use App\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\FAQ;
use App\Repository\FAQRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
     * @Route("/secondLife/admin", name="secondLife_admin_")
     */
class SecondLifeAdminController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(): Response
    {
        //ajouter options:
        //*afficherAnnoncescategorie
        //*afficherAnnoncesSouscategorie
        //*afficherAnnoncesMarque
        return $this->render('second_life_admin/index.html.twig', [
            'titre_page'=>'Accueil',
        ]);
        }
    ///**
    // * @Route("/annonces", name="gerer_annonces")
    // */
    /*public function gererAnnonces(): Response
    {
        return $this->render('second_life_admin/gerer_annonces.html.twig', [
            'titre_page'=>'Gerer les annonces',
        ]);
    }*/

    ///**
    // * @Route("/annonces/afficher/{id}", name="afficher_annonce")
    // */
    /*public function afficherAnnonce(Annonce $annonce,Request $request): Response
    {

        return $this->render('second_life_admin/index.html.twig', [
            'titre_page'=>$annonce->getTitreAnnonce(),
            'annonce'=>$annonce
        ]);
    }*/

    ///**
    // * @Route("annonces/valider/{id}", name="valider_annonce")
    // */
    /*public function validerAnnonce(Annonce $annonce,Request $request): Response
    {
        //$annonce->setValidation(true);
        //demander confirmation?
        $this->addFlash("success",'Annonce  '.$annonce->getTitreAnnonce() .' validée');
            
        return $this->redirectToRoute('secondLife_admin_afficher_annonce',array('id'=>$annonce->getIdAnnonce()));    

    }*/

    /**
     * @Route("/annonces/supprimer/{id}", name="supprimer_annonces")
     */
    public function supprimerAnnonce(Annonce $annonce,Request $request): Response
    {
        //seul l'admin peut supprimer
        //si $annonce est nulle
        if(!$annonce){
            //erreur
        }

        $entityManager = $this->getDoctrine()->getManager();
        $titre=$annonce->getTitreAnnonce();
        //peut etre demander confirmation avant suppression
        
        //on supprime les photos de l'annonce
        foreach ($annonce->getImagesAnnonce() as $photo) {
            $annonce->removeImagesAnnonce($photo);
        }
        
        //on retire l'annonce de tous les listes d'annonces favorites
        /*foreach ($annonce->getFavoris() as $favoris) {
            $annonce->removeFavoris($favoris);
        }*/
        
        $entityManager->remove($annonce);
        $entityManager->flush();
        $this->addFlash("success",'Annonce  '.$titre .' supprimée');
            
        return $this->redirectToRoute('secondLife_admin_gerer_annonces');    
    }
}

