<?php

namespace App\Service\SetEmailAsVerified;

use Throwable;
use Psr\Log\LoggerInterface;
use InvalidArgumentException;
use App\Service\Interface\JWTTokenDecodeInterface;
use App\Service\Interface\UserRepositoryInterface;

final class SetEmailAsVerified implements SetEmailAsVerifiedInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $repo,
        private readonly JWTTokenDecodeInterface $decoder,
        private readonly LoggerInterface $logger
    ) {}

    public function __invoke(string $token): string
    {
        try {
            $user_id = ($this->decoder)($token)['user_id'];

            $user = $this->repo->find($user_id) ?? null;

            if (!$user) {
                throw new InvalidArgumentException('Le token est invalide. Veuillez réessayer.');
            }

            $user->setIsValid(true);
            $this->repo->save($user);

            return 'Votre e-mail a été vérifié.';
        } catch (Throwable $e) {
            $this->logger->error('ERROR : ' . $e->getMessage());
            return 'Une erreur est survenue';
        }
    }
}
