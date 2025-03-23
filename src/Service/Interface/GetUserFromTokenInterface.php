<?php

namespace App\Service\Interface;

use App\Entity\User;

interface GetUserFromTokenInterface
{
    public function __invoke(string $token): User;
}
