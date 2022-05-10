<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecetteController extends AbstractController
{
    /**
     * This function display the list of all recipes
     *
     * @param RecetteRepository $recetteRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/recette', name: 'app_recette', methods: ['GET'])]
    public function index(
        RecetteRepository $recetteRepository, 
        PaginatorInterface $paginator, 
        Request $request
    ): Response
    {
        $recette = $paginator->paginate(
            $recetteRepository->findAll(),
            $request->query->getInt('page', 1), 5
        );

        return $this->render('recette/index.html.twig', [
            'recettes' => $recette
        ]);
    }

    /**
    * This function create form to add new recipe
    *
    * @param Request $request
    * @param EntityManagerInterface $entityManager
    * @return Response
    */
    #[Route('/recette/new', name: 'app_recette.new', methods: ['GET', 'POST'])]
    public function newRecette(
        Request $request,
        EntityManagerInterface $entityManager
        ): Response
    {
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $recette = $form->getData();

            $entityManager->persist($recette);
            $entityManager->flush();

            $this->addFlash(
                'success', 
                'Nouvelle recette ajoutée avec succès !'
            );

            return $this->redirectToRoute('app_recette');
        }

        return $this->render('recette/new_recette.html.twig', [
            'newRecetteForm' => $form->createView()
        ]);
    }
    
    /**
     * This function create form to edit recette
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/recette/edit/{id}', name: 'app_recette.edit', methods: ['GET', 'POST'])]
    public function editrecette(Recette $recette,
        Request $request,
        EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecetteType::class, $recette);
       
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $recette = $form->getData();

            $entityManager->persist($recette);
            $entityManager->flush();

            $this->addFlash(
                'success', 
                'La recette a été modifiée avec succès !'
            );

            return $this->redirectToRoute('app_recette');
        }

        return $this->render('recette/edit_recette.html.twig', [
            'editRecetteForm' => $form->createView()
        ]);
    }
    
    #[Route('recette/delete/{id}', name: 'app_recette.delete', methods: ['GET'])]
    public function deleterecette(Recette $recette,
         EntityManagerInterface $entityManager): Response
    {
        if(!$recette) {
            $this->addFlash(
                'success',
                'La recette n\'a pas été trouvé'
            );
        }

        $entityManager->remove($recette);
        $entityManager->flush();

        $this->addFlash(
            'success', 
            'La recette a été supprimée avec succès !'
        );

        return $this->redirectToRoute('app_recette');
    } 
}