<?php

namespace App\Service\NotifierService;

use App\Entity\User;
use InvalidArgumentException;
use App\Service\Interface\JWTTokenDecodeInterface;
use App\Service\Interface\UserRepositoryInterface;
use App\Service\Interface\GetUserFromTokenInterface;

final class GetUserFromToken implements GetUserFromTokenInterface
{
    public function __construct(
        private readonly JWTTokenDecodeInterface $JWTDecoder,
        private readonly UserRepositoryInterface $userRepo,
    ) {}

    public function __invoke(string $token): User
    {
        $userId = ($this->JWTDecoder)($token)['id'];

        $user = $this->userRepo->find($userId);
        if (!$user || !($user instanceof User)) {
            throw new InvalidArgumentException('Utilisateur introuvable');
        }

        return $user;
    }
}
