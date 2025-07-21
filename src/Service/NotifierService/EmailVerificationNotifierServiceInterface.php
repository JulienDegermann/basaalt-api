<?php

namespace App\Service\NotifierService;

use App\Entity\User;


interface EmailVerificationNotifierServiceInterface {
    public function __invoke(User $user): void;
}