<?php

namespace App\Controller;

use App\Entity\FAQ;
use App\Form\FAQType;
use App\Repository\CategorieFAQRepository;
use App\Repository\FAQRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/secondLife", name="secondLife_")
 */
class FAQController extends AbstractController
{
    //UTILISATEUR

    /**
     * @Route("/faq", name="faq")
     */
    public function faq(FAQRepository $repository,CategorieFAQRepository $categorieFAQRepos): Response
    {
        $categoriesFaq=$categorieFAQRepos->findAll();
        $rubriques=$repository->findAll();
        return $this->render('faq/user/faq.html.twig', [
            'titre_page'=>'FAQ/Aide',
            'categoriesFaq'=>$categoriesFaq,
            'rubriques' => $rubriques
        ]);
    }

    //ADMINISTRATEUR

    /**
     * @Route("/admin/faq", name="admin_gerer_faq", methods={"GET"})
     */
    public function gererFaq(FAQRepository $repository,CategorieFAQRepository $categorieFAQRepos): Response
    {
        $categoriesFaq=$categorieFAQRepos->findAll();
        $rubriques=$repository->findAll();
        return $this->render('faq/admin/gerer_faq.html.twig', [
            'titre_page'=>'Gerer la FAQ',
            'categoriesFaq'=>$categoriesFaq,
            'rubriques'=>$rubriques
        ]);
    }

    /**
     * Permet d'ajouter et modifier une rubrique
     * @Route("/admin/faq/ajouter", name="admin_ajouter_faq")
     * @Route("/admin/faq/{id}/modifier", name="admin_modifier_faq")
     */
    public function ajouterModifierFaq(FAQ $faq=null,Request $request): Response
    {
        //si $faq est nulle
        if(!$faq){
            $faq=new FAQ();
        }

        //creation du formulaire
        $form = $this->createForm(FAQType::class, $faq);

        
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
            
            return $this->redirectToRoute('secondLife_admin_gerer_faq');
        }

        return $this->render('faq/admin/ajouter_faq.html.twig', [
            'titre_page'=>'Ajouter une rubrique à la FAQ',
            'form'=>$form->createView(),
            'faq'=>$faq,
            'etat'=>$faq->getId() !==null
        ]);
    }

    
    /**
     * @Route("/admin/faq/{id}/supprimer", name="admin_supprimer_faq", methods={"DELETE"})
     */
    public function delete(Request $request, FAQ $fAQ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fAQ->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fAQ);
            $entityManager->flush();
        }

        return $this->redirectToRoute('secondLife_admin_gerer_faq');
    }
}
