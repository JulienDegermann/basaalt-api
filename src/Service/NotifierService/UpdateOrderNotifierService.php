<?php

namespace App\Service\NotifierService;

use App\Entity\Order;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\Interface\NotifierConfigInterface;
use App\Service\NotifierService\UpdateOrderNotifierServiceInterface;

final class UpdateOrderNotifierService implements UpdateOrderNotifierServiceInterface
{
    public function __construct(
        private readonly NotifierConfigInterface $config,
        private readonly MailerInterface $mailer,
    ) {}

    public function __invoke(Order $order): void
    {
        $status_list = [
            'saved' => 'Sauvegardée',
            'paymentValid' => 'Paiement réglé',
            'paymentNotValid' => 'Paiement bloqué',
            'send' => 'Commande expédiée',
            'recieved' => 'Commande reçue',
            'back' => 'Commande retournée',
        ];

        $status = $order->getStatus() ? array_find($status_list, function ($value, $key) use ($order) {
            return $key === $order->getStatus();
        }) : null;


        $email = new TemplatedEmail();
        $email
            ->from($this->config->getFrom())
            ->to($order->getBuyer()->getEmail())
            ->subject('Mise à jour de votre commande')
            ->htmlTemplate('email/update_order.html.twig')
            ->context([
                'order' => $order,
                'status' => $status,
            ]);

        $this->mailer->send($email);
    }
}
