<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('accueil/home.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    #[Route('/admin', name: 'app_admin', methods: ['GET'])]
    public function adminIndex(): Response
    {
        return $this->render('accueil/admin_home.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
}
