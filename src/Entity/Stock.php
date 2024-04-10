<?php

namespace App\Entity;

use App\Traits\SizeTrait;
use App\Traits\PriceTrait;
use ApiPlatform\Metadata\Get;
use App\Traits\QuantityTrait;
use App\Traits\DateEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\StockRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StockRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:stocks', 'read:stock']],
    denormalizationContext: ['groups' => ['stock:write']],
    operations: [
        new Get(normalizationContext: ['groups' => 'stock:item']),
        new GetCollection(normalizationContext: ['groups' => 'stock:list']),
    ],
    order: ['year' => 'DESC', 'city' => 'ASC'],
    paginationEnabled: false,
)]
class Stock
{
    use DateEntityTrait;
    use PriceTrait;
    use QuantityTrait;
    use SizeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:stocks', 'read:stock', 'read:articles', 'read:article', 'read:date'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'stocks')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:stocks', 'read:stock', 'write:order'])]
    #[Assert\Valid]
    private ?Article $article = null;

    #[ORM\ManyToOne(inversedBy: 'stocks')]
    private ?Order $orders = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }


    public function __toString(): string
    {
        return $this->article->getName().'-'.$this->size.'-'.$this->price.'€';
    }

    public function getOrders(): ?Order
    {
        return $this->orders;
    }

    public function setOrders(?Order $orders): static
    {
        $this->orders = $orders;

        return $this;
    }
}
