<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route(
        ['/{url}', '/{url}/{id}'],
        name: 'app_home',
<<<<<<< HEAD
        requirements: ['url' => '(?!(admin|api|login|logout|mot-de-passe-oublie|uploads)).*'],
=======
        requirements: ['url' => '(?!admin)(?!api)(?!login)(?!mot-de-passe-oublie)(?!modifier-le-mot-de-passe)(?!uploads).*'],
>>>>>>> develop
        defaults: ['url' => '', 'id' => '']
    )]
    public function index(): Response
    {
        return new Response(file_get_contents('index.html'));
    }
}
