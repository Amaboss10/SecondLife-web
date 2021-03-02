<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/secondLife", name="secondLife_")
 */
class CategorieController extends AbstractController
{
    /**
     * @Route("/admin/categories/", name="admin_gerer_categories", methods={"GET"})
     */
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/admin/gerer_categories.html.twig', [
            'titre_page'=>'Catégories',
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/categories/creer", name="admin_creer_categorie", methods={"GET","POST"})
     */
    public function creerCategorie(Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('secondLife_admin_gerer_categories');
        }

        return $this->render('categorie/admin/creer_categorie.html.twig', [
            'titre_page'=>'Créer une catégorie',
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/categories/{id}/annonces", name="admin_afficher_annonces_par_categorie", methods={"GET"})
     */
    public function afficherAnnoncesParCategorie(Categorie $categorie): Response
    {
        return $this->render('categorie/admin/afficher_annonces_par_categorie.html.twig', [
            'titre_page'=>'Annonces de la catégorie '.$categorie->getNomCategorie(),
            'nb_annonces'=>count($categorie->getAnnonces()),
            'categorie' => $categorie,
        ]);
    }

    /**
     * @Route("/admin/categories/{id}/souscategorie", name="admin_afficher_sous_categories_par_categorie", methods={"GET"})
     */
    public function afficherSousCategorieParCategorie(Categorie $categorie): Response
    {
        return $this->render('categorie/admin/afficher_sous_categories_par_categorie.html.twig', [
            'titre_page'=>'Sous-categories de la catégorie '.$categorie->getNomCategorie(),
            'nb_sous_categorie'=>count($categorie->getSousCategorie()),
            'categorie' => $categorie,
        ]);
    }

    /**
     * @Route("/admin/categories/{id}/modifier", name="admin_modifier_categorie", methods={"GET","POST"})
     */
    public function modifierCategorie(Request $request, Categorie $categorie): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('secondLife_admin_gerer_categories');
        }

        return $this->render('categorie/admin/modifier_categorie.html.twig', [
            'titre_page'=>'Modifier la catgorie',
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/categories/{id}/supprimer", name="admin_supprimer_categorie", methods={"DELETE"})
     */
    public function delete(Request $request, Categorie $categorie): Response
    {
        if(count($categorie->getAnnonces())==0){
            if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                foreach ($categorie->getSousCategorie() as $sousCategorie) {
                    //on retire la sous categorie de la liste de faq de la categorie
                    $categorie->removeSousCategorie($sousCategorie);
                    //on supprime la sous categorie
                    $entityManager->remove($sousCategorie);
                }
                $entityManager->remove($categorie);
                $entityManager->flush();
            }    
        }

        
        return $this->redirectToRoute('secondLife_admin_gerer_categories');
    }
}
