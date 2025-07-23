<?php

namespace App\Service\SetEmailAsVerified;

interface SetEmailAsVerifiedInterface
{
    public function __invoke(string $token): string;
}
