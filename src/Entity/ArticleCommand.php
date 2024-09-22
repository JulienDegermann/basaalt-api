<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\StockRepository;
use App\Traits\DateEntityTrait;
use App\Traits\QuantityTrait;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: StockRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:stocks', 'read:stock', 'read:orders', 'read:order']],
    denormalizationContext: ['groups' => ['write:orders', 'write:order']],
    operations: [
        new Get(normalizationContext: ['groups' => 'articleCommand:item']),
        new GetCollection(normalizationContext: ['groups' => 'articleCommand:list']),
    ],
    paginationEnabled: false,
)]
class ArticleCommand
{
    use DateEntityTrait;
    use QuantityTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:orders', 'read:order', 'read:date'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: "articleCommands")]
    private ?Stock $stock = null;

    #[ORM\ManyToOne(inversedBy: "articleCommands")]
    private ?Order $order;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(Stock $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function setOrder(?Order $order): static
    {
        $this->order = $order;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function __toString(): string
    {
        return $this->getStock()->getArticle()->getName() . ' (taille : ' . $this->getStock()->getSize() . ', couleur : ' . $this->getStock()->getColor() . ") x $this->quantity";
    }
}
