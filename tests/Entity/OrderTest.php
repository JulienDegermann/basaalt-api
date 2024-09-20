<?php

namespace App\Tests\Entity;

use App\Entity\ArticleCommand;
use App\Entity\Order;
use Doctrine\Common\Collections\Collection;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    private Order $order;

    public function setUp(): void
    {
        $this->order = new Order();
    }

    /**
     * Given - a new instance of Order
     * When - an ArticleCommand is added
     * Then - getArticleCommands returns a Collection which only contains the ArticleCommand
     */
    public function testThatAnArticleCommandCanBeAddedToAnOrder(): void
    {
        $articleCommand = new ArticleCommand();

        $this->order->addArticleCommand($articleCommand);

        $this->assertInstanceOf(Collection::class, $this->order->getArticleCommands());
        $this->assertCount(1, $this->order->getArticleCommands());
        $this->assertInstanceOf(ArticleCommand::class, $this->order->getArticleCommands()[0]);
        $this->assertContains($articleCommand, $this->order->getArticleCommands());
        $this->assertSame($articleCommand, $this->order->getArticleCommands()[0]);
    }

    /**
     * Given - a new instance of Order
     * When - an ArticleCommand is added
     * Then - getArticleCommands returns a Collection which contains all added ArticleCommands
     */
    public function testThatSeveralArticleCommandsCanBePushedInAnOrder(): void
    {
        $articleCommands = [];
        for ($i = 0; $i < 10; $i++) {
            $articleCommand = new ArticleCommand();
            $this->order->addArticleCommand($articleCommand);
            $articleCommands[$i] = $articleCommand;
        }

        $this->assertCount(count($articleCommands), $this->order->getArticleCommands());
        foreach ($articleCommands as $key => $articleCommand) {
            $this->assertSame($articleCommand, $this->order->getArticleCommands()[$key]);
        }
    }

    /**
     * Given - an instance of Order containing several ArtcileCommands
     * When - an ArticleCommand is removed
     * Then - getArticleCommands returns a Collection which doesn't contain the removed ArticleCommand
     */
    public function testThatAnArticleCommandCanBeRemovedFromAnOrder(): void
    {
        $articleCommands = [];
        for ($i = 0; $i < 10; $i++) {
            $articleCommand = new ArticleCommand();
            $this->order->addArticleCommand($articleCommand);
            $articleCommands[$i] = $articleCommand;
        }
        $i = rand(0, count($articleCommands) - 1);

        $this->order->removeArticleCommand($this->order->getArticleCommands()[$i]);
        $this->assertNotContains($articleCommands[$i], $this->order->getArticleCommands());
    }


    /**
     * Given - an instance of Order
     * When - a valid status is set
     * Then - getSTatus returns status
     */
    public function testThatValidStatusCanBeSet()
    {
        $allowedStatuses = [
            'saved',
            'paymentValid',
            'paymentNotValid',
            'send',
            'recieved',
            'back'
        ];

        foreach ($allowedStatuses as $status) {
            $this->order->setStatus($status);
            $this->assertEquals($status, $this->order->getStatus());
        }
    }

    /**
     * Given - an instance of Order
     * When - a non-valid status is set
     * Then - setSTatus returns InvalidArgumentException
     */
    public function testThatNotValidStatusThrowsAnException()
    {
        $allowedStatuses = [
            'solved',
            'test',
            'payée',
            'bonjour',
            'run',
            'backed'
        ];

        foreach ($allowedStatuses as $status) {
            $this->expectException(InvalidArgumentException::class);
            $this->order->setStatus($status);
        }
    }
}
