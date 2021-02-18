<?php

namespace App\Controller;

use App\Entity\CategorieFAQ;
use App\Form\CategorieFAQType;
use App\Repository\AdministrateurRepository;
use App\Repository\CategorieFAQRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/secondLife/admin/categoriesFaq",name="secondLife_admin_")
 */
class CategorieFAQController extends AbstractController
{
    /**
     * @Route("/", name="gerer_categoriesFaq", methods={"GET"})
     */
    public function index(CategorieFAQRepository $categorieFAQRepository): Response
    {
        return $this->render('categorie_faq/gerer_categoriesFaq.html.twig', [
            'titre_page'=>'Les catégories de la FAQ',
            'categories_faq' => $categorieFAQRepository->findAll(),
        ]);
    }

    /**
     * @Route("/creer", name="creer_categorieFaq", methods={"GET","POST"})
     */
    public function creerCategorieFaq(Request $request): Response
    {
        $categorieFAQ = new CategorieFAQ();
        $form = $this->createForm(CategorieFAQType::class, $categorieFAQ);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorieFAQ);
            $entityManager->flush();

            return $this->redirectToRoute('secondLife_admin_gerer_categoriesFaq');
        }

        return $this->render('categorie_faq/creer_categorieFaq.html.twig', [
            'titre_page'=>'Créer une catégorie de FAQ',
            'categorie_faq' => $categorieFAQ,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/faq", name="afficher_faq_par_categorieFaq", methods={"GET"})
     */
    public function afficherFaqParCategorie(CategorieFAQ $categorieFAQ): Response
    {
        return $this->render('categorie_faq/afficher_faq_par_categorieFaq.html.twig', [
            'titre_page'=>'Les FAQ de la catégorie '. $categorieFAQ->getNomCategorie(),
            'categorie_faq' => $categorieFAQ,
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="modifier_categorieFaq", methods={"GET","POST"})
     */
    public function modifierCategorieFaq(Request $request, CategorieFAQ $categorieFAQ): Response
    {
        $form = $this->createForm(CategorieFAQType::class, $categorieFAQ);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('secondLife_admin_gerer_categoriesFaq');
        }

        return $this->render('categorie_faq/modifier_categorieFaq.html.twig', [
            'titre_page'=>'Modifier la catégorie',
            'categorie_faq' => $categorieFAQ,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/supprimer", name="supprimer_categorieFaq", methods={"DELETE"})
     */
    public function supprimerCategorieFaq(Request $request, CategorieFAQ $categorieFAQ,CategorieFAQRepository $categorieFAQRepos,AdministrateurRepository $adminRepos): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        /*$categorieAutre=$categorieFAQRepos->findCategorieFaqByNom("Autres");
        if($categorieAutre==null){
            // si la categorie autre n'existe pas encore,on la crée
            $categorieAutre=new CategorieFAQ();
            $categorieAutre->setNomCategorie('Autres');
                           //->setIdAdministrateur($adminRepos->findOneBy(['id_personne'=>'1']));
            $entityManager->persist($categorieAutre);
            $entityManager->flush();
        }*/
        
        if ($this->isCsrfTokenValid('delete'.$categorieFAQ->getId(), $request->request->get('_token'))) {
            foreach ($categorieFAQ->getFAQs() as $faq) {
                //on deplace les faqs dans la catégorie Autres
                //$categorieAutre->addFAQ($faq);
                
                //on retire faq de la liste de faq de la categorie
                $categorieFAQ->removeFAQ($faq);
                //on supprime la faq
                $entityManager->remove($faq);
            }
            
            //on supprime la categorie
            $entityManager->remove($categorieFAQ);
            $entityManager->flush();
        }

        return $this->redirectToRoute('secondLife_admin_gerer_categoriesFaq');
    }
}
