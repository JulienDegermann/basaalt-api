<?php

namespace App\Service\Interface;

interface UpdatePasswordInterface
{
    public function __invoke(string $token, string $newPassword): string;
}