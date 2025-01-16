<?php

namespace App\Service\Interface;

interface JWTTokenDecodeInterface
{
    public function __invoke(string $token): array;
}