<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\UserPasswordType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted("ROLE_USER", "ROLE_ADMIN")]
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
    #[Route('/profil/edition/{id}', name: 'app_profil-edit', methods: ['GET', 'POST'])]
    public function userEdit(User $user,
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $hasher): Response
    {
        if(!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if($this->getUser() !== $user) {
            return $this->redirectToRoute('app_accueil');
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            if($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())) {
                $user = $form->getData();

                $entityManager->persist($user);
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

        return $this->render('user/edit.html.twig', [
            'profilForm' => $form->createView()
        ]);
    }

    /**
     * This function allow user to modify his id and password
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordHasherInterface $hasher
     * @return Response
     */
    #[Route('/profil/edition-mot-de-passe/{id}', name: 'app_password', methods: ['GET', 'POST'])]
    public function userEditLogin(User $user,
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $hasher): Response
    {
        if(!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if($this->getUser() !== $user) {
            return $this->redirectToRoute('app_accueil');
        }

        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            if($hasher->isPasswordValid($user, $form->getData()['plainPassword'])) {
                $user->setPassword(
                    $hasher->hashPassword(
                        $user,
                        $form->getData()['newPassword']
                    )
                );

                $entityManager->persist($user);
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
