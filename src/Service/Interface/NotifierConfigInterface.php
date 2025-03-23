<?php

namespace App\Service\Interface;

interface NotifierConfigInterface
{
    public function getSignature(): string;

    public function getFrom(): string;
}