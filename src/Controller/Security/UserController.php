<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\UserPasswordType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted("ROLE_USER")]
#[Route('/utilisateur')]
class UserController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function profil(): Response
    {
        return $this->render('user/profil.html.twig');
    }

    /**
     * This function allow user to modify his profil
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Security("is_granted('ROLE_USER') and user === currentUser")]
    #[Route('/profil/edition/{id}', name: 'app_profilEdit', methods: ['GET', 'POST'])]
    public function userEdit(User $currentUser,
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $hasher): Response
    {
        if(!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if($this->getUser() !== $currentUser) {
            return $this->redirectToRoute('app_user');
        }

        $form = $this->createForm(UserType::class, $currentUser);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            if($hasher->isPasswordValid($currentUser, $form->getData()->getPlainPassword())) {
                $currentUser = $form->getData();

                $entityManager->persist($currentUser);
                $entityManager->flush();

                $this->addFlash(
                    'success', 
                    'Votre profil utilisateur a bien été modifié !'
                );

                return $this->redirectToRoute('app_user');
            }

            $this->addFlash(
                'warning', 
                'Le mot de passe renseigné est incorrect !'
            );
        }

        return $this->render('user/edit_profil.html.twig', [
            'profilForm' => $form->createView()
        ]);
    }

    /**
     * This function allow user to modify his password
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordHasherInterface $hasher
     * @return Response
     */
    #[Security("is_granted('ROLE_USER') and user === currentUser")]
    #[Route('/profil/edition-mot-de-passe/{id}', name: 'app_password', methods: ['GET', 'POST'])]
    public function userEditLogin(User $currentUser,
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $hasher): Response
    {
        if(!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if($this->getUser() !== $currentUser) {
            return $this->redirectToRoute('app_accueil');
        }

        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            if($hasher->isPasswordValid($currentUser, $form->getData()['plainPassword'])) {
                $currentUser->setUpdatedAt(new \DateTimeImmutable());
                $currentUser->setPlainPassword(
                    $form->getData()['newPassword']
                );

                $entityManager->persist($currentUser);
                $entityManager->flush();

                $this->addFlash(
                    'success', 
                    'Votre mot de passe a été modifié avec succès!'
                );

                return $this->redirectToRoute('app_user');
            }else {
                $this->addFlash(
                    'warning', 
                    'Le mot de passe renseigné est incorrect !'
                );
            }
        }

        return $this->render('user/edit_password.html.twig', [
            'passwordForm' => $form->createView()
        ]);
    }

}
