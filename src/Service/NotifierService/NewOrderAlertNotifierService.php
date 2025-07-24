<?php

namespace App\Service\NotifierService;

use App\Entity\Order;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\Interface\NotifierConfigInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class NewOrderAlertNotifierService implements NewOrderAlertNotifierServiceInterface
{
    public function __construct(
        private readonly NotifierConfigInterface $config,
        private readonly MailerInterface $mailer,
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {}

    public function __invoke(Order $order): void
    {
        $email = new TemplatedEmail();
        $url = $this->urlGenerator->generate('admin', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $email
            ->from($this->config->getFrom())
            ->to($this->config->getFrom())
            ->subject('Nouvelle commande reçue')
            ->htmlTemplate('email/new_order_alert.html.twig')
            ->context(['url' => $url])
        ;

        $this->mailer->send($email);
    }
}
