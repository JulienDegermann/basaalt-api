<?php

namespace App\Service\NotifierService;

use App\Entity\Order;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\Interface\NotifierConfigInterface;
use App\Service\NotifierService\NewOrderNotifierServiceInterface;

final class NewOrderNotifierService implements NewOrderNotifierServiceInterface
{
    public function __construct(
        private readonly NotifierConfigInterface $config,
        private readonly MailerInterface $mailer,
    ) {}

    public function __invoke(Order $order): void
    {
        $email = new TemplatedEmail();
        $email
            ->from($this->config->getFrom())
            ->to($order->getBuyer()->getEmail())
            ->subject('Confirmation de votre commande')
            ->htmlTemplate('email/new_order.html.twig')
            ->context([
                'order' => $order,
                'buyer' => $order->getBuyer()
            ]);

        $this->mailer->send($email);
    }
}
