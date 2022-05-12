<?php

namespace App\Controller\Admin;

use App\Entity\Allergene;
use App\Form\AllergeneType;
use App\Repository\AllergeneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted("ROLE_ADMIN")]
#[Route('/admin')]
class AllergeneController extends AbstractController
{
    /**
     * This function display all allergenes
     *
     * @param AllergeneRepository $allergeneRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/allergene', name: 'app_allergene', methods: ['GET'])]
    public function index(
        AllergeneRepository $allergeneRepository, 
        PaginatorInterface $paginator, 
        Request $request): Response
    {
        $allergene = $paginator->paginate(
            $allergeneRepository->findAll(),
            $request->query->getInt('page', 1), 5
        );

        return $this->render('allergene/index.html.twig', [
            'allergenes' => $allergene
        ]);
    }

    /**
     * This function create form to add new Allergene
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/allergene/new', name: 'app_allergene.new', methods: ['GET', 'POST'])]
    public function newAllergene(
        Request $request,
        EntityManagerInterface $entityManager
        ): Response
    {
        $allergene = new Allergene();
        $form = $this->createForm(AllergeneType::class, $allergene);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $allergene = $form->getData();

            $entityManager->persist($allergene);
            $entityManager->flush();

            $this->addFlash(
                'success', 
                'Nouveau allergène ajouté avec succès !'
            );

            return $this->redirectToRoute('app_allergene');
        }

        return $this->render('allergene/new_allergene.html.twig', [
            'newAllergeneForm' => $form->createView()
        ]);
    }
    
    /**
     * This function create form to edit Allergene
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/allergene/edit/{id}', name: 'app_allergene.edit', methods: ['GET', 'POST'])]
    public function editAllergene(Allergene $allergene,
        Request $request,
        EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AllergeneType::class, $allergene);
       
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $allergene = $form->getData();

            $entityManager->persist($allergene);
            $entityManager->flush();

            $this->addFlash(
                'success', 
                'L\'allergène a été modifié avec succès !'
            );

            return $this->redirectToRoute('app_allergene');
        }

        return $this->render('allergene/edit_allergene.html.twig', [
            'editAllergeneForm' => $form->createView()
        ]);
    }
    
    #[Route('allergene/delete/{id}', name: 'app_allergene.delete', methods: ['GET'])]
    public function deleteAllergene(Allergene $allergene,
         EntityManagerInterface $entityManager): Response
    {
        if(!$allergene) {
            $this->addFlash(
                'success',
                'L\'allergène n\'a pas été trouvé'
            );
        }

        $entityManager->remove($allergene);
        $entityManager->flush();

        $this->addFlash(
            'success', 
            'L\'allergène a été supprimé avec succès !'
        );

        return $this->redirectToRoute('app_allergene');
    }   
}