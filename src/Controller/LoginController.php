<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils)
    {
        dd('connexion');

        $this->render("login/login.html.twig", []);
    }

    #[Route('/mot-de-passe-oublie', name: 'app_forget_password')]
    public function forgetPassword()
    {
        dd('password forgotten');
    }

    #[Route('/mot-de-passe-oublié/{token}', name: 'app_password_reset')]
    public function resetPassword()
    {
        dd('password reset');
    }
}