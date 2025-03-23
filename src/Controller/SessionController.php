<?php

namespace App\Controller;

use PHPUnit\Util\Json;
use Symfony\Flex\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/session')]
final class SessionController extends AbstractController
{
    #[Route('/get', name: 'get_cart', methods: ['GET'])]
    public function getCart(
        Request $request
    ): JsonResponse {
dd('coucou');
        $session = $request->getSession();

        if (!$session->isStarted()) {
            $session->start();
        }

        $cart = json_decode($session->get('cart'));

        $response = new JsonResponse($cart);

        return $response;
    }

    #[Route('/update', name: 'update_cart')]
    public function updateCart(
        Request $request
    ): JsonResponse {
        dd('coucou');
        $session = $request->getSession();

        if (!$session->isStarted()) {
            $session->start();
        }

        $cart = $request->getContent();
        if ($cart) {
            $session->set('cart', $cart);
        }
        $session->save();
        // dd($session);
        $response = new JsonResponse(json_encode($session->get('cart')), 201, [], true);
        return $response;
    }
}
