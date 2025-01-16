<?php

namespace App\Service\JWTTokenGeneratorService;

use App\Service\Interface\JWTTokenDecodeInterface as InterfaceJWTTokenDecodeInterface;

final class JWTTokenDecode implements InterfaceJWTTokenDecodeInterface
{
    public function __invoke(string $token): array
    {
        $payload = json_decode(base64_decode(explode('.', $token)[1]), true);

        return $payload;
    }
}
