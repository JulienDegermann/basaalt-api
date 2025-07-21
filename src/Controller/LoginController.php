<?php

namespace App\Controller;

use Exception;
use UpdatePassword;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\Interface\JWTTokenDecodeInterface;
use App\Service\Interface\UpdatePasswordInterface;
use App\Service\Interface\UserRepositoryInterface;
use App\Service\Interface\GetUserFromTokenInterface;
use App\Service\Interface\JWTTokenGeneratorServiceInterface;
use App\Service\JWTTokenGeneratorService\CheckJWTIsValidService;
use App\Service\NotifierService\PasswordRecoveryNotifierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Service\JWTTokenGeneratorService\CheckJWTIsValidServiceInterface;
use App\Service\NotifierService\SendTokenByEmailNotifierServiceInterface;

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
        private readonly UpdatePasswordInterface $updatePassword,
        private readonly CheckJWTIsValidServiceInterface $checkJWT
    ) {}

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();
        if ($user && $user instanceof User) {
            if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_SUPER_ADMIN')) {
                return $this->redirectToRoute('admin');
            }
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

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
    }

    #[Route('/mot-de-passe-oublie', name: 'app_forget_password')]
    public function forgetPassword(
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


        return $this->render('login/password_forgotten.html.twig');
    }

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
        }

        return $this->render('login/password_reset.html.twig', ['token' => $token]);
    }


    #[Route('/verification-email?token={token}', name: 'app_verify_email')]
    public function verifyEmail(
        string $token,
        Request $request
    ) {
        if (($this->checkJWT)($token)) {
            // code here
        } else {
            $this->addFlash('error', 'Lien invalide. Veuilez réessayer avec un nouveau lien.');
        }
    }
}
