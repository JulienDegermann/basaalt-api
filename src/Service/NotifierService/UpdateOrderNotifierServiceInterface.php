<?php

namespace App\Service\NotifierService;

use App\Entity\Order;

interface UpdateOrderNotifierServiceInterface
{
    public function __invoke(Order $order): void;
}
