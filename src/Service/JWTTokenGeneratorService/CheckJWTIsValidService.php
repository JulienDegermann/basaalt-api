<?php

namespace App\Service\JWTTokenGeneratorService;

use App\Service\Interface\JWTTokenDecodeInterface;
use App\Service\JWTTokenGeneratorService\CheckJWTIsValidServiceInterface;
use DateTimeImmutable;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Throwable;

final class CheckJWTIsValidService implements CheckJWTIsValidServiceInterface
{

    public function __construct(
        private readonly JWTTokenDecodeInterface $decoder,
        private readonly LoggerInterface $logger
    ) {}

    public function __invoke(string $token): bool
    {
        try {
            $payload = ($this->decoder)($token);

            if (!isset($payload['iat']) || !isset($payload['exp'])) {
                throw new InvalidArgumentException('La date du token est invalide.');
            }

            $iat = $payload['iat'];
            $exp = $payload['exp'];
            $now = (new DateTimeImmutable())->getTimestamp();

            return $iat <= $now && $now <= $exp;
        } catch (Throwable $e) {
            $this->logger->error('ERROR JWT : ' . $e->getMessage());
            throw new InvalidArgumentException('Une erreur est survenue. Veuillez réessayer ultérieurement.');
        }
    }
}
