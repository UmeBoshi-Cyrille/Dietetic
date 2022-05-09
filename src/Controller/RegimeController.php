<?php

namespace App\Controller;

use App\Entity\Regime;
use App\Form\RegimeType;
use App\Repository\RegimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class RegimeController extends AbstractController
{
    /**
     * This function display all Regimes
     *
     * @param RegimeRepository $regimeRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/regime', name: 'app_regime', methods: ['GET'])]
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

    /**
     * This controller create a form to add new regime
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/regime/new', name: 'app_regime.new', methods: ['GET', 'POST'])]
    public function newRegime(
        Request $request,
        EntityManagerInterface $entityManager
        ): Response
    {
        $regime = new Regime();
        $form = $this->createForm(RegimeType::class, $regime);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());
            $regime = $form->getData();

            $entityManager->persist($regime);
            $entityManager->flush();

            $this->addFlash(
                'success', 
                'Nouveau régime ajouté avec succès !'
            );

            return $this->redirectToRoute('app_regime');
        }

        return $this->render('regime/new_regime.html.twig', [
            'newRegimeForm' => $form->createView()
        ]);
    }
    
    #[Route('/regime/edit/{id}', name: 'app_regime.edit', methods: ['GET', 'POST'])]
    public function editRegime(Regime $regime, 
        Request $request,
        EntityManagerInterface $entityManager): Response
    {
        // $regime = $regimeRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(RegimeType::class, $regime);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $regime = $form->getData();

            $entityManager->persist($regime);
            $entityManager->flush();

            $this->addFlash(
                'success', 
                'Votre Régime a été modifié avec succès !'
            );

            return $this->redirectToRoute('app_regime');
        }

        return $this->render('regime/edit_regime.html.twig', [
            'editRegimeForm' => $form->createView()
        ]);
    }

    #[Route('/regime/delete/{id}', name: 'app_regime.delete', methods: ['GET'])]
    public function deleteRegime(EntityManagerInterface $entityManager,
        Regime $regime
        ) : Response
    {
        if(!$regime) {
            $this->addFlash(
                'success',
                'Le régime n\'a pas été trouvé'
            );
        }

        $entityManager->remove($regime);
        $entityManager->flush();

        $this->addFlash(
            'success', 
            'Votre Régime a été supprimé avec succès !'
        );

        return $this->redirectToRoute('app_regime');
    }
}
