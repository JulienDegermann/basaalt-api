<?php

namespace App\Service\NotifierService;

use App\Entity\User;

interface SendTokenByEmailNotifierServiceInterface {
    public function __invoke(string $email): string;
}