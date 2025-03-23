<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
        #[Route(
                ['/', '/mon-panier', '/nos-concerts', '/contact', '/la-boutique',  '/la-boutique/{id}'],
                name: 'app_home',
                requirements: ['url' => '(?!admin)(?!api)(?!login)(?!mot-de-passe-oublie)(?!modifier-le-mot-de-passe)(?!uploads).*'],
                defaults: ['url' => '', 'id' => '']
        )]
        public function index(): Response
        {
                return new Response(file_get_contents('index.html'));
        }
}
