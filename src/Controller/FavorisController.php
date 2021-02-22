<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Favoris;
use App\Form\FavorisType;
use App\Repository\FavorisRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/secondLife", name="secondLife_")
 */
class FavorisController extends AbstractController
{
    /**
     * @Route("/user/mesFavoris/", name="afficher_favoris_utilisateur", methods={"GET"})
     */
    public function index(FavorisRepository $favorisRepository,UserInterface $user): Response
    {

        return $this->render('favoris/user/afficher_favoris.html.twig', [
            'titre_page'=>'Mes annonces favorites',
            'mes_favoris' => $favorisRepository->findBy(['id_utilisateur'=>$user]),
        ]);
    }

    /**
     * @Route("/user/mesFavoris/{id}/ajouterAuxFavoris", name="ajouter_aux_favoris_utilisateur", methods={"GET","POST"})
     */
    public function ajouterAuxFavoris(Annonce $annnonce,UserInterface $user,Request $request): Response
    {
        $favori = new Favoris();
        $favori->setIdAnnonce($annnonce)
               ->setIdUtilisateur($user)
               ->setDateFavoris(new \DateTime());
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($favori);
        $entityManager->flush();

        return $this->redirectToRoute('secondLife_afficher_favoris_utilisateur');
        

    }

    
    /**
     * @Route("/user/mesFavoris/{id}/retirerDesFavoris", name="retirer_des_favoris_utilisateur", methods={"DELETE"})
     */
    public function retirerDesFavoris(Request $request, Favoris $favori): Response
    {
        if ($this->isCsrfTokenValid('delete'.$favori->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($favori);
            $entityManager->flush();
        }

        return $this->redirectToRoute('secondLife_afficher_favoris_utilisateur');
    }
}
