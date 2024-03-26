<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\StockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


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
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:stocks', 'read:stock', 'read:articles', 'read:article'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['read:stocks', 'read:stock', 'read:articles', 'read:article', 'write:order'])]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'stocks')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:stocks', 'read:stock', 'write:order'])]
    private ?Article $article = null;

    #[ORM\ManyToMany(targetEntity: Order::class, mappedBy: 'stock')]
    #[Groups(['read:stocks', 'read:stock', 'read:articles', 'read:article', 'write:order'])]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
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

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->addStock($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            $order->removeStock($this);
        }

        return $this;
    }
    
    public function __toString(): string
    {
        return $this->quantity;
    }
}
