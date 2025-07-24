<?php

namespace App\Service\NotifierService;

use App\Entity\Order;

interface NewOrderNotifierServiceInterface
{
    public function __invoke(Order $order): void;
}
