<?php

namespace App\Service\NotifierService;

use App\Entity\User;
use ApiPlatform\Api\UrlGeneratorInterface;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\Interface\UserRepositoryInterface;
use App\Service\Interface\JWTTokenGeneratorServiceInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

final class SendTokenByEmailNotifierService implements SendTokenByEmailNotifierServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepo,
        private readonly JWTTokenGeneratorServiceInterface $jwtService,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly string $mailerDNS,
        private readonly MailerInterface $mailer
    ) {}


    public function __invoke(string $email): string
    {
        $user = $this->userRepo->findOneBy(['email' => $email]);

        if ($user instanceof User) {
            // create a token and its URL
            $token = ($this->jwtService)(['id' => $user->getId()]);
            $url = $this->urlGenerator->generate('app_password_reset', ['token' => $token], UrlGeneratorInterface::ABS_URL);

            // send email
            $userName = $user->getFirstName();
            $notifier = new TemplatedEmail();
            $notifier
                ->from($this->mailerDNS)
                ->to($email)
                ->subject('Réinitialisation de votre mot de passe')
                ->context([
                    'url' => $url,
                    'user' => $user
                ])
                ->htmlTemplate('email/password_recovery.html.twig')
                ->text("Bonjour $userName, \n\n Vous avez demandé à réinitialiser votre mot de passe. Veuillez cliquer sur le lien ci-dessous : \n $url.
                \n\n Basaalt - Team Support");

            ($this->mailer)->send($notifier);
        }

        return 'Un e-mail a été envoyé à l\'adresse indiquée.';
    }
}
