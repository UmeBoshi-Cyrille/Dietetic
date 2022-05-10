<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{
    /**
     * This function display all ingredient
     *
     * @param IngredientRepository $ingredientRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/ingredient', name: 'app_ingredient', methods: ['GET'])]
    public function index(
        IngredientRepository $ingredientRepository, 
        PaginatorInterface $paginator, 
        Request $request
    ): Response
    {
        $ingredient = $paginator->paginate(
            $ingredientRepository->findAll(),
            $request->query->getInt('page', 1), 10
        );

        return $this->render('ingredient/index.html.twig', [
            'ingredients' => $ingredient
        ]);
    }

    /**
     * This function create form to add new ingredient
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/ingredient/new', name: 'app_ingredient.new', methods: ['GET', 'POST'])]
    public function newIngredient(
        Request $request,
        EntityManagerInterface $entityManager
        ): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();

            $entityManager->persist($ingredient);
            $entityManager->flush();

            $this->addFlash(
                'success', 
                'Nouveau allergène ajouté avec succès !'
            );

            return $this->redirectToRoute('app_ingredient');
        }

        return $this->render('ingredient/new_ingredient.html.twig', [
            'newIngredientForm' => $form->createView()
        ]);
    }
    
    /**
     * This function create form to edit Ingredient
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/ingredient/edit/{id}', name: 'app_ingredient.edit', methods: ['GET', 'POST'])]
    public function editIngredient(Ingredient $ingredient,
        Request $request,
        EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IngredientType::class, $ingredient);
       
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();

            $entityManager->persist($ingredient);
            $entityManager->flush();

            $this->addFlash(
                'success', 
                'L\'ingrédient a été modifié avec succès !'
            );

            return $this->redirectToRoute('app_ingredient');
        }

        return $this->render('ingredient/edit_ingredient.html.twig', [
            'editIngredientForm' => $form->createView()
        ]);
    }
    
    #[Route('ingredient/delete/{id}', name: 'app_ingredient.delete', methods: ['GET'])]
    public function deleteIngredient(Ingredient $ingredient,
         EntityManagerInterface $entityManager): Response
    {
        if(!$ingredient) {
            $this->addFlash(
                'success',
                'L\'ingrédient n\'a pas été trouvé'
            );
        }

        $entityManager->remove($ingredient);
        $entityManager->flush();

        $this->addFlash(
            'success', 
            'L\'ingrédient a été supprimé avec succès !'
        );

        return $this->redirectToRoute('app_ingredient');
    }   
}
