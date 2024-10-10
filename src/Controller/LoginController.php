<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\JWTService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();
        if ($user && $user instanceof User) {
            dd($user);

            return $this->redirectToRoute('admin');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render("login/index.html.twig", [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[\Symfony\Component\Routing\Annotation\Route('/logout', name: 'app_logout')]
    public function logout()
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/mot-de-passe-oublie', name: 'app_forget_password')]
    public function forgetPassword(
        Request        $request,
        UserRepository $repo,
        JWTService     $jwtService
    )
    {
        $email = $request->request->get('_username');
//        dd($request->request->get('_username'));
        $user = $repo->findOneBy(['email' => $email]);

        if ($user && $user instanceof User) {
            $header = [
                'alg' => 'HS256',
                'typ' => 'JWT',
            ];

            $payload = ['userId' => $user->getId()];
            $token = $jwtService->generate(
                $header,
                $payload,
                $this->getParameter('app.jwtsecret')
            );

            if ($token) {
                return $this->redirectToRoute('app_password_reset', ['token' => $token]);
            }
            dd($token);
        }

        dd($user);

        return $this->render('login/password_forgotten.html.twig');
    }

    #[Route('/modifier-le-mot-de-passe/{token}', name: 'app_password_reset')]
    public function resetPassword(
        $token,
        Request $request,
        JWTService $jwtService,
        UserRepository $repo,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $em
    )
    {
        if ($jwtService->isExpired($token)) {
            dd('token expiré');
        }
        $user = $repo->findOneBy(['id' => $jwtService->getPayload($token)['userId']]);
//        dd($user);
//
//        dd($request);
        $newPassword = $request->request['newPassword'];

        dd($newPassword);
        if ($newPassword) {
            $hashed = $hasher->hashPassword($user, $newPassword);
            $user->setPassword($hashed);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('login/password_reset.html.twig', ['token' => $token]);
    }
}