<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
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

    #[Route('/patient/{id}', name: 'app_patient', methods: ['GET'])]
    public function userRead(int $id,
        UserRepository $userRepository, 
        Request $request ): Response
    {
        $patient = $userRepository->find($id);

        return $this->render('patient/patient.html.twig', [
            'patient' => $patient
        ]);
    }
}
