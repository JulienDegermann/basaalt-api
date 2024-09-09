<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    #[Route(
        ['/{url}', '/{url}/{id}'],
        name: 'app_home',
        requirements: ['url' => '(?!admin).*'], 
        defaults: ['url' => '', 'id' => '']
    )]
    public function index(): Response {

        return new Response(file_get_contents('index.html'));
    }
}
