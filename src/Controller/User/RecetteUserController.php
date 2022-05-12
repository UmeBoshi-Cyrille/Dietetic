<?php

namespace App\Controller\User;

use App\Repository\RecetteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    #[Route('/recette', name: 'app_recettes.user', methods: ['GET'])]
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

        return $this->render('user/index.html.twig', [
            'user_recipes' => $recettes
        ]);
    }

    #[Route('/recette/{id}', name: 'app_recette.user', methods: ['GET'])]
    public function userRecipe(int $id,
        RecetteRepository $recetteRepository
    ): Response
    {

        $recette = $recetteRepository->find($id);
        // $studentSections = $sectionsRepository-

        return $this->render('user/recipe.html.twig', [
            'user_recipe' => $recette
        ]);
    }
}
