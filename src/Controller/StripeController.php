<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\StripeClient;

#[Route('/stripe')]
class StripeController extends AbstractController
{
    #[Route('/checkout', name: 'stripe_checkout', methods: ['POST'])]
    public function createCheckoutSession(
        Request $request
    ): Response {

        $cart = json_decode($request->getContent(), true);


        $checkout_session = Session::create([
            'line_items' => [[
                'price' => '{{PRICE_ID}}',
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'http://localhost:8000/success.html',
            'cancel_url' => 'http://localhost:8000/cancel.html',
        ]);

        header("HTTP/1.1 303 See Other");
        return header("Location: " . $checkout_session->url); 
    }
}
