<?php

namespace App\Service\Interface;

interface JWTTokenGeneratorServiceInterface
{
    public function __invoke(array $datas): string;
}