<?php

namespace App\Service\JWTTokenGeneratorService;

interface CheckJWTIsValidServiceInterface
{
    public function __invoke(string $token): bool;
}
