<?php

namespace App\Controller;

use App\Repository\RegimeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class RegimeController extends AbstractController
{
    #[Route('/regime', name: 'app_regime')]
    public function index(RegimeRepository $regimeRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // dd($regimes);
        $regimes = $paginator->paginate(
            $regimeRepository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('regime/index.html.twig', [
            'regimes' => $regimes
        ]);
    }
}
