<?php

namespace App\Service\NotifierService;

use App\Entity\Order;

interface NewOrderAlertNotifierServiceInterface
{
    public function __invoke(Order $order): void;
}