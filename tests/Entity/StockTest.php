<?php

namespace App\Tests\Entity;

use App\Entity\Stock;
use PHPUnit\Framework\TestCase;

class StockTest extends TestCase
{
    private Stock $stock;

    public function setup(): void
    {
        $this->stock = new Stock();
    }

    /**
     * Given - a new instance of Stock
     * When - a quantity is set with an integer
     * Then - getQuantity returns quantity
     */
    public function testThatAQuantityCanBeSet()
    {
//        $quantity = rand(0, 100);
        $quantity = 0;
        $this->stock->setQuantity($quantity);

        $this->assertEquals($quantity, $this->stock->getQuantity());
    }
}