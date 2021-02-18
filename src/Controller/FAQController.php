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

class FAQController extends AbstractController
{
    //UTILISATEUR

    /**
     * @Route("/faq", name="secondLife_faq")
     */
    public function faq(FAQRepository $repository,CategorieFAQRepository $categorieFAQRepos): Response
    {
        $categoriesFaq=$categorieFAQRepos->findAll();
        $rubriques=$repository->findAll();
        return $this->render('faq/faq.html.twig', [
            'titre_page'=>'FAQ/Aide',
            'categoriesFaq'=>$categoriesFaq,
            'rubriques' => $rubriques
        ]);
    }

    //ADMINISTRATEUR
    /**
     * @Route("/secondLife/admin/faq", name="secondLife_admin_gerer_faq", methods={"GET"})
     */
    public function gererFaq(FAQRepository $repository,CategorieFAQRepository $categorieFAQRepos): Response
    {
        $categoriesFaq=$categorieFAQRepos->findAll();
        $rubriques=$repository->findAll();
        return $this->render('faq/gerer_faq.html.twig', [
            'titre_page'=>'Gerer la FAQ',
            'categoriesFaq'=>$categoriesFaq,
            'rubriques'=>$rubriques
        ]);
    }

    /**
     * @Route("/new", name="f_a_q_new", methods={"GET","POST"})
     */
  /*  public function new(Request $request): Response
    {
        $fAQ = new FAQ();
        $form = $this->createForm(FAQType::class, $fAQ);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fAQ);
            $entityManager->flush();

            return $this->redirectToRoute('f_a_q_index');
        }

        return $this->render('faq/new.html.twig', [
            'f_a_q' => $fAQ,
            'form' => $form->createView(),
        ]);
    }
*/
    /**
     * Permet d'ajouter et modifier une rubrique
     * @Route("/secondLife/admin/faq/ajouter", name="secondLife_admin_ajouter_faq")
     * @Route("/secondLife/admin/faq/{id}/modifier", name="secondLife_admin_modifier_faq")
     */
    public function ajouterModifierFaq(FAQ $faq=null,Request $request): Response
    {
        //si $faq est nulle
        if(!$faq){
            $faq=new FAQ();
        }

        $form = $this->createForm(FAQType::class, $faq);

        //creation du formulaire
       /* $form=$this->createFormBuilder($faq)
                   ->add('titre_probleme',TextType::class)
                   ->add('description_probleme',TextareaType::class)
                   ->add('solution_probleme',TextareaType::class)
                   ->add('lien_tutoriel',TextType::class)
                   ->getForm();
                   */
        
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

        return $this->render('faq/ajouter_faq.html.twig', [
            'titre_page'=>'Ajouter une rubrique à la FAQ',
            'form'=>$form->createView(),
            'faq'=>$faq,
            'etat'=>$faq->getId() !==null
        ]);
    }
    ///**
    // * @Route("/{id}/edit", name="f_a_q_edit", methods={"GET","POST"})
     //*/
    /*public function edit(Request $request, FAQ $fAQ): Response
    {
        $form = $this->createForm(FAQType::class, $fAQ);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('f_a_q_index');
        }

        return $this->render('faq/edit.html.twig', [
            'f_a_q' => $fAQ,
            'form' => $form->createView(),
        ]);
    }
*/

    ///**
    // * @Route("/{id}", name="f_a_q_show", methods={"GET"})
     //*/
    /*public function show(FAQ $fAQ): Response
    {
        return $this->render('faq/show.html.twig', [
            'f_a_q' => $fAQ,
        ]);
    }*/

    

    /**
     * @Route("/secondLife/admin/faq/{id}/supprimer", name="secondLife_admin_supprimer_faq", methods={"DELETE"})
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
