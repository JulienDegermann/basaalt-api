<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route(
        ['/', '/mon-panier', '/nos-concerts', '/contact','/la-boutique',  '/la-boutique/{id}'],
        name: 'app_home',
        defaults: ['id' => '']
    )]
    public function index(): Response
    {
        return new Response(file_get_contents('index.html'));
    }
}
