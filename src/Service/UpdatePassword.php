<?php

namespace App\Service;

use App\Service\Interface\UpdatePasswordInterface;
use App\Service\Interface\UserRepositoryInterface;
use App\Service\Interface\GetUserFromTokenInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UpdatePassword implements UpdatePasswordInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepo,
        private readonly GetUserFromTokenInterface $getUserFromToken,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {}

    public function __invoke(string $token, string $newPassword): string
    {
        $user = ($this->getUserFromToken)($token);
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $newPassword)
        );
        $this->userRepo->save($user);

        return 'Le mot de passe a été mis à jour avec succès.';
    }
}
