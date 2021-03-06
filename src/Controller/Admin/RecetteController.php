<?php

namespace App\Controller\Admin;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted("ROLE_ADMIN")]
#[Route('/admin')]
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
    #[Route('/recettes', name: 'app_recettesAdmin', methods: ['GET'])]
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

        return $this->render('recette/adminIndex.html.twig', [
            'recettesAdmin' => $recette
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
                'Nouvelle recette ajout??e avec succ??s !'
            );

            return $this->redirectToRoute('app_recettesAdmin');
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
    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/recette/edit/{id}', name: 'app_recetteEdit', methods: ['GET', 'POST'])]
    public function editRecette(Recette $recette,
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
                'La recette a ??t?? modifi??e avec succ??s !'
            );

            return $this->redirectToRoute('app_recettesAdmin');
        }

        return $this->render('recette/edit_recette.html.twig', [
            'editRecetteForm' => $form->createView()
        ]);
    }
    
    #[Route('recette/delete/{id}', name: 'app_recetteDelete', methods: ['GET'])]
    public function deleteRecette(Recette $recette,
         EntityManagerInterface $entityManager): Response
    {
        if(!$recette) {
            $this->addFlash(
                'success',
                'La recette n\'a pas ??t?? trouv??'
            );
        }

        $entityManager->remove($recette);
        $entityManager->flush();

        $this->addFlash(
            'success', 
            'La recette a ??t?? supprim??e avec succ??s !'
        );

        return $this->redirectToRoute('app_recettesAdmin');
    } 
}