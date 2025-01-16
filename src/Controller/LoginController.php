<?php

namespace App\Controller;

<<<<<<< HEAD
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
=======
use Exception;
use App\Entity\User;
use App\Service\Interface\GetUserFromTokenInterface;
use App\Service\Interface\JWTTokenDecodeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\Interface\UserRepositoryInterface;
use App\Service\Interface\JWTTokenGeneratorServiceInterface;
use App\Service\Interface\UpdatePasswordInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Service\NotifierService\PasswordRecoveryNotifierService;
use App\Service\NotifierService\SendTokenByEmailNotifierServiceInterface;
use UpdatePassword;

class LoginController extends AbstractController
{
    public function __construct(
        private readonly JWTTokenGeneratorServiceInterface $jwtService,
        private readonly PasswordRecoveryNotifierService $passwordRecoveryNotifierService,
        private readonly UserRepositoryInterface $userRepo,
        private readonly UserRepositoryInterface $repo,
        private readonly SendTokenByEmailNotifierServiceInterface $sendToken,
        private readonly JWTTokenDecodeInterface $JWTTokenDecode,
        private readonly GetUserFromTokenInterface $getUserFromToken,
        private readonly UpdatePasswordInterface $updatePassword
    ) {}

>>>>>>> develop
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();
        if ($user && $user instanceof User) {
<<<<<<< HEAD
            dd($user);

            return $this->redirectToRoute('admin');
        }
=======
            if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_SUPER_ADMIN')) {
                return $this->redirectToRoute('admin');
            }
            return $this->redirectToRoute('home');
        }

>>>>>>> develop
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

<<<<<<< HEAD
        return $this->render("login/index.html.twig", [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[\Symfony\Component\Routing\Annotation\Route('/logout', name: 'app_logout')]
    public function logout()
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
=======
        if ($error != '' || $error !== null) {
            $this->addFlash('danger', 'Identifiants incorrects');
        }

        return $this->render("login/index.html.twig", [
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
>>>>>>> develop
    }

    #[Route('/mot-de-passe-oublie', name: 'app_forget_password')]
    public function forgetPassword(
<<<<<<< HEAD
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
=======
        Request        $request
    ) {
        $email = $request->request->get('_email');

        try {
            if ($email) {
                $sendToken = ($this->sendToken)($email);

                $this->addFlash('success', $sendToken);
                return $this->redirectToRoute('app_login');
            }
        } catch (Exception $e) {
            $this->addFlash('error', $e->getMessage());
        }

>>>>>>> develop

        return $this->render('login/password_forgotten.html.twig');
    }

<<<<<<< HEAD
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
=======
    #[Route('/modifier-le-mot-de-passe?token={token}', name: 'app_password_reset')]
    public function resetPassword(
        string $token,
        Request $request
    ) {
        try {
            if ($request && $request->isMethod('POST') && $request instanceof Request) {
                $newPassword = $request->request->get('password');

                $response = ($this->updatePassword)($token, $newPassword);

                $this->addFlash('success', $response);
                return $this->redirectToRoute('app_login');
            }
        } catch (Exception $e) {
            $this->addFlash('error', $e->getMessage());
            dd($e->getMessage());
>>>>>>> develop
        }

        return $this->render('login/password_reset.html.twig', ['token' => $token]);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> develop
