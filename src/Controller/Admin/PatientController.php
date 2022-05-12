<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted("ROLE_ADMIN")]
#[Route('/admin')]
class PatientController extends AbstractController
{
    #[Route('/patient', name: 'app_patients', methods: ['GET'])]
    public function index(UserRepository $userRepository,
        PaginatorInterface $paginator, 
        Request $request ): Response
    {
        $patient = $paginator->paginate(
            $userRepository->findAll(),
            $request->query->getInt('page', 1), 10
        );

        return $this->render('patient/index.html.twig', [
            'patients' => $patient,
        ]);
    }

    #[Route('/patient/{id}', name: 'app_account', methods: ['GET'])]
    public function userAccount(int $id,
        UserRepository $userRepository, 
        Request $request ): Response
    {
        $patient = $userRepository->find($id);

        return $this->render('patient/patient.html.twig', [
            'patient' => $patient
        ]);
    }

    /**
     * This function allow to register
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/edition-compte-utilisateur/{id}', name: 'app_accountEdit', methods: ['GET', 'POST'])]
    public function editAccount(User $user,
        Request $request,
        EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'success', 
                'Le compte a bien été modifié !'
            );

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('security/edit_account.html.twig', [
            'registerForm' => $form->createView()
        ]);
    }

    #[Route('patient/delete/{id}', name: 'app_accountDelete', methods: ['GET'])]
    public function deleterecette(User $user,
         EntityManagerInterface $entityManager): Response
    {
        if(!$user) {
            $this->addFlash(
                'success',
                "L'utilisateur' n'a pas été trouvé"
            );
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash(
            'success', 
            "L'utilisateur' a été supprimée avec succès !"
        );

        return $this->redirectToRoute('app_patients');
    } 
}
