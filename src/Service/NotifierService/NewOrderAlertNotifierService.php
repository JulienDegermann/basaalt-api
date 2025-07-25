<?php

namespace App\Service\NotifierService;

use App\Entity\Order;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\Interface\NotifierConfigInterface;
use App\Service\Interface\UserRepositoryInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class NewOrderAlertNotifierService implements NewOrderAlertNotifierServiceInterface
{
    public function __construct(
        private readonly NotifierConfigInterface $config,
        private readonly MailerInterface $mailer,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly UserRepositoryInterface $repo
    ) {}

    public function __invoke(Order $order): void
    {
        $admins = $this->repo->findAdmins();
        $email = new TemplatedEmail();
        $url = $this->urlGenerator->generate('admin', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $email
            ->from($this->config->getFrom())
            ->subject('Nouvelle commande reçue')
            ->htmlTemplate('email/new_order_alert.html.twig')
            ->context(['url' => $url])
        ;

        foreach ($admins as $admin) {
            if ($admin instanceof User) {
                $email->addTo($admin->getEmail());
            }
        }

        $this->mailer->send($email);
    }
}
