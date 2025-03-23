<?php

namespace App\Service\Interface;

use App\Entity\User;
use Symfony\Component\Mime\Email;

interface PasswordRecoveryNotifierServiceInterface
{
    public function notify(User $user): string;
}