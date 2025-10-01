<?php

namespace App\Tests\Entity;

use App\Entity\ArticleCommand;
use App\Entity\Stock;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ArticleCommandTest extends TestCase
{
    private ArticleCommand $articleCommand;

    public function setUp(): void
    {
        $this->articleCommand = new ArticleCommand();
    }

    /**
     * Given - a new instance of ArticleCommand
     * When - a Stock is set to ArticleCommand
     * Then - getStock returns the set Stock
     */
    public function testArticleCommandContainsOneValidStock()
    {
        $stock = new Stock();

        $this->articleCommand->setStock($stock);

        $this->assertInstanceOf(Stock::class, $this->articleCommand->getStock());
        $this->assertEquals($stock, $this->articleCommand->getStock());
    }

    /**
     * Given - a new instance of ArticleCommand
     * When - a quantity is set
     * Then - getQuantity returns the set quantity
     */
    public function testArticleCommandContainsAnIntergerAsQuantity()
    {
        $quantity = rand(1, 100);
        $this->articleCommand->setQuantity($quantity);
        $this->assertIsInt($this->articleCommand->getQuantity());
        $this->assertEquals($quantity, $this->articleCommand->getQuantity());
        $this->assertGreaterthan($quantity, $this->articleCommand->getQuantity());
    }

    /**
     * Given - a new instance of ArticleCommand
     * When - a Stock AND a quantity are set AND Stock->getQuantity() < quantity
     * Then - setQuantity() throws Exception
     */
    public function testArticleCommandQuantityCannotBeGreaterThanStockQuantity()
    {
        $stock = new Stock();
        $stock->setQuantity(5);
        $quantity = $stock->getQuantity() + 1;
        $this->expectException(InvalidArgumentException::class);
        $this->articleCommand->setStock($stock);
        $this->articleCommand->setQuantity($quantity);
    }
}

