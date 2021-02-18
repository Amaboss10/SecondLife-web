<?php

namespace App\Controller;

use App\Entity\SousCategorie;
use App\Entity\Categorie;
use App\Form\SousCategorieType;
use App\Repository\SousCategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/souscategories")
 */
class SousCategorieController extends AbstractController
{
    /**
     * @Route("/", name="secondLife_admin_gerer_sous_categories", methods={"GET"})
     */
    public function index(SousCategorieRepository $sousCategorieRepository): Response
    {
        return $this->render('sous_categorie/gerer_sous_categories.html.twig', [
            'titre_page'=>'Sous-categories',
            'sous_categories' => $sousCategorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/creer", name="secondLife_admin_creer_sous_categorie", methods={"GET","POST"})
     */
    public function creerSousCategorie(Request $request): Response
    {
        $sousCategorie = new SousCategorie();
        $form = $this->createForm(SousCategorieType::class, $sousCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sousCategorie);
            $entityManager->flush();

            return $this->redirectToRoute('secondLife_admin_afficher_sous_categories_par_categorie',array('id'=>$sousCategorie->getCategorie()->getId()));
        }

        return $this->render('sous_categorie/creer_sous_categorie.html.twig', [
            'titre_page'=>'Créer une sous-catégorie',
            'sous_categorie' => $sousCategorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/annonces", name="secondLife_admin_afficher_annonces_par_sous_categorie", methods={"GET"})
     */
    public function afficherAnnoncesParSousCategorie(SousCategorie $sousCategorie): Response
    {
        return $this->render('sous_categorie/afficher_annonces_par_sous_categorie.html.twig', [
            'titre_page'=>'Annonces de la sous-categorie "'.$sousCategorie->getNomSousCategorie(). '" ( catégorie "'.$sousCategorie->getCategorie()->getNomCategorie() .'")',
            'sous_categorie' => $sousCategorie,
            'nb_annonces'=> count($sousCategorie->getAnnonces())
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="secondLife_admin_modifier_sous_categorie", methods={"GET","POST"})
     */
    public function modifierSousCategorie(Request $request, SousCategorie $sousCategorie): Response
    {
        $form = $this->createForm(SousCategorieType::class, $sousCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('secondLife_admin_afficher_sous_categories_par_categorie',array('id'=>$sousCategorie->getCategorie()->getId()));
        }

        return $this->render('sous_categorie/modifier_sous_categorie.html.twig', [
            'titre_page'=>'Modifier la sous-categorie',
            'sous_categorie' => $sousCategorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/supprimer", name="secondLife_admin_supprimer_sous_categorie", methods={"DELETE"})
     */
    public function supprimerSousCategorie(Request $request, SousCategorie $sousCategorie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sousCategorie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sousCategorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('secondLife_admin_afficher_sous_categories_par_categorie',array('id'=>$sousCategorie->getCategorie()->getId()));
    }
}
