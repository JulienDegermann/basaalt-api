<?php

namespace App\Service\NotifierService;

use App\Service\Interface\NotifierConfigInterface;

class NotifierConfig implements NotifierConfigInterface
{
    private string $from;

    private string $signature;

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }

    public function __construct()
    {
        $this->from = $_ENV['MAILER_DNS_ADDRESS'];
        $this->signature = "\n \n Julien, Équipe de Développement.";
    }
}