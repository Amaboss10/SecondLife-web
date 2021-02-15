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
        return $this->render('second_life_admin/index.html.twig', [
            'titre_page'=>'Accueil',
        ]);
    }

    /**
     * Affiche les rubriques de la FAQ et les boutons des modifications
     * @Route("/faq", name="gerer_faq")
     */
    public function gererFaq(FAQRepository $repository): Response
    {
        $rubriques=$repository->findAll();
        return $this->render('second_life_admin/gerer_faq.html.twig', [
            'titre_page'=>'Gerer la FAQ',
            'rubriques'=>$rubriques
        ]);
    }

    /**
     * Permet d'ajouter et modifier une rubrique
     * @Route("/faq/ajouter", name="ajouter_faq")
     * @Route("/faq/modifier/{id}", name="modifier_faq")
     */
    public function ajouterModifierFaq(FAQ $faq=null,Request $request): Response
    {
        //si $faq est nulle
        if(!$faq){
            $faq=new FAQ();
        }

        //creation du formulaire
        $form=$this->createFormBuilder($faq)
                   ->add('titre_probleme',TextType::class)
                   ->add('description_probleme',TextareaType::class)
                   ->add('solution_probleme',TextareaType::class)
                   ->add('lien_tutoriel',TextType::class)
                   ->getForm();
        
        //Recuperation des données du formulaire
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //si c'est une creation/ajout de rubrique
            if(!$faq->getId()){
                $faq->setDateProbleme(new \DateTime());
            }
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($faq);
            $entityManager->flush();
            $this->addFlash("success",'Ajout rubrique '.$faq->getTitreProbleme() .'reussi');
            
            return $this->redirectToRoute('secondLife_admin_gerer_faq');
        }

        return $this->render('second_life_admin/ajouter_faq.html.twig', [
            'titre_page'=>'Ajouter une rubrique à la FAQ',
            'formulaire'=>$form->createView(),
            'etat'=>$faq->getId() !==null
        ]);
    }

    //PENSER à CRYPTER LES ID

    /**
     * @Route("/faq/supprimer/{id}", name="supprimer_faq")
     */
    public function supprimerFaq(FAQ $faq,Request $request): Response
    {
        //seul l'admin peut supprimer
        //si $faq est nulle
        if(!$faq){
            //erreur
        }

        $entityManager = $this->getDoctrine()->getManager();
        $titre=$faq->getTitreProbleme();
        //peut etre demander confirmation avant suppression
        $entityManager->remove($faq);
        $entityManager->flush();
        $this->addFlash("success",'Suppression  rubrique '.$titre .'reussie');
            
        return $this->redirectToRoute('secondLife_admin_gerer_faq');    
    }
    
    /**
     * @Route("/annonces", name="gerer_annonces")
     */
    public function gererAnnonces(): Response
    {
        return $this->render('second_life_admin/gerer_annonces.html.twig', [
            'titre_page'=>'Gerer les annonces',
        ]);
    }

    /**
     * @Route("annonces/afficher/{id}", name="afficher_annonce")
     */
    public function afficherAnnonce(Annonce $annonce,Request $request): Response
    {

        return $this->render('second_life_admin/ajouter_faq.html.twig', [
            'titre_page'=>$annonce->getTitreAnnonce(),
            'annonce'=>$annonce
        ]);
    }

    /**
     * @Route("annonces/valider/{id}", name="valider_annonce")
     */
    public function validerAnnonce(Annonce $annonce,Request $request): Response
    {
        //$annonce->setValidation(true);
        //demander confirmation?
        $this->addFlash("success",'Annonce  '.$annonce->getTitreAnnonce() .' validée');
            
        return $this->redirectToRoute('secondLife_admin_afficher_annonce',array('id'=>$annonce->getId()));    

    }

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

