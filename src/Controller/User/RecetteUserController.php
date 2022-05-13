<?php

namespace App\Controller\User;

use App\Entity\Recette;
use App\Repository\RecetteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecetteUserController extends AbstractController
{
    /**
     * This function display the list of all recipes
     *
     * @param RecetteRepository $recetteRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/recettes-public', name: 'app_recettesPublic', methods: ['GET'])]
    public function indexPublic(
        RecetteRepository $recetteRepository, 
        PaginatorInterface $paginator, 
        Request $request
    ): Response
    {
        $recettes = $paginator->paginate(
            $recetteRepository->findPublicRecipe(null),
            $request->query->getInt('page', 1), 10
        );

        return $this->render('recette/recettes_public.html.twig', [
            'publicRecipes' => $recettes
        ]);
    }

    /**
     * This function display the list of all recipes
     *
     * @param RecetteRepository $recetteRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[IsGranted("ROLE_USER")]
    #[Route('/utilisateur/recettes', name: 'app_recettes', methods: ['GET'])]
    public function index(
        RecetteRepository $recetteRepository, 
        PaginatorInterface $paginator, 
        Request $request
    ): Response
    {
        $recettes = $paginator->paginate(
            $recetteRepository->findAll(),
            $request->query->getInt('page', 1), 5
        );

        return $this->render('recette/recettes.html.twig', [
            'recipes' => $recettes
        ]);
    }

    #[Route('/utilisateur/recette/{id}', name: 'app_recette', methods: ['GET'])]
    public function userRecipe(Recette $recette
    ): Response
    {
        return $this->render('recette/recette.html.twig', [
            'recipe' => $recette
        ]);
    }
}
