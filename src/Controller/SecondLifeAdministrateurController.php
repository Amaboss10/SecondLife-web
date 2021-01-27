<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecondLifeAdministrateurController extends AbstractController
{
    /**
     * @Route("/secondLife/administrateur", name="secondLife_administrateur")
     */
    public function index(): Response
    {
        return $this->render('second_life_administrateur/index.html.twig', [
            'controller_name' => 'SecondLifeAdministrateurController',
        ]);
    }
}
