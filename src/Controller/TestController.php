<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/contact', name: 'app_test')]
    public function index(): Response
    {
        return new Response(file_get_contents('/public/dist/index.html'));
        // return new Response(file_get_contents('../../reactApp/index.html'));
    }
}