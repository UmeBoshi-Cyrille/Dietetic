<?php

namespace App\Controller\User;

use App\Entity\Mark;
use App\Entity\Recette;
use App\Form\MarkType;
use App\Repository\MarkRepository;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/recette/{id}', name: 'app_recettePublic', methods: ['GET'])]
    public function publicRecipe(Recette $recette
        ): Response
    {
        return $this->render('recette/recette_public.html.twig', [
            'publicRecipe' => $recette
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

    #[IsGranted("ROLE_USER")]
    #[Route('/utilisateur/recette/{id}', name: 'app_recette', methods: ['GET', 'POST'])]
    public function userRecipe(Recette $recette,
        Request $request,
        MarkRepository $markRepository,
        EntityManagerInterface $entityManager
        ): Response
    {
        $mark = new Mark();
        $form = $this->createForm(MarkType::class, $mark);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $mark->setUser($this->getUser())
                ->setRecipe($recette);

            $existingMark = $markRepository->findOneBy([
                'user' => $this->getUser(),
                'recipe' => $recette
            ]);

            if(!$existingMark) {
                $entityManager->persist($mark);
            } else {
                $existingMark->setMark(
                    $form->getData()->getMark()
                );
            }
            
            $entityManager->flush();

            $this->addFlash(
                'success', 
                'Note enregistr??e'
            );

            return $this->redirectToRoute('app_recette', ['id' => $recette->getId()]);
        }

        return $this->render('recette/recette.html.twig', [
            'recipe' => $recette,
            'markForm' => $form->createView()
        ]);
    }
}
