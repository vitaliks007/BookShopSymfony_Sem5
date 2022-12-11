<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    #[Route('/auth/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/auth/registration', name: 'app_registration')]
    public function registration(): Response
    {
        return $this->render('auth/registration.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/auth/register', name: 'app_register')]
    public function register(Request $request, ManagerRegistry $doctrine,
                             UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager = $doctrine->getManager();

        $user = new \App\Entity\User();
        $user->setBirthday(date_create_from_format("d.m.Y", $request->request->get('birthday')));
        $user->setEmail($request->request->get('email'));
        $user->setName($request->request->get('name'));
        $user->setPhone($request->request->get('phone'));
        $user->setRoles(['ROLE_USER']);
        $user->setSurname($request->request->get('surname'));
        $user->setUsername($request->request->get('username'));

        $user->setPassword($passwordHasher->hashPassword($user, $request->request->get('password')));

        $entityManager->persist($user);
        $entityManager->flush();
        return $this->render('auth/registration.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/auth/logout', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
