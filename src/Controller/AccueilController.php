<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('accueil/home.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    #[IsGranted("ROLE_USER")]
    #[Route('/utilisateur', name: 'app_user', methods: ['GET'])]
    public function userIndex(): Response
    {
        return $this->render('accueil/user_home.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin', name: 'app_admin', methods: ['GET'])]
    public function adminIndex(): Response
    {
        return $this->render('accueil/admin_home.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
}
