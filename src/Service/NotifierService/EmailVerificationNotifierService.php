<?php

namespace App\Service\NotifierService;

use App\Entity\User;
use Twig\Error\Error;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use ApiPlatform\Metadata\UrlGeneratorInterface;
use App\Service\Interface\NotifierConfigInterface;
use App\Service\Interface\JWTTokenGeneratorServiceInterface;
use Throwable;

final class EmailVerificationNotifierService implements EmailVerificationNotifierServiceInterface
{
    public function __construct(
        private readonly NotifierConfigInterface $notifierConfig,
        private readonly MailerInterface $mailer,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly JWTTokenGeneratorServiceInterface $JWTGenerator
    ) {}


    public function __invoke(User $user): void
    {
        try {
            $email = new TemplatedEmail();
            $url = $this->urlGenerator->generate('app_verify_email', ['token' => ($this->JWTGenerator)(['user_id' => $user->getId()])], UrlGeneratorInterface::ABS_PATH);
            $email
                ->from($this->notifierConfig->getFrom())
                ->to($user->getEmail())
                ->subject('Basaalt : confirmation d\'email')
                ->htmlTemplate('email/email_verification.html.twig')
                ->context(
                    [
                        'user' => $user,
                        'url' => $url
                    ]
                );
            $this->mailer->send($email);
        } catch (Throwable $e) {
            dd($e);
        }
    }
}
