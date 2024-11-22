<?php

namespace App\Service\NotifierService;

use App\Entity\User;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\NotifierService\NotifierConfig;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Service\JWTTokenGeneratorService\JWTTokenGeneratorService;
use App\Service\Interface\PasswordRecoveryNotifierServiceInterface as InterfacePasswordRecoveryNotifierServiceInterface;

final class PasswordRecoveryNotifierService implements InterfacePasswordRecoveryNotifierServiceInterface
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly JWTTokenGeneratorService $JWTGenerator,
        private readonly NotifierConfig $config
    ) {}

    public function notify(User $user): string
    {
        $userName = $user->getFirstName();

        $url = $this->urlGenerator->generate('app_password_reset', ['token' => ($this->JWTGenerator)(['user_id' => $user->getId()])], UrlGeneratorInterface::ABSOLUTE_URL);
        $text = "Bonjour $userName, \n\nVous avez demandé à réinitialiser votre mot de passe. Pour cela, veuillez cliquer sur le lien ci-dessous (valide 1 heure) : ";
        $text .= "\n $url";
        $text .= $this->config->getSignature();

        $email = (new Email())
            ->from($this->config->getFrom())
            ->to($user->getEmail())
            ->subject('Réinitialisation de votre mot de passe.')
            ->text($text);


        $this->mailer->send($email);

        return "Un email de réinitialisation de mot de passe a été envoyé à l'adresse indiquée.";

    }
}
